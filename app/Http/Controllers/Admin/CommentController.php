<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::with('blogPost')
            ->latest()
            ->paginate(20);
        return view('admin.comments.index', compact('comments'));
    }

    public function approve(Comment $comment)
    {
        $comment->update(['is_approved' => true]);
        return back()->with('success', 'Comment approved.');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return back()->with('success', 'Comment deleted.');
    }

    public function bulk(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:comments,id',
            'action' => 'required|in:approve,delete',
        ]);

        $count = count($validated['ids']);

        if ($validated['action'] === 'approve') {
            Comment::whereIn('id', $validated['ids'])->update(['is_approved' => true]);
            return back()->with('success', "{$count} comments approved.");
        }

        Comment::whereIn('id', $validated['ids'])->delete();
        return back()->with('success', "{$count} comments deleted.");
    }
}
