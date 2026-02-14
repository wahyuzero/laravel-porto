<x-admin-layout>
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px">
        <h2>📊 Analytics & Subscribers</h2>
        <span class="badge badge-blue">Built-in • Privacy-friendly</span>
    </div>

    {{-- Stats Overview --}}
    <div class="stat-grid">
        <div class="stat-card">
            <div class="label">Total Page Views</div>
            <div class="value">{{ number_format($totalViews) }}</div>
        </div>
        <div class="stat-card">
            <div class="label">Today's Views</div>
            <div class="value">{{ $todayViews }}</div>
        </div>
        <div class="stat-card">
            <div class="label">Unique Today</div>
            <div class="value">{{ $uniqueToday }}</div>
        </div>
        <div class="stat-card">
            <div class="label">Subscribers</div>
            <div class="value">{{ $subscriberCount }}</div>
        </div>
    </div>

    {{-- Daily Traffic (last 14 days) --}}
    <div style="background:#1e293b;border:1px solid #334155;border-radius:6px;padding:16px;margin-bottom:24px">
        <h3 style="margin-bottom:12px;font-size:14px;color:#94a3b8">Daily Traffic (14 days)</h3>
        @if($dailyViews->count())
            <div style="display:flex;align-items:flex-end;gap:4px;height:120px">
                @php $maxViews = $dailyViews->max('views') ?: 1; @endphp
                @foreach($dailyViews as $day)
                    <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:2px">
                        <div style="background:#38bdf8;width:100%;border-radius:2px 2px 0 0;min-height:2px;height:{{ ($day->views / $maxViews) * 100 }}px"
                            title="{{ $day->views }} views, {{ $day->unique_visitors }} unique"></div>
                        <span
                            style="font-size:9px;color:#64748b;writing-mode:vertical-lr;transform:rotate(180deg)">{{ $day->viewed_date->format('m/d') }}</span>
                    </div>
                @endforeach
            </div>
        @else
            <p style="color:#64748b;font-size:13px">No data yet. Traffic will appear after page visits.</p>
        @endif
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:24px">
        {{-- Top Pages --}}
        <div style="background:#1e293b;border:1px solid #334155;border-radius:6px;padding:16px">
            <h3 style="margin-bottom:12px;font-size:14px;color:#94a3b8">Top Pages (30 days)</h3>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>URL</th>
                        <th style="text-align:right">Views</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topPages as $page)
                        <tr>
                            <td style="font-family:monospace;font-size:12px">{{ Str::limit($page->url, 35) }}</td>
                            <td style="text-align:right">{{ $page->views }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" style="color:#64748b">No data yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Top Referrers --}}
        <div style="background:#1e293b;border:1px solid #334155;border-radius:6px;padding:16px">
            <h3 style="margin-bottom:12px;font-size:14px;color:#94a3b8">Top Referrers (30 days)</h3>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Referrer</th>
                        <th style="text-align:right">Hits</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topReferrers as $ref)
                        <tr>
                            <td style="font-size:12px">{{ Str::limit($ref->referrer, 40) }}</td>
                            <td style="text-align:right">{{ $ref->hits }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" style="color:#64748b">No referrers tracked yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Browser Breakdown --}}
    <div style="background:#1e293b;border:1px solid #334155;border-radius:6px;padding:16px;margin-bottom:24px">
        <h3 style="margin-bottom:12px;font-size:14px;color:#94a3b8">🌐 Browser Breakdown (30 days)</h3>
        @if($topBrowsers->count())
            <div style="display:flex;gap:12px;flex-wrap:wrap">
                @php $totalHits = $topBrowsers->sum('hits') ?: 1; @endphp
                @foreach($topBrowsers as $b)
                    <div style="flex:1;min-width:100px;background:#0f172a;padding:12px;border-radius:6px;text-align:center">
                        <div style="font-size:18px;font-weight:700;color:#38bdf8">{{ round(($b->hits / $totalHits) * 100) }}%
                        </div>
                        <div style="font-size:12px;color:#94a3b8;margin-top:4px">{{ $b->browser }}</div>
                        <div style="font-size:10px;color:#64748b">{{ $b->hits }} hits</div>
                    </div>
                @endforeach
            </div>
        @else
            <p style="color:#64748b;font-size:13px">No browser data yet.</p>
        @endif
    </div>

    {{-- Subscribers --}}
    <div style="background:#1e293b;border:1px solid #334155;border-radius:6px;padding:16px">
        <h3 style="margin-bottom:12px;font-size:14px;color:#94a3b8">Newsletter Subscribers ({{ $subscriberCount }})</h3>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Subscribed</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subscribers as $sub)
                    <tr>
                        <td>{{ $sub->email }}</td>
                        <td>{{ $sub->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            @if($sub->is_verified)
                                <span class="badge badge-green">verified</span>
                            @else
                                <span class="badge badge-yellow">pending</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="color:#64748b">No subscribers yet</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin-layout>