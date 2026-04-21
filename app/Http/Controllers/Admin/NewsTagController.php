<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsTag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsTagController extends Controller
{
    public function index()
    {
        $tags = NewsTag::withCount('news')->latest()->paginate(10);
        return view('admin.news_tags.index', compact('tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        NewsTag::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . time()
        ]);

        return back()->with('success', 'Thêm thẻ (tag) thành công!');
    }

    public function delete($id)
    {
        NewsTag::findOrFail($id)->delete();
        return back()->with('success', 'Đã xóa thẻ (tag) thành công!');
    }
}
