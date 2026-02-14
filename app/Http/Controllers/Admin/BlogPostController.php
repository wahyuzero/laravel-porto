<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Helpers\HtmlSanitizer;
use App\Models\ActivityLog;

class BlogPostController extends Controller
{
    public function index()
    {
        $posts = BlogPost::with('tags')->latest('created_at')->get();
        return view('admin.blog.index', compact('posts'));
    }

    public function create()
    {
        $tags = Tag::orderBy('name')->get();
        return view('admin.blog.create', compact('tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content_md' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'is_published' => 'boolean',
            'scheduled_at' => 'nullable|date|after:now',
            'tags' => 'nullable|string',
        ]);

        try {
            $validated['slug'] = Str::slug($validated['title']);
            $validated['user_id'] = auth()->id();
            $validated['content_html'] = HtmlSanitizer::clean(Str::markdown($validated['content_md']));
            $validated['is_published'] = $request->boolean('is_published');
            $validated['reading_time'] = max(1, (int) ceil(str_word_count($validated['content_md']) / config('wxsys.reading_time.wpm', 200)));

            // Handle scheduling
            if (!empty($validated['scheduled_at'])) {
                $validated['is_published'] = false;
                $validated['published_at'] = null;
            } elseif ($validated['is_published']) {
                $validated['published_at'] = now();
            }

            $post = BlogPost::create($validated);
            $this->syncTags($post, $request->input('tags', ''));

            return redirect()->route('admin.blog.index')->with('success', 'Post created.');
        } catch (\Exception $e) {
            Log::error('Blog post creation failed: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to create post: ' . $e->getMessage());
        }
    }

    public function show(BlogPost $blog)
    {
        // Preview route for draft posts
        return view('blog.show', ['post' => $blog]);
    }

    public function edit(BlogPost $blog)
    {
        $tags = Tag::orderBy('name')->get();
        return view('admin.blog.edit', ['post' => $blog, 'tags' => $tags]);
    }

    public function update(Request $request, BlogPost $blog)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content_md' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'is_published' => 'boolean',
            'scheduled_at' => 'nullable|date',
            'tags' => 'nullable|string',
        ]);

        try {
            $validated['slug'] = Str::slug($validated['title']);
            $validated['content_html'] = HtmlSanitizer::clean(Str::markdown($validated['content_md']));
            $validated['is_published'] = $request->boolean('is_published');
            $validated['reading_time'] = max(1, (int) ceil(str_word_count($validated['content_md']) / config('wxsys.reading_time.wpm', 200)));

            // Handle scheduling
            if (!empty($validated['scheduled_at'])) {
                $validated['is_published'] = false;
            } elseif ($validated['is_published'] && !$blog->published_at) {
                $validated['published_at'] = now();
            }

            $blog->update($validated);
            $this->syncTags($blog, $request->input('tags', ''));

            return redirect()->route('admin.blog.index')->with('success', 'Post updated.');
        } catch (\Exception $e) {
            Log::error('Blog post update failed: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to update post: ' . $e->getMessage());
        }
    }

    public function destroy(BlogPost $blog)
    {
        try {
            $blog->tags()->detach();
            $blog->delete();
            return redirect()->route('admin.blog.index')->with('success', 'Post deleted.');
        } catch (\Exception $e) {
            Log::error('Blog post deletion failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete post.');
        }
    }

    public function bulk(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:blog_posts,id',
            'action' => 'required|in:publish,unpublish,delete',
        ]);

        $posts = BlogPost::whereIn('id', $validated['ids']);
        $count = $posts->count();

        switch ($validated['action']) {
            case 'publish':
                $posts->update(['is_published' => true, 'published_at' => now()]);
                return back()->with('success', "{$count} posts published.");
            case 'unpublish':
                $posts->update(['is_published' => false]);
                return back()->with('success', "{$count} posts unpublished.");
            case 'delete':
                BlogPost::whereIn('id', $validated['ids'])->each(function ($p) {
                    $p->tags()->detach();
                    $p->delete();
                });
                return back()->with('success', "{$count} posts deleted.");
        }

        return back();
    }

    private function syncTags(BlogPost $post, string $tagsString): void
    {
        $tagNames = array_filter(array_map('trim', explode(',', $tagsString)));
        $tagIds = [];
        foreach ($tagNames as $name) {
            $tag = Tag::firstOrCreate(['slug' => Str::slug($name)], ['name' => $name]);
            $tagIds[] = $tag->id;
        }
        $post->tags()->sync($tagIds);
    }

    public function preview(BlogPost $post)
    {
        $comments = collect();
        $relatedPosts = collect();
        $previousPost = null;
        $nextPost = null;
        return view('blog.show', compact('post', 'comments', 'relatedPosts', 'previousPost', 'nextPost'));
    }
}
