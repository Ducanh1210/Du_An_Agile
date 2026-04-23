@extends('layouts.admin')

@section('title', 'Quản lý Đơn Xin Nghỉ Dạy')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Đơn Xin Nghỉ Dạy</h2>
        <p class="text-slate-500 text-sm mt-1">Duyệt hoặc từ chối yêu cầu xin nghỉ của huấn luyện viên.</p>
    </div>
    {{-- Summary badges --}}
    @php
        $pendingCount = $requests->where('status', 'pending')->count();
    @endphp
    @if($pendingCount > 0)
    <div class="flex items-center gap-2 bg-amber-50 border border-amber-200 rounded-2xl px-4 py-2.5">
        <i class="fa-solid fa-clock text-amber-500"></i>
        <span class="text-amber-700 font-bold text-sm">{{ $pendingCount }} đơn chờ duyệt</span>
    </div>
    @endif
</div>

@if(session('success'))
    <div class="mb-4 flex items-center gap-3 bg-emerald-50 border border-emerald-200 rounded-2xl px-4 py-3 text-emerald-700 text-sm font-medium">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="mb-4 flex items-center gap-3 bg-red-50 border border-red-200 rounded-2xl px-4 py-3 text-red-700 text-sm font-medium">
        <i class="fa-solid fa-circle-xmark"></i> {{ session('error') }}
    </div>
@endif

<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-gray-100 text-xs uppercase tracking-wider text-slate-500">
                    <th class="p-4 font-bold">Huấn luyện viên</th>
                    <th class="p-4 font-bold">Ca dạy</th>
                    <th class="p-4 font-bold">Lý do xin nghỉ</th>
                    <th class="p-4 font-bold text-center">Trạng thái</th>
                    <th class="p-4 font-bold">Ghi chú Admin</th>
                    <th class="p-4 font-bold text-right">Ngày Nộp</th>
                    <th class="p-4 font-bold text-center">Hành Động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($requests as $req)
                    @php
                        $isPT = $req->item_type === 'App\Models\Booking';
                        $item = $req->item;
                        $itemTime = $item ? \Carbon\Carbon::parse($item->start_time)->format('H:i d/m/Y') : 'N/A';
                        $itemLabel = $isPT ? 'PT Session' : 'Lớp nhóm';
                    @endphp
                    <tr class="hover:bg-slate-50/50 transition duration-150">
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-orange-100 flex items-center justify-center text-orange-600 font-bold text-sm">
                                    {{ mb_substr($req->trainer->user->name ?? '?', 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-slate-900">{{ $req->trainer->user->name ?? 'N/A' }}</div>
                                    <div class="text-xs text-slate-400">{{ $req->trainer->user->email ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <div class="flex flex-col gap-1">
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-xs font-bold w-fit
                                    {{ $isPT ? 'bg-orange-50 text-orange-600' : 'bg-blue-50 text-blue-600' }}">
                                    <i class="fa-solid {{ $isPT ? 'fa-person-running' : 'fa-users' }}" style="font-size:9px;"></i>
                                    {{ $itemLabel }}
                                </span>
                                <div class="text-sm font-semibold text-slate-800">{{ $itemTime }}</div>
                            </div>
                        </td>
                        <td class="p-4">
                            <p class="text-sm text-slate-600 max-w-xs">{{ $req->reason }}</p>
                        </td>
                        <td class="p-4 text-center">
                            @if($req->status === 'pending')
                                <span class="px-2.5 py-1 bg-amber-100 text-amber-700 rounded-lg text-xs font-bold border border-amber-200">Chờ duyệt</span>
                            @elseif($req->status === 'approved')
                                <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-xs font-bold border border-emerald-200">Đã duyệt</span>
                            @else
                                <span class="px-2.5 py-1 bg-red-100 text-red-700 rounded-lg text-xs font-bold border border-red-200">Từ chối</span>
                            @endif
                        </td>
                        <td class="p-4">
                            @if($req->admin_note)
                                <p class="text-sm text-slate-500 italic max-w-xs">{{ $req->admin_note }}</p>
                            @else
                                <span class="text-slate-300 text-sm">—</span>
                            @endif
                        </td>
                        <td class="p-4 text-right text-sm text-slate-500">
                            {{ $req->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="p-4 text-center">
                            @if($req->status === 'pending')
                                <button type="button"
                                    class="w-8 h-8 rounded-xl bg-gray-100 text-slate-600 hover:bg-primary hover:text-white transition-all flex items-center justify-center mx-auto"
                                    onclick="openResolveModal({{ $req->id }})">
                                    <i class="fa-solid fa-gavel text-sm"></i>
                                </button>
                            @else
                                <div class="text-center text-slate-300">
                                    <i class="fa-solid fa-check-circle"></i>
                                </div>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-12 text-center text-slate-500">
                            <i class="fa-regular fa-calendar-check text-4xl opacity-30 block mb-3"></i>
                            Không có đơn xin nghỉ nào.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($requests->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $requests->links() }}
    </div>
    @endif
</div>

{{-- Modal Duyệt / Từ chối --}}
<div id="resolveModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/50 backdrop-blur-sm hidden">
    <div class="bg-white rounded-3xl shadow-xl w-full max-w-md overflow-hidden transform scale-95 opacity-0 transition-all duration-300" id="resolveModalContent">
        <form id="resolveForm" method="POST" action="">
            @csrf
            @method('PATCH')
            <input type="hidden" name="status" id="resolveStatus" value="">

            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-lg font-bold text-slate-900 tracking-tight">Xử lý Đơn Xin Nghỉ</h3>
                <button type="button" onclick="closeResolveModal()" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Lý do từ chối <span class="text-slate-400 font-normal">(bắt buộc nếu từ chối)</span>
                    </label>
                    <textarea
                        name="admin_note"
                        id="adminNoteField"
                        rows="3"
                        placeholder="Nhập lý do từ chối cho HLV biết..."
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent resize-none"
                    ></textarea>
                </div>

                <div class="bg-amber-50 rounded-xl p-3 text-amber-700 text-xs flex gap-2 items-start">
                    <i class="fa-solid fa-triangle-exclamation mt-0.5"></i>
                    <span>Nếu <strong>Duyệt cho nghỉ</strong>, ca dạy sẽ bị hủy và học viên sẽ nhận thông báo ngay lập tức.</span>
                </div>
            </div>

            <div class="px-6 py-4 bg-slate-50 border-t border-gray-100 flex gap-3 rounded-b-3xl">
                <button type="button" onclick="submitResolve('rejected')"
                    class="flex-1 px-4 py-2.5 rounded-xl bg-red-500 text-white font-semibold text-sm hover:bg-red-600 transition-colors flex items-center justify-center gap-2">
                    <i class="fa-solid fa-ban"></i> Từ chối
                </button>
                <button type="button" onclick="submitResolve('approved')"
                    class="flex-1 px-4 py-2.5 rounded-xl bg-emerald-500 text-white font-semibold text-sm hover:bg-emerald-600 transition-colors flex items-center justify-center gap-2">
                    <i class="fa-solid fa-check"></i> Duyệt cho nghỉ
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openResolveModal(id) {
    document.getElementById('resolveForm').action = "/admin/leave-requests/" + id + "/resolve";
    document.getElementById('adminNoteField').value = '';
    document.getElementById('resolveStatus').value = '';

    const modal = document.getElementById('resolveModal');
    const content = document.getElementById('resolveModalContent');
    modal.classList.remove('hidden');
    setTimeout(() => {
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeResolveModal() {
    const modal = document.getElementById('resolveModal');
    const content = document.getElementById('resolveModalContent');
    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-95', 'opacity-0');
    setTimeout(() => modal.classList.add('hidden'), 300);
}

function submitResolve(status) {
    if (status === 'rejected') {
        const note = document.getElementById('adminNoteField').value.trim();
        if (!note) {
            alert('Vui lòng nhập lý do từ chối!');
            document.getElementById('adminNoteField').focus();
            return;
        }
    }
    document.getElementById('resolveStatus').value = status;
    document.getElementById('resolveForm').submit();
}

// Close on backdrop
document.getElementById('resolveModal').addEventListener('click', function(e) {
    if (e.target === this) closeResolveModal();
});
</script>
@endsection
