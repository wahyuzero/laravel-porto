<x-public-layout pageTitle="Edit Guestbook Entry" metaDescription="Edit your guestbook entry.">

    <h1>$ vim guestbook.txt</h1>

    <div class="ascii-border mt-2">
        <h3 class="mono text-heading" style="font-size:12px">// edit your message</h3>
        <form action="{{ route('guestbook.update', $entry->edit_token) }}" method="POST" class="mt-1">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label class="retro-label">nickname:</label>
                <input type="text" class="retro-input" value="{{ $entry->nickname }}" disabled style="opacity:0.6">
            </div>
            <div class="form-group">
                <label class="retro-label" for="gb_message">message (max 500 chars):</label>
                <textarea name="message" id="gb_message" class="retro-input" rows="3" required
                    maxlength="500">{{ old('message', $entry->message) }}</textarea>
            </div>
            <div class="form-group">
                <label class="retro-label" for="gb_ascii">ascii art (optional):</label>
                <textarea name="ascii_art" id="gb_ascii" class="retro-input mono" rows="4"
                    maxlength="500">{{ old('ascii_art', $entry->ascii_art) }}</textarea>
            </div>
            @foreach ($errors->all() as $error)
                <p class="text-accent mono" style="font-size:11px">! {{ $error }}</p>
            @endforeach
            <button type="submit" class="btn">save changes</button>
            <a href="{{ route('guestbook.index') }}" class="btn" style="margin-left:8px">cancel</a>
        </form>
    </div>

</x-public-layout>