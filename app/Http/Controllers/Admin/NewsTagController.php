<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsTag;
use Illuminate\Http\Request;

class NewsTagController extends Controller
{
    public function index()
    {
        $tags = NewsTag::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.news.tags.index', compact('tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:news_tags,name',
        ]);

        NewsTag::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.news.tags.index')->with('success', 'Hashtag đã được thêm thành công!');
    }

    public function delete($id)
    {
        $tag = NewsTag::findOrFail($id);
        $tag->delete();

        return redirect()->route('admin.news.tags.index')->with('success', 'Hashtag đã được xóa!');
    }
}
