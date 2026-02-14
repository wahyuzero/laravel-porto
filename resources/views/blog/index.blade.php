<x-public-layout pageTitle="Blog" metaDescription="FrugalDev blog — thoughts on development, tools, and simplicity.">

    <h1>$ ls blog/</h1>

    @if(isset($tag))
        <div class="mono text-muted mt-1" style="font-size:12px">
            filtered by tag: <span class="text-heading">{{ $tag }}</span>
            — <a href="{{ route('blog.index') }}">clear filter</a>
        </div>
    @endif

    <div class="mono mt-2" style="font-size:12px">
        <div class="text-muted mb-1">total {{ $posts->total() }} posts</div>

        @forelse($posts as $post)
            <div style="margin-bottom:8px;display:flex;flex-wrap:wrap;gap:8px;align-items:baseline">
                <span class="text-muted" style="min-width:85px">{{ $post->published_at->format('Y-m-d') }}</span>
                <a href="{{ route('blog.show', $post->slug) }}" style="flex:1;min-width:200px">{{ $post->title }}</a>
                <span class="text-muted">{{ $post->file_size }}</span>
                <span class="text-muted">{{ ceil(str_word_count($post->content_md) / 200) }}min</span>
                <span class="text-muted">👁 {{ $post->views_count }}</span>
                @foreach($post->tags as $ptag)
                    <a href="{{ route('blog.tag', $ptag->name) }}" class="tag"
                        style="text-decoration:none">{{ $ptag->name }}</a>
                @endforeach
            </div>
        @empty
            <p class="text-muted">No published posts yet.</p>
        @endforelse
    </div>

    @if($posts->hasPages())
        <div class="mt-2 mono" style="font-size:12px">
            @if($posts->onFirstPage())
                <span class="text-muted">[&lt; prev]</span>
            @else
                <a href="{{ $posts->previousPageUrl() }}">[&lt; prev]</a>
            @endif

            @foreach($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
                @if($page == $posts->currentPage())
                    <span class="text-heading">[{{ $page }}]</span>
                @else
                    <a href="{{ $url }}">[{{ $page }}]</a>
                @endif
            @endforeach

            @if($posts->hasMorePages())
                <a href="{{ $posts->nextPageUrl() }}">[next &gt;]</a>
            @else
                <span class="text-muted">[next &gt;]</span>
            @endif
        </div>
    @endif

</x-public-layout>