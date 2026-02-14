<x-public-layout pageTitle="Changelog" metaDescription="FrugalDev site changelog and version history.">

    <h1>$ git log --oneline</h1>

    <div class="mono mt-2" style="font-size:12px">
        @forelse($changelogs as $log)
            <div style="margin-bottom:16px;padding-left:16px;border-left:2px solid var(--border)">
                <span class="text-heading">{{ $log->version }}</span>
                <span class="text-muted">— {{ $log->released_at->format('Y-m-d') }}</span>
                <span>— {{ $log->title }}</span>
                <pre style="margin-top:4px;color:var(--text);font-size:12px;white-space:pre-wrap">{{ $log->content }}</pre>
            </div>
        @empty
            <p class="text-muted">No changelog entries yet.</p>
        @endforelse
    </div>

</x-public-layout>