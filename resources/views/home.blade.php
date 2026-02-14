<x-public-layout pageTitle="FrugalDev" metaDescription="FrugalDev — Full Stack Developer. Build more. Bloat less.">

    <pre class="mono" style="color:var(--green);font-size:10px;line-height:1.3;margin-bottom:16px">
 ___                       _ ___
|  _|_ _ _ _ ___ ___| |  _ ___ _ _
|  _|  _| | | . | .'| | | | -_| | |
|_| |_| |___|_  |__,|_|___|___|___|
            |___|
</pre>

    <div class="ascii-border">
        <span class="mono text-muted">$</span> <span class="mono text-heading">whoami</span>
        <p class="mt-1">
            @if($profile)
                <strong>{{ $profile->user->display_name ?? $profile->user->name }}</strong> — {{ $profile->title }}
                <br><span class="text-muted">{{ $profile->location }}</span>
            @else
                FrugalDev — Developer
            @endif
        </p>
    </div>

    @if($profile && ($profile->status_text || $profile->currently_building || $profile->currently_reading))
        <div class="ascii-border">
            <span class="mono text-muted">$</span> <span class="mono text-heading">cat status.txt</span>
            <div class="mono mt-1" style="font-size:12px">
                @if($profile->status_text)
                    <div>status : <span class="text-green">{{ $profile->status_text }}</span></div>
                @endif
                @if($profile->currently_building)
                    <div>building : {{ $profile->currently_building }}</div>
                @endif
                @if($profile->currently_reading)
                    <div>reading : {{ $profile->currently_reading }}</div>
                @endif
                @if($profile->currently_listening)
                    <div>listening: {{ $profile->currently_listening }}</div>
                @endif
            </div>
        </div>
    @endif

    <div class="ascii-hr">═══ FEATURED PROJECTS ═══</div>

    @if($projects->count())
        <table class="retro-table">
            <thead>
                <tr>
                    <th>name</th>
                    <th>tech</th>
                    <th>year</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($projects as $project)
                    <tr>
                        <td><a href="{{ route('projects.show', $project->slug) }}">{{ $project->title }}</a></td>
                        <td><span class="text-muted">{{ implode(', ', array_slice($project->tech_stack, 0, 3)) }}</span></td>
                        <td>{{ $project->year }}</td>
                        <td>
                            @if($project->status === 'in_progress')<span class="blink text-accent">[wip]</span>@endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <p class="mt-1 mono" style="font-size:12px"><a href="{{ route('projects.index') }}">→ view all projects</a></p>
    @else
        <p class="text-muted mono">No projects yet.</p>
    @endif

    <div class="ascii-hr">═══ LATEST POSTS ═══</div>

    @if($posts->count())
        <div class="mono" style="font-size:12px">
            @foreach($posts as $post)
                <div style="margin-bottom:8px">
                    <span class="text-muted">{{ $post->published_at->format('Y-m-d') }}</span>
                    <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                    <span class="text-muted">{{ $post->file_size }}</span>
                    <a href="{{ route('blog.show', $post->slug) }}" class="text-muted">[read]</a>
                </div>
            @endforeach
        </div>
        <p class="mt-1 mono" style="font-size:12px"><a href="{{ route('blog.index') }}">→ view all posts</a></p>
    @else
        <p class="text-muted mono">No posts yet.</p>
    @endif

    <div class="ascii-hr">═══ QUICK STATS ═══</div>

    <div class="mono" style="font-size:12px">
        <div>uptime : {{ \Carbon\Carbon::parse(\App\Models\SiteSetting::get('site_created_at', '2026-02-12'))->diffForHumans(null, true) }}</div>
        <div>projects : {{ \App\Models\Project::visible()->count() }}</div>
        <div>blog_posts : {{ \App\Models\BlogPost::published()->count() }}</div>
        <div>skills_listed : {{ \App\Models\Skill::visible()->count() }}</div>
        <div>coffees_today : {{ rand(2, 7) }}</div>
    </div>

</x-public-layout>