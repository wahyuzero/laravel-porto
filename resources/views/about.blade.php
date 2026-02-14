<x-public-layout pageTitle="About" metaDescription="About FrugalDev — Skills, experience, and more.">

    <h1>$ cat about.txt</h1>

    <div class="ascii-border mt-2">
        @if($profile)
            <h3>{{ $profile->user->display_name ?? $profile->user->name }}</h3>
            <p class="text-muted mb-1">{{ $profile->title }} | {{ $profile->location }}</p>
            <div style="white-space:pre-line">{{ $profile->bio }}</div>

            @if($profile->email_public)
                <p class="mt-2 mono" style="font-size:12px">
                    <span class="text-muted">$</span> <span class="text-heading">mail</span> {{ $profile->email_public }}
                </p>
            @endif

            @if($profile->social_links)
                <div class="mt-2 mono" style="font-size:12px">
                    @foreach($profile->social_links as $platform => $url)
                        @if($url)
                            <a href="{{ $url }}" target="_blank">[{{ $platform }}]</a>
                        @endif
                    @endforeach
                </div>
            @endif

            @if($profile->resume_path)
                <p class="mt-2 mono" style="font-size:12px">
                    <span class="text-muted">$</span> <span class="text-heading">wget</span> <a
                        href="{{ asset('storage/' . $profile->resume_path) }}">resume.pdf</a>
                </p>
            @endif
        @else
            <p class="text-muted">Profile not set up yet.</p>
        @endif
    </div>

    <div class="ascii-hr">═══ SKILLS ═══</div>

    @foreach($skills as $category => $categorySkills)
        <div class="mb-2">
            <h3 class="mono text-heading" style="font-size:12px">// {{ $category }}</h3>
            @foreach($categorySkills as $skill)
                <div class="mono" style="font-size:12px;margin:2px 0">
                    <span style="display:inline-block;width:140px">{{ str_pad($skill->name, 14) }}</span>
                    <span class="skill-bar text-green">{{ $skill->level_bar }}</span>
                    <span class="text-muted"> {{ $skill->level }}/5</span>
                </div>
            @endforeach
        </div>
    @endforeach

    <div class="ascii-hr">═══ EXPERIENCE ═══</div>

    @foreach($experiences as $exp)
        <div class="mb-2" style="padding-left:16px;border-left:2px solid var(--border)">
            <div class="mono" style="font-size:12px">
                <span class="text-heading">{{ $exp->title }}</span>
                @ <span class="text-accent">{{ $exp->organization }}</span>
                <br>
                <span class="text-muted">{{ $exp->duration }}</span>
                @if($exp->location) | <span class="text-muted">{{ $exp->location }}</span>@endif
                <span class="tag">{{ $exp->type }}</span>
            </div>
            @if($exp->description)
                <p style="font-size:13px;margin-top:4px">{{ $exp->description }}</p>
            @endif
        </div>
    @endforeach

    @if($testimonials->count())
        <div class="ascii-hr">═══ TESTIMONIALS ═══</div>

        @foreach($testimonials as $t)
            <div class="ascii-border">
                <p style="font-style:italic">"{{ $t->content }}"</p>
                <p class="text-muted mt-1 mono" style="font-size:11px">—
                    {{ $t->name }}{{ $t->role ? ', ' . $t->role : '' }}{{ $t->company ? ' @ ' . $t->company : '' }}</p>
            </div>
        @endforeach
    @endif

    <div class="ascii-hr">═══ CONTACT ═══</div>

    <div class="ascii-border">
        <h3 class="mono text-heading" style="font-size:12px">$ send_message</h3>
        <form action="{{ route('contact.store') }}" method="POST" class="mt-1">
            @csrf
            <div class="form-group">
                <label class="retro-label">name:</label>
                <input type="text" name="name" class="retro-input" required value="{{ old('name') }}">
            </div>
            <div class="form-group">
                <label class="retro-label">email:</label>
                <input type="email" name="email" class="retro-input" required value="{{ old('email') }}">
            </div>
            <div class="form-group">
                <label class="retro-label">subject:</label>
                <input type="text" name="subject" class="retro-input" value="{{ old('subject') }}">
            </div>
            <div class="form-group">
                <label class="retro-label">message:</label>
                <textarea name="message" class="retro-input" rows="4" required>{{ old('message') }}</textarea>
            </div>
            @foreach ($errors->all() as $error)
                <p class="text-accent mono" style="font-size:11px">! {{ $error }}</p>
            @endforeach
            <button type="submit" class="btn">send</button>
        </form>
    </div>

</x-public-layout>