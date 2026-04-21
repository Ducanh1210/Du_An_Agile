@extends('layouts.admin')

@section('title', 'Quản lý Hóa đơn Thanh toán')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Hóa đơn & Thanh toán</h2>
        <p class="text-slate-500 text-sm mt-1">Quản lý giao dịch, đơn hàng và phê duyệt thanh toán.</p>
    </div>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-gray-100 text-xs uppercase tracking-wider text-slate-500">
                    <th class="p-4 font-bold">Mã Hóa Đơn</th>
                    <th class="p-4 font-bold">Khách Hàng</th>
                    <th class="p-4 font-bold">Gói Tập</th>
                    <th class="p-4 font-bold">Số Tiền</th>
                    <th class="p-4 font-bold">Phương Thức</th>
                    <th class="p-4 font-bold text-center">Trạng Thái</th>
                    <th class="p-4 font-bold text-right">Ngày Tạo</th>
                    <th class="p-4 font-bold text-center">Hành Động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($payments as $payment)
                    <tr class="hover:bg-slate-50/50 transition duration-150">
                        <td class="p-4">
                            <span class="font-bold text-slate-800 text-sm">{{ $payment->invoice_code ?? '#'.$payment->id }}</span>
                        </td>
                        <td class="p-4">
                            <div class="text-sm font-semibold text-slate-900">{{ $payment->subscription->user->name ?? 'N/A' }}</div>
                            <div class="text-xs text-slate-500">{{ $payment->subscription->user->email ?? '' }}</div>
                        </td>
                        <td class="p-4">
                            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-gray-100 text-xs font-semibold text-slate-700">
                                @if(isset($payment->subscription->membership->category))
                                    @if($payment->subscription->membership->category == 'gym')
                                        <i class="fa-solid fa-dumbbell text-orange-500"></i>
                                    @else
                                        <i class="fa-solid fa-leaf text-purple-500"></i>
                                    @endif
                                @endif
                                {{ $payment->subscription->membership->name ?? 'Gói tùy chỉnh' }}
                            </div>
                        </td>
                        <td class="p-4 font-bold text-emerald-600 text-sm">
                            {{ number_format($payment->amount, 0, ',', '.') }}đ
                        </td>
                        <td class="p-4">
                            <span class="text-xs font-semibold px-2 py-1 rounded-lg bg-blue-50 text-blue-600 border border-blue-100 uppercase tracking-widest">
                                {{ strtoupper($payment->method) }}
                            </span>
                        </td>
                        <td class="p-4 text-center">
                            @if($payment->status === 'completed')
                                <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-xs font-bold border border-emerald-200">Đã thanh toán</span>
                            @elseif($payment->status === 'cancelled')
                                <span class="px-2.5 py-1 bg-red-100 text-red-700 rounded-lg text-xs font-bold border border-red-200">Đã hủy</span>
                            @else
                                <span class="px-2.5 py-1 bg-gray-100 text-gray-700 rounded-lg text-xs font-bold border border-gray-200">{{ ucfirst($payment->status) }}</span>
                            @endif
                        </td>
                        <td class="p-4 text-right text-sm text-slate-500">
                            {{ $payment->created_at ? $payment->created_at->format('d/m/Y H:i') : '' }}
                        </td>
                        <td class="p-4 text-center">
                            <!-- Nút mở Modal Chuyển trạng thái -->
                            <button type="button" class="w-8 h-8 rounded-xl bg-gray-100 text-slate-600 hover:bg-orange-600 hover:text-white transition-all flex items-center justify-center mx-auto" onclick="openStatusModal({{ $payment->id }}, '{{ $payment->status }}')">
                                <i class="fa-solid fa-pen-to-square text-sm"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="p-8 text-center text-slate-500">Không có dữ liệu giao dịch nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($payments->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $payments->links() }}
    </div>
    @endif
</div>

<!-- Modal Đổi Trạng Thái -->
<div id="statusModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/50 backdrop-blur-sm hidden" x-cloak>
    <div class="bg-white rounded-3xl shadow-xl w-full max-w-md overflow-hidden transform scale-95 opacity-0 transition-all duration-300" id="statusModalContent">
        <form id="statusForm" method="POST" action="">
            @csrf
            @method('PATCH')
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-lg font-bold text-slate-900 tracking-tight">Cập nhật Trạng thái HĐ</h3>
                <button type="button" onclick="closeStatusModal()" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            
            <div class="p-6">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Trạng thái mới</label>
                <select name="status" id="paymentStatus" class="w-full border-gray-300 rounded-xl focus:ring-primary focus:border-primary shadow-sm">
                    <option value="completed">Đã thanh toán (Completed)</option>
                    <option value="cancelled">Đã hủy (Cancelled)</option>
                </select>
            </div>
            
            <div class="px-6 py-4 bg-slate-50 border-t border-gray-100 flex justify-end gap-3 rounded-b-3xl">
                <button type="button" onclick="closeStatusModal()" class="px-5 py-2.5 rounded-xl border border-gray-300 text-slate-600 font-semibold text-sm hover:bg-gray-100 transition-colors">
                    Hủy
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-primary text-white font-semibold text-sm shadow-md hover:bg-orange-700 transition-colors">
                    Lưu Thay Đổi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openStatusModal(id, currentStatus) {
        document.getElementById('statusForm').action = "/admin/payments/" + id + "/status";
        document.getElementById('paymentStatus').value = currentStatus;
        
        const modal = document.getElementById('statusModal');
        const modalContent = document.getElementById('statusModalContent');
        
        modal.classList.remove('hidden');
        // Small delay for CSS transition
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeStatusModal() {
        const modal = document.getElementById('statusModal');
        const modalContent = document.getElementById('statusModalContent');
        
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }
</script>
@endsection
