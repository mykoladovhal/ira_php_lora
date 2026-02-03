@props(['event'])

<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow">
    <div class="p-6">
        <div class="flex items-start justify-between">
            <div class="flex-1">
                <div class="flex items-center gap-2 mb-2">
                    <x-category-badge :category="$event->category" />
                    @if(auth()->check() && $event->isUserRegistered(auth()->user()))
                        <x-status-badge status="registered" />
                    @endif
                </div>

                <h3 class="text-lg font-semibold text-gray-900 mb-2">
                    <a href="{{ route('events.show', $event) }}" class="hover:text-indigo-600">
                        {{ $event->title }}
                    </a>
                </h3>

                <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                    {{ Str::limit($event->description, 100) }}
                </p>

                <div class="flex flex-wrap gap-4 text-sm text-gray-500">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ $event->event_date->format('Y/m/d') }}
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        {{ $event->location }}
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between">
            <div class="text-sm text-gray-500">
                <span>参加者: {{ $event->registeredParticipants->count() }}名</span>
            </div>
            <a href="{{ route('events.show', $event) }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                詳細を見る →
            </a>
        </div>
    </div>
</div>
