<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(Request $request): View
    {
        $query = Event::with(['category', 'organizer', 'registeredParticipants'])
            ->orderBy('event_date')
            ->orderBy('start_time');

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date_from')) {
            $query->where('event_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('event_date', '<=', $request->date_to);
        }

        $events = $query->paginate(12);
        $categories = Category::all();

        return view('events.index', compact('events', 'categories'));
    }

    public function create(): View
    {
        $categories = Category::all();
        return view('events.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'location' => 'required|string|max:255',
        ]);

        $validated['user_id'] = $request->user()->id;

        Event::create($validated);

        return redirect()->route('events.index')
            ->with('success', 'イベントが作成されました。');
    }

    public function show(Event $event): View
    {
        $event->load(['category', 'organizer', 'registeredParticipants']);
        return view('events.show', compact('event'));
    }

    public function edit(Event $event): View|RedirectResponse
    {
        if ($event->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            return redirect()->route('events.index')
                ->with('error', '編集権限がありません。');
        }

        $categories = Category::all();
        return view('events.edit', compact('event', 'categories'));
    }

    public function update(Request $request, Event $event): RedirectResponse
    {
        if ($event->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            return redirect()->route('events.index')
                ->with('error', '編集権限がありません。');
        }

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date',
            'start_time' => 'required',
            'location' => 'required|string|max:255',
        ]);

        $event->update($validated);

        return redirect()->route('events.show', $event)
            ->with('success', 'イベントが更新されました。');
    }

    public function destroy(Event $event): RedirectResponse
    {
        if ($event->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            return redirect()->route('events.index')
                ->with('error', '削除権限がありません。');
        }

        $event->delete();

        return redirect()->route('events.index')
            ->with('success', 'イベントが削除されました。');
    }
}
