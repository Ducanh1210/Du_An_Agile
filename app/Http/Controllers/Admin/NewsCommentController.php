<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsComment;
use Illuminate\Http\Request;

class NewsCommentController extends Controller
{
    public function index()
    {
        $comments = NewsComment::with(['news', 'user'])->latest()->paginate(15);
        return view('admin.news_comments.index', compact('comments'));
    }

    public function toggleApproval($id)
    {
        $comment = NewsComment::findOrFail($id);
        $comment->is_approved = !$comment->is_approved;
        $comment->save();

        return back()->with('success', 'Cập nhật trạng thái bình luận thành công!');
    }

    public function delete($id)
    {
        NewsComment::findOrFail($id)->delete();
        return back()->with('success', 'Đã xóa bình luận thành công!');
    }
}
