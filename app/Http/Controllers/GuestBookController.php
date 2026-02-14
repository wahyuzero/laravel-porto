<?php

namespace App\Http\Controllers;

use App\Models\GuestBookEntry;
use Illuminate\Http\Request;

class GuestBookController extends Controller
{
    public function index()
    {
        $entries = GuestBookEntry::approved()->latest()->paginate(20);
        return view('guestbook', compact('entries'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nickname' => 'required|string|max:50',
            'message' => 'required|string|max:500',
            'ascii_art' => 'nullable|string|max:500',
            'website' => 'nullable|url|max:255',
        ]);

        $validated['ip_address'] = $request->ip();
        $validated['is_approved'] = false; // needs admin approval

        // Basic spam detection
        $spamWords = ['viagra', 'casino', 'lottery', 'crypto', 'bitcoin', 'free money', 'click here', 'buy now', 'earn fast', 'pills'];
        $content = strtolower($validated['nickname'] . ' ' . $validated['message']);
        foreach ($spamWords as $word) {
            if (str_contains($content, $word)) {
                return back()->withErrors(['message' => 'Your message was flagged as spam.'])->withInput();
            }
        }

        GuestBookEntry::create($validated);

        return back()->with('success', 'Entry submitted! It will appear after moderation.');
    }
}
