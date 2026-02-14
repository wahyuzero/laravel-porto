<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Project;
use App\Models\Comment;
use App\Models\Subscriber;
use App\Models\PageView;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ExportController extends Controller
{
    public function index()
    {
        return view('admin.export.index');
    }

    public function download(Request $request)
    {
        $type = $request->input('type', 'blog');

        switch ($type) {
            case 'blog':
                return $this->exportCsv(
                    'blog_posts.csv',
                    ['id', 'title', 'slug', 'excerpt', 'is_published', 'views_count', 'published_at', 'created_at'],
                    BlogPost::all()->map(fn($p) => [$p->id, $p->title, $p->slug, $p->excerpt, $p->is_published, $p->views_count, $p->published_at, $p->created_at])
                );
            case 'projects':
                return $this->exportCsv(
                    'projects.csv',
                    ['id', 'title', 'slug', 'description', 'status', 'year', 'tech_stack', 'created_at'],
                    Project::all()->map(fn($p) => [$p->id, $p->title, $p->slug, $p->description, $p->status, $p->year, implode(';', $p->tech_stack), $p->created_at])
                );
            case 'comments':
                return $this->exportCsv(
                    'comments.csv',
                    ['id', 'blog_post_id', 'author_name', 'author_email', 'content', 'is_approved', 'created_at'],
                    Comment::all()->map(fn($c) => [$c->id, $c->blog_post_id, $c->author_name, $c->author_email, $c->content, $c->is_approved, $c->created_at])
                );
            case 'subscribers':
                return $this->exportCsv(
                    'subscribers.csv',
                    ['id', 'email', 'is_verified', 'created_at'],
                    Subscriber::all()->map(fn($s) => [$s->id, $s->email, $s->is_verified, $s->created_at])
                );
            case 'analytics':
                return $this->exportCsv(
                    'page_views.csv',
                    ['id', 'url', 'page_title', 'referrer', 'viewed_date', 'created_at'],
                    PageView::latest()->take(1000)->get()->map(fn($v) => [$v->id, $v->url, $v->page_title, $v->referrer, $v->viewed_date, $v->created_at])
                );
            default:
                return back()->with('error', 'Unknown export type.');
        }
    }

    private function exportCsv(string $filename, array $headers, $rows): Response
    {
        $output = implode(',', $headers) . "\n";
        foreach ($rows as $row) {
            $output .= implode(',', array_map(fn($v) => '"' . str_replace('"', '""', $v ?? '') . '"', $row)) . "\n";
        }

        return response($output, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ]);
    }
}
