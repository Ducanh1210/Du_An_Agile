@extends('layouts.admin')

@section('title', 'Quản lý Bình luận Tin tức')

@section('content')
<div class="space-y-6">
    <!-- Header Area -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Bình luận Tin tức</h2>
            <p class="text-sm text-slate-500 mt-1">Quản lý và duyệt bình luận của độc giả</p>
        </div>
    </div>

    <!-- Comments List -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-gray-100">
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Người bình luận</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Nội dung</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Bài viết</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Trạng thái</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($comments as $comment)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $comment->user->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($comment->user->name ?? 'User').'&background=random' }}" class="w-10 h-10 rounded-full object-cover">
                                    <div>
                                        <div class="font-bold text-sm text-slate-800">{{ $comment->user->name ?? 'N/A' }}</div>
                                        <div class="text-xs text-slate-500">{{ $comment->created_at->format('H:i d/m/Y') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-slate-600 line-clamp-2 max-w-xs">{{ $comment->content }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-slate-800 line-clamp-1 max-w-[200px]">{{ $comment->news->title ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @if($comment->is_approved)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Đã duyệt
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Chờ duyệt
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <form action="{{ route('admin.news.comments.toggle', $comment->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" class="w-8 h-8 rounded-lg {{ $comment->is_approved ? 'bg-amber-50 text-amber-600 hover:bg-amber-100' : 'bg-green-50 text-green-600 hover:bg-green-100' }} transition-colors inline-flex items-center justify-center" title="{{ $comment->is_approved ? 'Ẩn bình luận' : 'Duyệt bình luận' }}">
                                        <i class="fa-solid {{ $comment->is_approved ? 'fa-eye-slash' : 'fa-check' }} text-sm"></i>
                                    </button>
                                </form>
                                
                                <form action="{{ route('admin.news.comments.delete', $comment->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bình luận này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition-colors inline-flex items-center justify-center">
                                        <i class="fa-solid fa-trash-can text-sm"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fa-regular fa-comments text-4xl text-slate-300 mb-3"></i>
                                    <p>Chưa có bình luận nào.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($comments->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $comments->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
