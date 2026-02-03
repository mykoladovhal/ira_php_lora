<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CalendarController extends Controller
{
    public function index(): View
    {
        return view('calendar.index');
    }

    public function events(Request $request): JsonResponse
    {
        $events = Event::with(['category'])
            ->when($request->start, function ($query) use ($request) {
                $query->where('event_date', '>=', $request->start);
            })
            ->when($request->end, function ($query) use ($request) {
                $query->where('event_date', '<=', $request->end);
            })
            ->get()
            ->map(function ($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'start' => $event->event_date->format('Y-m-d') . 'T' . $event->start_time,
                    'url' => route('events.show', $event),
                    'backgroundColor' => $this->getCategoryColor($event->category_id),
                    'borderColor' => $this->getCategoryColor($event->category_id),
                    'extendedProps' => [
                        'category' => $event->category->name,
                        'location' => $event->location,
                    ],
                ];
            });

        return response()->json($events);
    }

    private function getCategoryColor(int $categoryId): string
    {
        $colors = [
            1 => '#3b82f6', // 博覧会 - blue
            2 => '#10b981', // 見本市・展示会 - green
            3 => '#8b5cf6', // 会議イベント - purple
            4 => '#f59e0b', // 文化イベント - amber
            5 => '#ef4444', // スポーツイベント - red
            6 => '#ec4899', // 販促イベント - pink
            7 => '#6b7280', // その他 - gray
        ];

        return $colors[$categoryId] ?? '#6b7280';
    }
}
