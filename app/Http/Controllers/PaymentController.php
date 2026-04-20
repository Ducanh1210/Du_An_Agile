<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Models\Subscription;
use App\Models\Payment;
use App\Services\VnpayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    protected $vnpayService;

    public function __construct(VnpayService $vnpayService)
    {
        $this->vnpayService = $vnpayService;
    }

    /**
     * Trang tóm tắt đơn hàng (Checkout)
     */
    public function checkout(Request $request)
    {
        $packageId = $request->query('package');
        $membership = Membership::findOrFail($packageId);

        return view('client.checkout', compact('membership'));
    }

    /**
     * Khởi tạo thanh toán VNPay
     */
    public function createPayment(Request $request)
    {
        $request->validate([
            'membership_id' => 'required|exists:memberships,id',
        ]);

        $user = Auth::user();
        $membership = Membership::findOrFail($request->membership_id);

        try {
            DB::beginTransaction();

            // 1. Tạo bản ghi Subscription ở trạng thái chờ thanh toán
            $subscription = Subscription::create([
                'user_id' => $user->id,
                'membership_id' => $membership->id,
                'start_date' => now(),
                'end_date' => now()->addDays($membership->duration_days),
                'final_price' => $membership->price,
                'pt_sessions_left' => $membership->pt_sessions ?? 0,
                'status' => 'pending_payment',
            ]);

            // 2. Tạo bản ghi Payment
            $payment = Payment::create([
                'subscription_id' => $subscription->id,
                'amount' => $membership->price,
                'method' => 'e_wallet',
                'status' => 'pending',
                'invoice_code' => 'VNP' . time(),
            ]);

            DB::commit();

            // 3. Tạo URL thanh toán VNPay
            $paymentUrl = $this->vnpayService->createPaymentUrl([
                'order_id' => $payment->invoice_code,
                'order_desc' => 'Thanh toan goi tap: ' . $membership->name,
                'amount' => $membership->price,
            ]);

            return redirect()->to($paymentUrl);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Xử lý kết quả trả về từ VNPay (Return URL)
     * Route này KHÔNG yêu cầu auth vì VNPay cross-site redirect có thể mất session
     */
    public function vnpayReturn(Request $request)
    {
        $inputData = $request->all();
        
        if ($this->vnpayService->verifyReturn($inputData)) {
            $invoiceCode = $inputData['vnp_TxnRef'];
            $vnp_ResponseCode = $inputData['vnp_ResponseCode'];
            
            $payment = Payment::where('invoice_code', $invoiceCode)->first();

            if (!$payment) {
                return redirect()->route('client.memberships')->with('error', 'Không tìm thấy thông tin đơn hàng.');
            }

            if ($vnp_ResponseCode == '00') {
                // Thanh toán thành công
                if ($payment->status !== 'completed') {
                    $payment->update(['status' => 'completed']);
                    $payment->subscription->update(['status' => 'active']);
                }
                
                // Đảm bảo người dùng được đăng nhập (nếu chẳng may bị mất session khi redirect từ VNPay)
                if (!Auth::check()) {
                    Auth::login($payment->subscription->user);
                }
                
                return redirect()->route('client.payment_history')->with('success', 'Thanh toán thành công! Gói tập của bạn đã được kích hoạt.');
            } else {
                // Thanh toán thất bại hoặc khách chủ động hủy trên cổng VNPay
                if ($payment->status === 'pending') {
                    $payment->update(['status' => 'cancelled', 'note' => 'Người dùng hủy thanh toán hoặc giao dịch thất bại.']);
                    $payment->subscription->update(['status' => 'cancelled', 'cancel_reason' => 'Thanh toán VNPay không thành công.']);
                }

                return redirect()->route('client.memberships')->with('error', 'Thanh toán không thành công hoặc đã bị hủy.');
            }
        }

        return redirect()->route('client.memberships')->with('error', 'Chữ ký không hợp lệ.');
    }
}
