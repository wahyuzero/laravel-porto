<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\BlogPost;
use App\Models\ContactMessage;
use App\Models\GuestBookEntry;
use App\Models\SiteSetting;
use App\Models\PageView;
use App\Models\Subscriber;
use App\Models\Comment;

class DashboardController extends Controller
{
    public function index()
    {
        // Chart: page views per day (last 7 days)
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $chartData[] = [
                'label' => now()->subDays($i)->format('M d'),
                'views' => PageView::whereDate('viewed_at', $date)->count(),
            ];
        }

        return view('admin.dashboard', [
            'stats' => [
                'projects' => Project::count(),
                'blog_posts' => BlogPost::where('is_published', true)->count(),
                'drafts' => BlogPost::where('is_published', false)->count(),
                'unread_messages' => ContactMessage::where('is_read', false)->count(),
                'total_views' => BlogPost::sum('views_count'),
                'guestbook_pending' => GuestBookEntry::where('is_approved', false)->count(),
                'hit_counter' => SiteSetting::get('hit_counter', 0),
                'subscribers' => Subscriber::count(),
                'comments' => Comment::count(),
            ],
            'chartData' => $chartData,
            'recent_messages' => ContactMessage::latest()->take(5)->get(),
            'recent_posts' => BlogPost::latest('created_at')->take(5)->get(),
        ]);
    }
}
