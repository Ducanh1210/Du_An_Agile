<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentManagementController extends Controller
{
    /**
     * Danh sách hóa đơn / thanh toán
     */
    public function index()
    {
        $payments = Payment::with(['subscription.user', 'subscription.membership'])
            ->latest('id')
            ->paginate(15);
            
        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Cập nhật trạng thái thanh toán
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:completed,cancelled'
        ]);

        $payment = Payment::findOrFail($id);

        // Chặn cập nhật nếu đã hoàn thành hoặc đã hủy (TC33)
        if (in_array($payment->status, ['completed', 'cancelled'])) {
            return back()->with('error', 'Hóa đơn này đã được xử lý (Hoàn thành/Hủy) và không thể thay đổi trạng thái.');
        }

        $payment->status = $request->status;
        $payment->confirmed_by = auth()->id();
        $payment->save();

        return back()->with('success', 'Đã cập nhật trạng thái hóa đơn ' . $payment->invoice_code);
    }
}
