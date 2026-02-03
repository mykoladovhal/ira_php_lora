<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $upcomingEvents = Event::with(['category', 'organizer'])
            ->where('event_date', '>=', now()->toDateString())
            ->orderBy('event_date')
            ->orderBy('start_time')
            ->take(5)
            ->get();

        $myOrganizedEvents = $user->organizedEvents()
            ->with(['category'])
            ->where('event_date', '>=', now()->toDateString())
            ->orderBy('event_date')
            ->take(5)
            ->get();

        $myRegisteredEvents = $user->registeredEvents()
            ->with(['category', 'organizer'])
            ->where('event_date', '>=', now()->toDateString())
            ->orderBy('event_date')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'upcomingEvents',
            'myOrganizedEvents',
            'myRegisteredEvents'
        ));
    }
}
