<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    /**
     * Danh sách tin tức
     */
    public function index()
    {
        $news = News::with(['author', 'category'])->latest()->paginate(10);
        return view('admin.news.index', compact('news'));
    }

    /**
     * Form tạo mới
     */
    public function create()
    {
        $categories = NewsCategory::all();
        return view('admin.news.create', compact('categories'));
    }

    /**
     * Lưu tin tức mới
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'             => 'required|string|max:255',
            'content'           => 'required|string',
            'excerpt'           => 'nullable|string|max:500',
            'image'             => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'category_id'       => 'nullable|exists:news_categories,id',
            'news_status'       => 'required|in:draft,pending,published,hidden',
            'is_featured'       => 'nullable|boolean',
            'title_font_family' => 'nullable|string|max:255',
            'title_font_size'   => 'nullable|string|max:255',
            'meta_title'        => 'nullable|string|max:255',
            'meta_description'  => 'nullable|string|max:500',
            'tags_list'         => 'nullable|string|max:255',
        ]);

        $validated['slug']      = Str::slug($validated['title']) . '-' . time();
        $validated['author_id'] = Auth::id();
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['published_at'] = ($validated['news_status'] === 'published') ? now() : null;

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('news', 'public');
        }

        News::create($validated);

        return redirect()->route('admin.news.index')
            ->with('success', 'Tạo tin tức thành công!');
    }

    /**
     * Form chỉnh sửa
     */
    public function edit($id)
    {
        $news = News::findOrFail($id);
        $categories = NewsCategory::all();
        return view('admin.news.edit', compact('news', 'categories'));
    }

    /**
     * Cập nhật tin tức
     */
    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);

        $validated = $request->validate([
            'title'             => 'required|string|max:255',
            'content'           => 'required|string',
            'excerpt'           => 'nullable|string|max:500',
            'image'             => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'category_id'       => 'nullable|exists:news_categories,id',
            'news_status'       => 'required|in:draft,pending,published,hidden',
            'is_featured'       => 'nullable|boolean',
            'title_font_family' => 'nullable|string|max:255',
            'title_font_size'   => 'nullable|string|max:255',
            'meta_title'        => 'nullable|string|max:255',
            'meta_description'  => 'nullable|string|max:500',
            'tags_list'         => 'nullable|string|max:255',
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');
        if ($validated['news_status'] === 'published' && !$news->published_at) {
            $validated['published_at'] = now();
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('news', 'public');
        }

        $news->update($validated);

        return redirect()->route('admin.news.index')
            ->with('success', 'Cập nhật tin tức thành công!');
    }

    /**
     * Xóa tin tức
     */
    public function delete($id)
    {
        $news = News::findOrFail($id);
        $news->delete();
        return back()->with('success', 'Đã xóa tin tức thành công!');
    }
}
