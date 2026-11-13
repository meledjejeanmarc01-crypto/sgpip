<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = $request->user()->notifications()->paginate(15);

        return view('notifications.index', compact('notifications'));
    }

    public function marquerLues(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();

        return back()->with('success', 'Notifications marquées comme lues.');
    }
}
