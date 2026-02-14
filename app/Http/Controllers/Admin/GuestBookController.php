<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GuestBookEntry;

class GuestBookController extends Controller
{
    public function index()
    {
        $entries = GuestBookEntry::latest()->paginate(20);
        return view('admin.guestbook.index', compact('entries'));
    }

    public function approve(GuestBookEntry $guestbook)
    {
        $guestbook->update(['is_approved' => true]);
        return back()->with('success', 'Entry approved.');
    }

    public function destroy(GuestBookEntry $guestbook)
    {
        $guestbook->delete();
        return back()->with('success', 'Entry removed.');
    }
}
