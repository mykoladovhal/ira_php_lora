<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function join(Request $request, Event $event): RedirectResponse
    {
        $user = $request->user();

        if ($event->isUserRegistered($user)) {
            return back()->with('error', '既に参加登録済みです。');
        }

        $event->participants()->attach($user->id, ['status' => 'registered']);

        return back()->with('success', 'イベントに参加登録しました。');
    }

    public function leave(Request $request, Event $event): RedirectResponse
    {
        $user = $request->user();

        if (!$event->isUserRegistered($user)) {
            return back()->with('error', '参加登録されていません。');
        }

        $event->participants()->updateExistingPivot($user->id, ['status' => 'cancelled']);

        return back()->with('success', '参加をキャンセルしました。');
    }
}
