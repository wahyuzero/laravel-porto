<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $posts = BlogPost::published()->latest()->with('tags')->paginate(10);
        return view('blog.index', compact('posts'));
    }

    public function byTag(string $tag)
    {
        $posts = BlogPost::published()->latest()
            ->whereHas('tags', fn($q) => $q->where('name', $tag))
            ->with('tags')
            ->paginate(10);
        return view('blog.index', compact('posts', 'tag'));
    }

    public function show(string $slug)
    {
        $post = BlogPost::where('slug', $slug)->published()->with('tags')->firstOrFail();
        $post->incrementViews();

        $comments = $post->comments()
            ->approved()
            ->topLevel()
            ->with(['replies' => fn($q) => $q->approved()->oldest()])
            ->oldest()
            ->get();

        // Related posts: same tags, excluding current
        $relatedPosts = collect();
        if ($post->tags->count()) {
            $tagIds = $post->tags->pluck('id');
            $relatedPosts = BlogPost::published()
                ->where('id', '!=', $post->id)
                ->whereHas('tags', fn($q) => $q->whereIn('tags.id', $tagIds))
                ->with('tags')
                ->latest()
                ->take(3)
                ->get();
        }

        // Next/Prev navigation (chronological)
        $prevPost = BlogPost::published()
            ->where('published_at', '<', $post->published_at)
            ->orderByDesc('published_at')
            ->first(['title', 'slug']);
        $nextPost = BlogPost::published()
            ->where('published_at', '>', $post->published_at)
            ->orderBy('published_at')
            ->first(['title', 'slug']);

        return view('blog.show', compact('post', 'comments', 'relatedPosts', 'prevPost', 'nextPost'));
    }

    public function storeComment(Request $request, string $slug)
    {
        $post = BlogPost::where('slug', $slug)->published()->firstOrFail();

        $validated = $request->validate([
            'author_name' => 'required|string|max:100',
            'author_email' => 'required|email|max:255',
            'content' => 'required|string|max:2000',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        try {
            $post->comments()->create($validated);
            return back()->with('success', 'Comment submitted! It will appear after moderation.');
        } catch (\Exception $e) {
            \Log::error('Comment store error: ' . $e->getMessage());
            return back()->with('error', 'Failed to submit comment. Please try again.');
        }
    }
}
