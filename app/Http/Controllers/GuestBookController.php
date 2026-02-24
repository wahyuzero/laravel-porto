<?php

namespace App\Http\Controllers;

use App\Models\GuestBookEntry;
use App\Models\GuestbookReaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

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

    public function react(Request $request, int $id)
    {
        try {
            $allowedEmoji = ['👍', '❤️', '😄'];
            $emoji = $request->input('emoji', '');

            if (!in_array($emoji, $allowedEmoji, true)) {
                return response()->json(['error' => 'Invalid emoji'], 422);
            }

            $entry = GuestBookEntry::approved()->findOrFail($id);
            $ip = $request->ip();

            // Toggle: if already reacted with this emoji, remove it
            $existing = GuestbookReaction::where([
                'guest_book_entry_id' => $id,
                'emoji' => $emoji,
                'ip_address' => $ip,
            ])->first();

            if ($existing) {
                $existing->delete();
            } else {
                GuestbookReaction::create([
                    'guest_book_entry_id' => $id,
                    'emoji' => $emoji,
                    'ip_address' => $ip,
                ]);
            }

            // Recalculate aggregate counts
            $counts = GuestbookReaction::where('guest_book_entry_id', $id)
                ->selectRaw('emoji, count(*) as total')
                ->groupBy('emoji')
                ->pluck('total', 'emoji')
                ->toArray();

            $entry->update(['reactions' => $counts ?: null]);

            // Return user's active reactions for this entry
            $myReactions = GuestbookReaction::where([
                'guest_book_entry_id' => $id,
                'ip_address' => $ip,
            ])->pluck('emoji')->toArray();

            return response()->json([
                'counts' => $counts,
                'myReactions' => $myReactions,
                'toggled' => !$existing,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
