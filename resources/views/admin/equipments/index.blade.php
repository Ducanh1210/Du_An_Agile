@extends('layouts.admin')

@section('title', 'Quản lý Dụng cụ Phòng tập')

@section('content')
<div class="mb-6 flex justify-between items-center z-10 relative">
    <div>
        <h2 class="text-2xl font-bold text-slate-900 tracking-tight uppercase">Danh sách Dụng cụ</h2>
        <p class="text-sm text-slate-500 mt-1 uppercase tracking-widest">Kiểm soát trạng thái và bảo trì thiết bị</p>
    </div>
    <a href="{{ route('equipments.create') }}" class="bg-orange-600 hover:bg-orange-700 text-white px-5 py-2.5 rounded-xl font-medium transition-all shadow-lg shadow-orange-600/30 flex items-center gap-2 uppercase tracking-widest text-sm hover:-translate-y-0.5">
        <i class="fa-solid fa-plus"></i>
        <span>Thêm Dụng Cụ</span>
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative z-10">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-gray-100 uppercase tracking-widest text-xs text-slate-500">
                    <th class="px-6 py-4 font-semibold">Tên Dụng cụ</th>
                    <th class="px-6 py-4 font-semibold">Mô tả</th>
                    <th class="px-6 py-4 font-semibold">Trạng thái</th>
                    <th class="px-6 py-4 font-semibold">Bảo trì lần cuối</th>
                    <th class="px-6 py-4 font-semibold text-right">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($equipments as $equipment)
                <tr class="hover:bg-slate-50/50 transition-colors group">
                    <td class="px-6 py-4 font-medium text-slate-900">{{ $equipment->name }}</td>
                    <td class="px-6 py-4 text-slate-600 truncate max-w-xs">{{ $equipment->description ?? 'Không có mô tả' }}</td>
                    <td class="px-6 py-4">
                        @if($equipment->status == 'active')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-green-100 text-green-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> HOẠT ĐỘNG
                            </span>
                        @elseif($equipment->status == 'maintenance')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-amber-100 text-amber-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 hover:animate-ping"></span> BẢO TRÌ
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-red-100 text-red-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> HỎNG
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-slate-500">
                        {{ $equipment->last_maintained_at ? \Carbon\Carbon::parse($equipment->last_maintained_at)->format('d/m/Y') : 'Chưa từng' }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex justify-end gap-2 opacity-100 transition-opacity">
                            <a href="{{ route('equipments.edit', $equipment->id) }}" class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center hover:bg-indigo-600 hover:text-white transition-colors">
                                <i class="fa-regular fa-pen-to-square text-xs"></i>
                            </a>
                            <form action="{{ route('equipments.delete', $equipment->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa dụng cụ này?');" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition-colors">
                                    <i class="fa-regular fa-trash-can text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 mb-4 text-slate-400 text-2xl">
                            <i class="fa-solid fa-dumbbell"></i>
                        </div>
                        <p class="text-slate-500 font-medium">Chưa có dụng cụ nào được thêm.</p>
                        <a href="{{ route('equipments.create') }}" class="text-orange-600 hover:text-orange-700 font-medium mt-2 inline-block">Thêm ngay &rarr;</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($equipments->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $equipments->links() }}
    </div>
    @endif
</div>
@endsection
