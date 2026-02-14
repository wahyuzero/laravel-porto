<x-public-layout pageTitle="Newsletter Archive"
    metaDescription="Archive of FrugalDev newsletter - past blog posts sent to subscribers.">

    <h1>$ cat /var/mail/archive</h1>

    <div class="ascii-border mt-2" style="padding:12px 16px">
        <span class="mono text-muted" style="font-size:11px">// newsletter archive — past posts sent to
            subscribers</span>
    </div>

    <div class="mono mt-2" style="font-size:12px">
        @forelse($posts as $post)
            <div style="margin:8px 0;display:flex;flex-wrap:wrap;gap:8px;align-items:baseline">
                <span class="text-muted" style="min-width:85px">{{ $post->published_at->format('Y-m-d') }}</span>
                <a href="{{ route('blog.show', $post->slug) }}" style="flex:1;min-width:200px">{{ $post->title }}</a>
                <span class="text-muted" style="font-size:10px">{{ $post->views ?? 0 }} views</span>
            </div>
        @empty
            <p class="text-muted">No archived newsletters yet.</p>
        @endforelse
    </div>

    @if($posts->hasPages())
        <div class="mt-2 mono" style="font-size:12px">
            {{ $posts->links('pagination::simple-default') }}
        </div>
    @endif

    <div class="ascii-border mt-2" style="padding:8px 16px">
        <span class="mono text-muted" style="font-size:11px">$ subscribe --newsletter</span>
        <form action="{{ route('newsletter.subscribe') }}" method="POST" style="margin-top:4px;display:flex;gap:8px">
            @csrf
            <input type="email" name="email" class="retro-input" placeholder="your@email.com" required style="flex:1">
            <button type="submit" class="btn">subscribe</button>
        </form>
    </div>

</x-public-layout>