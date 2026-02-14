<x-public-layout pageTitle="{{ $project->title }}" metaDescription="{{ $project->description }}">

    {{-- Breadcrumb --}}
    <nav class="mono text-muted" style="font-size:12px" aria-label="Breadcrumb">
        <a href="{{ route('home') }}">~</a> /
        <a href="{{ route('projects.index') }}">projects</a> /
        {{ $project->slug }}
    </nav>

    <div class="ascii-border mt-2">
        <h1>{{ $project->title }}</h1>
        <p class="text-muted mono" style="font-size:11px">
            {{ $project->year }} |
            @if($project->status === 'completed')<span class="text-green">completed</span>
            @elseif($project->status === 'in_progress')<span class="text-accent">in progress</span>
            @else<span class="text-muted">archived</span>
            @endif
        </p>

        <div class="mt-2">
            <p>{{ $project->description }}</p>
        </div>

        @if($project->long_description)
            <div class="mt-2" style="white-space:pre-line;font-size:13px">{{ $project->long_description }}</div>
        @endif

        <div class="mt-2">
            <span class="mono text-muted" style="font-size:11px">tech:</span>
            @foreach($project->tech_stack as $tech)
                <span class="tag">{{ $tech }}</span>
            @endforeach
        </div>

        @if($project->tags->count())
            <div class="mt-1">
                <span class="mono text-muted" style="font-size:11px">tags:</span>
                @foreach($project->tags as $tag)
                    <span class="tag">{{ $tag->name }}</span>
                @endforeach
            </div>
        @endif

        <div class="mt-2 mono" style="font-size:12px">
            @if($project->url)
                <span class="text-muted">$</span> <span class="text-heading">open</span> <a href="{{ $project->url }}"
                    target="_blank">{{ $project->url }}</a><br>
            @endif
            @if($project->repo_url)
                <span class="text-muted">$</span> <span class="text-heading">git clone</span> <a
                    href="{{ $project->repo_url }}" target="_blank">{{ $project->repo_url }}</a>
            @endif
        </div>
    </div>

    @if($project->screenshot_path)
        <div class="mt-2">
            <details>
                <summary>[+] show screenshot</summary>
                <img src="{{ asset('storage/' . $project->screenshot_path) }}" alt="{{ $project->title }}"
                    style="max-width:100%;border:2px solid var(--border);margin-top:8px;cursor:pointer" loading="lazy"
                    onclick="document.getElementById('lightbox').style.display='flex';document.getElementById('lightboxImg').src=this.src">
            </details>
        </div>
    @endif

    {{-- Lightbox --}}
    <div id="lightbox" onclick="this.style.display='none'"
        style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.9);z-index:9999;justify-content:center;align-items:center;cursor:pointer">
        <img id="lightboxImg" style="max-width:90vw;max-height:90vh;border:2px solid var(--heading)">
        <span
            style="position:absolute;top:16px;right:24px;color:var(--heading);font-size:20px;font-family:var(--mono)">[x]
            close</span>
    </div>

    {{-- Social Sharing --}}
    <div class="ascii-border mt-2" style="padding:8px 16px">
        <span class="mono text-muted" style="font-size:11px">$ share --to</span>
        @php
            $shareUrl = urlencode(route('projects.show', $project->slug));
            $shareTitle = urlencode($project->title . ' — FrugalDev');
        @endphp
        <div style="display:flex;gap:8px;margin-top:4px;flex-wrap:wrap">
            <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareTitle }}" target="_blank"
                rel="noopener" class="btn" style="font-size:10px" aria-label="Share on Twitter">[twitter/X]</a>
            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $shareUrl }}" target="_blank" rel="noopener"
                class="btn" style="font-size:10px" aria-label="Share on LinkedIn">[linkedin]</a>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" rel="noopener"
                class="btn" style="font-size:10px" aria-label="Share on Facebook">[facebook]</a>
            <a href="https://api.whatsapp.com/send?text={{ $shareTitle }}%20{{ $shareUrl }}" target="_blank"
                rel="noopener" class="btn" style="font-size:10px" aria-label="Share on WhatsApp">[whatsapp]</a>
            <button
                onclick="navigator.clipboard.writeText('{{ route('projects.show', $project->slug) }}');this.textContent='[copied!]';setTimeout(()=>this.textContent='[copy link]',2000)"
                class="btn" style="font-size:10px">[copy link]</button>
        </div>
    </div>

    {{-- Related Projects --}}
    @if($relatedProjects->count())
        <div class="mt-2">
            <h2>$ ls --related</h2>
            <div class="mono" style="font-size:12px;margin-top:8px">
                @foreach($relatedProjects as $related)
                    <div style="margin:6px 0;display:flex;gap:8px;align-items:baseline">
                        <span class="text-muted">{{ $related->year }}</span>
                        <a href="{{ route('projects.show', $related->slug) }}">{{ $related->title }}</a>
                        <span class="text-muted"
                            style="font-size:10px">{{ implode(', ', array_slice($related->tech_stack, 0, 3)) }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</x-public-layout>