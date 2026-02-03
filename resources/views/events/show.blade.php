<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                イベント詳細
            </h2>
            <a href="{{ route('events.index') }}" class="text-indigo-600 hover:text-indigo-800">
                ← イベント一覧に戻る
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Header -->
                    <div class="flex items-start justify-between mb-6">
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <x-category-badge :category="$event->category" />
                                @if(auth()->check() && $event->isUserRegistered(auth()->user()))
                                    <x-status-badge status="registered" />
                                @endif
                            </div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $event->title }}</h1>
                        </div>

                        @if($event->user_id === auth()->id() || auth()->user()->isAdmin())
                            <div class="flex items-center gap-2">
                                <a href="{{ route('events.edit', $event) }}" class="inline-flex items-center px-3 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200">
                                    編集
                                </a>
                                <form method="POST" action="{{ route('events.destroy', $event) }}" onsubmit="return confirm('このイベントを削除しますか？')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                                        削除
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>

                    <!-- Event Details -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <div>
                                <p class="text-sm text-gray-500">開催日</p>
                                <p class="font-medium">{{ $event->event_date->format('Y年m月d日') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="text-sm text-gray-500">開始時間</p>
                                <p class="font-medium">{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <div>
                                <p class="text-sm text-gray-500">場所</p>
                                <p class="font-medium">{{ $event->location }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Organizer -->
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-500 mb-1">主催者</p>
                        <p class="font-medium text-gray-900">{{ $event->organizer->name }}</p>
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">説明</h3>
                        <div class="prose prose-gray max-w-none">
                            {!! nl2br(e($event->description)) !!}
                        </div>
                    </div>

                    <!-- Join/Leave Button -->
                    @if($event->user_id !== auth()->id())
                        <div class="border-t pt-6">
                            @if($event->isUserRegistered(auth()->user()))
                                <form method="POST" action="{{ route('events.leave', $event) }}">
                                    @csrf
                                    <button type="submit" class="w-full md:w-auto inline-flex items-center justify-center px-6 py-3 bg-gray-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        参加をキャンセルする
                                    </button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('events.join', $event) }}">
                                    @csrf
                                    <button type="submit" class="w-full md:w-auto inline-flex items-center justify-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        参加する
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endif

                    <!-- Participants -->
                    <div class="border-t pt-6 mt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">参加者 ({{ $event->registeredParticipants->count() }}名)</h3>
                        @if($event->registeredParticipants->count() > 0)
                            <div class="flex flex-wrap gap-2">
                                @foreach($event->registeredParticipants as $participant)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-gray-100 text-gray-800">
                                        {{ $participant->name }}
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">まだ参加者がいません。</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
