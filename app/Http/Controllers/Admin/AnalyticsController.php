<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageView;
use App\Models\Subscriber;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        // Top pages (last 30 days)
        $topPages = PageView::where('viewed_date', '>=', now()->subDays(30))
            ->select('url', DB::raw('COUNT(*) as views'))
            ->groupBy('url')
            ->orderByDesc('views')
            ->take(15)
            ->get();

        // Views per day (last 14 days)
        $dailyViews = PageView::where('viewed_date', '>=', now()->subDays(14))
            ->select('viewed_date', DB::raw('COUNT(*) as views'), DB::raw('COUNT(DISTINCT ip_hash) as unique_visitors'))
            ->groupBy('viewed_date')
            ->orderBy('viewed_date')
            ->get();

        // Totals
        $totalViews = PageView::count();
        $todayViews = PageView::where('viewed_date', now()->toDateString())->count();
        $uniqueToday = PageView::where('viewed_date', now()->toDateString())->distinct('ip_hash')->count('ip_hash');

        // Top referrers
        $topReferrers = PageView::whereNotNull('referrer')
            ->where('referrer', '!=', '')
            ->where('viewed_date', '>=', now()->subDays(30))
            ->select('referrer', DB::raw('COUNT(*) as hits'))
            ->groupBy('referrer')
            ->orderByDesc('hits')
            ->take(10)
            ->get();

        // Subscribers
        $subscribers = Subscriber::latest()->take(20)->get();
        $subscriberCount = Subscriber::count();

        // Top browsers (user agent families)
        $topBrowsers = PageView::whereNotNull('user_agent')
            ->where('user_agent', '!=', '')
            ->where('viewed_date', '>=', now()->subDays(30))
            ->select(DB::raw("
                CASE
                    WHEN user_agent LIKE '%Firefox%' THEN 'Firefox'
                    WHEN user_agent LIKE '%Edg%' THEN 'Edge'
                    WHEN user_agent LIKE '%Chrome%' THEN 'Chrome'
                    WHEN user_agent LIKE '%Safari%' THEN 'Safari'
                    WHEN user_agent LIKE '%bot%' OR user_agent LIKE '%Bot%' THEN 'Bot'
                    ELSE 'Other'
                END as browser
            "), DB::raw('COUNT(*) as hits'))
            ->groupBy('browser')
            ->orderByDesc('hits')
            ->get();

        return view('admin.analytics.index', compact(
            'topPages',
            'dailyViews',
            'totalViews',
            'todayViews',
            'uniqueToday',
            'topReferrers',
            'topBrowsers',
            'subscribers',
            'subscriberCount'
        ));
    }
}
