@extends(auth()->user()->role === 'staff' ? 'layouts.staff' : 'layouts.admin')

@section('title', 'Quản lý Bình luận')

@section('content')
<div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
    {{-- Header --}}
    <div class="px-8 py-6 border-b border-gray-50 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-900 tracking-tight">Quản lý Bình luận</h2>
            <p class="text-sm text-slate-400 mt-0.5">Duyệt và kiểm soát các phản hồi từ người dùng</p>
        </div>
        <div class="flex gap-3">
             <div class="px-4 py-2 bg-slate-50 border border-slate-100 rounded-xl text-xs font-bold text-slate-500">
                Tổng: {{ $comments->total() }}
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="mx-8 mt-6 px-5 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl text-sm font-semibold flex items-center gap-2">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>
    @endif

    {{-- List --}}
    <div class="overflow-x-auto">
        <table class="w-full text-left whitespace-nowrap">
            <thead>
                <tr class="bg-slate-50/50">
                    <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-[.2em]">Người gửi</th>
                    <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-[.2em]">Nội dung & Bài viết</th>
                    <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-[.2em]">Trạng thái</th>
                    <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-[.2em]">Thời gian</th>
                    <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-[.2em] text-center">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($comments as $comment)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-8 py-5">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-orange-100 flex items-center justify-center text-orange-600 border border-orange-200 uppercase font-bold text-xs ring-4 ring-orange-50/50">
                                {{ substr($comment->user->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="text-sm font-bold text-slate-900 leading-none mb-1">{{ $comment->user->name }}</div>
                                <div class="text-[10px] text-slate-400 font-medium">{{ $comment->user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-5">
                        <div class="text-sm text-slate-800 line-clamp-1 max-w-sm font-medium mb-1">"{{ $comment->content }}"</div>
                        <div class="flex items-center gap-1.5">
                            <i class="fa-solid fa-link text-[10px] text-slate-300"></i>
                            <a href="{{ route('news.detail', $comment->news->slug) }}" target="_blank" class="text-[11px] text-slate-400 hover:text-orange-500 underline transition-colors">{{ $comment->news->title }}</a>
                        </div>
                    </td>
                    <td class="px-8 py-5">
                        @if($comment->is_approved)
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-100 uppercase tracking-wider">
                            <i class="fa-solid fa-check mr-1.5"></i> Đã duyệt
                        </span>
                        @else
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold bg-amber-50 text-amber-600 border border-amber-100 uppercase tracking-wider">
                            <i class="fa-solid fa-clock mr-1.5"></i> Đang ẩn
                        </span>
                        @endif
                    </td>
                    <td class="px-8 py-5 text-sm text-slate-500 font-medium">
                        {{ $comment->created_at->diffForHumans() }}
                    </td>
                    <td class="px-8 py-5">
                        <div class="flex items-center justify-center gap-2">
                            <form action="{{ route('admin.news.comments.toggle', $comment->id) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="w-9 h-9 rounded-xl flex items-center justify-center transition-all duration-300 {{ $comment->is_approved ? 'bg-amber-50 text-amber-600 hover:bg-amber-600 hover:text-white' : 'bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white' }}"
                                        title="{{ $comment->is_approved ? 'Ẩn bình luận' : 'Hiện bình luận' }}">
                                    <i class="fa-solid {{ $comment->is_approved ? 'fa-eye-slash' : 'fa-eye' }} text-sm"></i>
                                </button>
                            </form>
                            <form action="{{ route('admin.news.comments.delete', $comment->id) }}" method="POST" onsubmit="return confirm('Xác nhận xóa bình luận này?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-9 h-9 rounded-xl bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition-all duration-300">
                                    <i class="fa-solid fa-trash-can text-sm"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-8 py-16 text-center">
                        <i class="fa-solid fa-comment-slash text-4xl text-slate-200 mb-2"></i>
                        <p class="text-slate-400 font-medium">Chưa có bình luận nào</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($comments->hasPages())
    <div class="px-8 py-5 bg-slate-50/50 border-t border-gray-100">
        {{ $comments->links() }}
    </div>
    @endif
</div>
@endsection

