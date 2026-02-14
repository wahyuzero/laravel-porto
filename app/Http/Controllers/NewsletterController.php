<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function archive()
    {
        $posts = BlogPost::published()->latest('published_at')->paginate(20);
        return view('newsletter-archive', compact('posts'));
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $existing = Subscriber::where('email', $request->email)->first();
        if ($existing) {
            if ($existing->is_verified) {
                return back()->with('success', 'You\'re already subscribed! Thanks.');
            }
            // Resend verification
            return back()->with('success', 'A verification link was already sent. Check your email or click: ' . route('newsletter.verify', $existing->token));
        }

        try {
            $subscriber = Subscriber::create([
                'email' => $request->email,
                'is_verified' => false,
            ]);

            // In production: send verification email
            // For now: show confirmation link directly
            return back()->with('success', 'Almost done! Please verify: ' . route('newsletter.verify', $subscriber->token));
        } catch (\Exception $e) {
            \Log::error('Newsletter subscribe error: ' . $e->getMessage());
            return back()->with('error', 'Subscription failed. Please try again.');
        }
    }

    public function verify(string $token)
    {
        $subscriber = Subscriber::where('token', $token)->firstOrFail();

        if ($subscriber->is_verified) {
            return redirect()->route('home')->with('success', 'Already verified. You\'re subscribed!');
        }

        $subscriber->update([
            'is_verified' => true,
            'verified_at' => now(),
        ]);

        return redirect()->route('home')->with('success', 'Email verified! You\'re now subscribed.');
    }

    public function unsubscribe(string $token)
    {
        $subscriber = Subscriber::where('token', $token)->firstOrFail();
        $reason = request('reason', 'not specified');

        \Log::info("Newsletter unsubscribe: {$subscriber->email} — reason: {$reason}");

        $subscriber->delete();
        return redirect()->route('home')->with('success', 'You have been unsubscribed. Thanks for your feedback.');
    }
}
