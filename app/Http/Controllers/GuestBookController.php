<?php

namespace App\Http\Controllers;

use App\Models\GuestBookEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GuestBookController extends Controller
{
    public function index()
    {
        $entries = GuestBookEntry::approved()
            ->whereNull('parent_id')
            ->with('replies')
            ->latest()
            ->paginate(20);
        return view('guestbook', compact('entries'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nickname' => 'required|string|max:50',
            'message' => 'required|string|max:500',
            'ascii_art' => 'nullable|string|max:500',
            'website' => 'nullable|url|max:255',
            'parent_id' => 'nullable|exists:guest_book_entries,id',
        ]);

        $validated['ip_address'] = $request->ip();
        $validated['is_approved'] = false;
        $validated['edit_token'] = Str::random(32);

        // Basic spam detection
        $spamWords = ['viagra', 'casino', 'lottery', 'crypto', 'bitcoin', 'free money', 'click here', 'buy now', 'earn fast', 'pills'];
        $content = strtolower($validated['nickname'] . ' ' . $validated['message']);
        foreach ($spamWords as $word) {
            if (str_contains($content, $word)) {
                return back()->withErrors(['message' => 'Your message was flagged as spam.'])->withInput();
            }
        }

        $entry = GuestBookEntry::create($validated);

        return back()->with('success', 'Entry submitted! It will appear after moderation.')
            ->with('edit_token', $entry->edit_token)
            ->with('entry_id', $entry->id);
    }

    public function edit(string $token)
    {
        $entry = GuestBookEntry::where('edit_token', $token)->firstOrFail();
        return view('guestbook-edit', compact('entry'));
    }

    public function update(Request $request, string $token)
    {
        $entry = GuestBookEntry::where('edit_token', $token)->firstOrFail();

        $validated = $request->validate([
            'message' => 'required|string|max:500',
            'ascii_art' => 'nullable|string|max:500',
        ]);

        $entry->update($validated);

        return redirect()->route('guestbook.index')->with('success', 'Message updated successfully!');
    }
}
