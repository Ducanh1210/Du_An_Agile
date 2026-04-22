@extends('layouts.client')

@section('title', $news->title . ' - EXTRA FIT+')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/blog.css') }}">
<style>
    /* --- Article Detail Specifics --- */
    .article-header {
        position: relative;
        padding: 120px 0 60px;
        background: #0f172a;
        color: #fff;
        text-align: center;
    }
    .article-meta-large {
        display: flex;
        justify-content: center;
        gap: 30px;
        margin-top: 20px;
        font-size: 14px;
        font-weight: 600;
        color: rgba(255,255,255,0.5);
    }
    .article-content-wrap {
        margin-top: -80px;
        position: relative;
        z-index: 10;
    }
    .article-main-card {
        background: var(--color-surface);
        border: 1px solid var(--color-border);
        border-radius: 40px;
        padding: 60px;
        box-shadow: 0 30px 60px rgba(0,0,0,0.05);
    }
    .article-content {
        font-size: 18px;
        line-height: 1.8;
        color: var(--color-text-soft);
    }
    .article-content h2, .article-content h3 {
        color: var(--color-text);
        font-weight: 900;
        margin: 40px 0 20px;
        text-transform: uppercase;
        letter-spacing: -0.5px;
    }
    .article-content p {
        margin-bottom: 25px;
    }
    .article-content img {
        border-radius: 24px;
        margin: 40px 0;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }
    .author-box {
        background: var(--color-bg-soft);
        border-radius: 24px;
        padding: 30px;
        display: flex;
        gap: 20px;
        align-items: center;
        margin-top: 60px;
    }
    /* --- Related Section --- */
    .section-title-premium {
        font-size: 24px;
        font-weight: 900;
        text-transform: uppercase;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .section-title-premium::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--color-border);
    }
</style>
@endsection

@section('content')
{{-- --- Article Header --- --}}
<header class="article-header">
    <div class="container mx-auto px-4 max-w-4xl">
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-black uppercase leading-tight mb-6">
            {{ $news->title }}
        </h1>
        <div class="article-meta-large">
            <span><i class="fa-solid fa-calendar-days text-primary mr-2"></i> {{ $news->published_at ? $news->published_at->format('d/m/Y') : $news->created_at->format('d/m/Y') }}</span>
            <span><i class="fa-solid fa-eye text-primary mr-2"></i> {{ number_format($news->views) }} Lượt xem</span>
        </div>
    </div>
</header>

<main class="news-container pt-0">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto article-content-wrap">
            <article class="article-main-card">
                {{-- Featured Image --}}
                @if($news->image)
                <div class="mb-12">
                    <img src="{{ asset('storage/' . $news->image) }}" class="w-full max-h-[400px] object-cover rounded-[2.5rem] shadow-2xl shadow-slate-900/10" alt="{{ $news->title }}">
                </div>
                @endif

                {{-- Body content --}}
                <div class="article-content prose prose-orange max-w-none">
                    {!! $news->content !!}
                </div>

                {{-- Tags list --}}
                @if($news->tags_list)
                <div class="mt-12 flex flex-wrap gap-2 pt-8 border-t border-slate-100">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest mr-2 flex items-center">Tags:</span>
                    @foreach(array_map('trim', explode(',', $news->tags_list)) as $tag)
                    <a href="{{ route('news', ['tag' => $tag]) }}" 
                       class="px-4 py-1.5 bg-slate-50 hover:bg-primary/10 border border-slate-100 hover:border-primary/30 rounded-full text-xs font-bold text-slate-600 hover:text-primary transition-all">
                        #{{ $tag }}
                    </a>
                    @endforeach
                </div>
                @endif

                {{-- Comments Section --}}
                <div class="mt-16">
                    <h3 class="section-title-premium">Bình luận ({{ $news->comments_count ?? 0 }})</h3>

                    @if(session('success'))
                    <div class="bg-emerald-50 border border-emerald-100 text-emerald-700 px-6 py-4 rounded-2xl mb-8 font-bold text-sm">
                        <i class="fa-solid fa-check-circle mr-2"></i> {{ session('success') }}
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="bg-red-50 border border-red-100 text-red-700 px-6 py-4 rounded-2xl mb-8 font-bold text-sm">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @auth
                    <form action="{{ route('news.comment.store', $news->id) }}" method="POST" class="mb-12">
                        @csrf
                        <div class="bg-slate-50 p-6 rounded-3xl border border-slate-100">
                            <textarea name="content" rows="4" class="w-full bg-white border-none rounded-2xl p-5 text-slate-700 focus:ring-2 focus:ring-primary/20 outline-none transition-all" placeholder="Chia sẻ suy nghĩ của bạn..."></textarea>
                            <div class="flex justify-end mt-4">
                                <button type="submit" class="bg-primary hover:bg-orange-700 text-white px-8 py-3 rounded-xl font-bold uppercase text-xs tracking-widest transition-all">
                                    Gửi bình luận
                                </button>
                            </div>
                        </div>
                    </form>
                    @else
                    <div class="bg-orange-50 border border-orange-100 p-8 rounded-3xl text-center mb-12">
                        <p class="text-orange-900 font-bold mb-4">Bạn cần đăng nhập để tham gia thảo luận</p>
                        <a href="{{ route('login') }}" class="inline-block bg-orange-600 text-white px-8 py-3 rounded-xl font-bold uppercase text-xs tracking-widest">Đăng nhập ngay</a>
                    </div>
                    @endauth

                    <div class="space-y-8">
                        @forelse($news->approvedComments as $comment)
                        <div class="flex gap-5">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name) }}&background=ddd&color=333" class="w-12 h-12 rounded-xl flex-shrink-0">
                            <div class="flex-1">
                                <div class="bg-white border border-slate-100 p-5 rounded-2xl rounded-tl-none relative shadow-sm">
                                    <h5 class="font-bold text-slate-900 text-sm mb-1">{{ $comment->user->name }}</h5>
                                    <p class="text-slate-600 text-[15px] leading-relaxed">{{ $comment->content }}</p>
                                    <span class="text-[10px] uppercase font-bold text-slate-400 mt-3 block">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                        @empty
                        <p class="text-center text-slate-400 italic">Chưa có bình luận nào. Hãy là người đầu tiên!</p>
                        @endforelse
                    </div>
                </div>
            </article>

            {{-- Related News --}}
            <div class="mt-20">
                <h3 class="section-title-premium">Bài viết liên quan</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-8">
                    @foreach($relatedNews as $rPost)
                    <div class="group">
                        <div class="h-32 rounded-2xl overflow-hidden mb-4 relative">
                            <img src="{{ asset('storage/' . $rPost->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        </div>
                        <h4 class="font-bold text-slate-900 group-hover:text-primary transition-colors leading-tight">
                            <a href="{{ route('news.detail', $rPost->slug) }}">{{ $rPost->title }}</a>
                        </h4>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
