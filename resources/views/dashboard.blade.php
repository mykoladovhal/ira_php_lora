<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ダッシュボード
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Message -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-2">ようこそ、{{ auth()->user()->name }}さん！</h3>
                    <p class="text-gray-600">EventEaseへようこそ。イベントを探したり、新しいイベントを作成したりできます。</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Upcoming Events -->
                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-gray-900">今後のイベント</h3>
                                <a href="{{ route('events.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800">
                                    すべて見る →
                                </a>
                            </div>
                            @if($upcomingEvents->count() > 0)
                                <div class="space-y-4">
                                    @foreach($upcomingEvents as $event)
                                        <div class="flex items-start p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                                            <div class="flex-1">
                                                <div class="flex items-center gap-2 mb-1">
                                                    <x-category-badge :category="$event->category" />
                                                    @if(auth()->check() && $event->isUserRegistered(auth()->user()))
                                                        <x-status-badge status="registered" />
                                                    @endif
                                                </div>
                                                <h4 class="font-medium text-gray-900">
                                                    <a href="{{ route('events.show', $event) }}" class="hover:text-indigo-600">
                                                        {{ $event->title }}
                                                    </a>
                                                </h4>
                                                <p class="text-sm text-gray-500 mt-1">
                                                    {{ $event->event_date->format('Y/m/d') }} {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} - {{ $event->location }}
                                                </p>
                                            </div>
                                            <a href="{{ route('events.show', $event) }}" class="text-indigo-600 hover:text-indigo-800 text-sm">
                                                詳細 →
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500 text-center py-8">今後のイベントはありません。</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- My Organized Events -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">主催イベント</h3>
                            @if($myOrganizedEvents->count() > 0)
                                <div class="space-y-3">
                                    @foreach($myOrganizedEvents as $event)
                                        <a href="{{ route('events.show', $event) }}" class="block p-3 border border-gray-200 rounded-lg hover:bg-gray-50">
                                            <p class="font-medium text-gray-900 text-sm">{{ $event->title }}</p>
                                            <p class="text-xs text-gray-500 mt-1">{{ $event->event_date->format('Y/m/d') }}</p>
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500 text-sm">主催イベントはありません。</p>
                            @endif
                            <a href="{{ route('events.create') }}" class="mt-4 block w-full text-center py-2 px-4 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-sm font-medium">
                                イベント作成
                            </a>
                        </div>
                    </div>

                    <!-- My Registered Events -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">参加予定イベント</h3>
                            @if($myRegisteredEvents->count() > 0)
                                <div class="space-y-3">
                                    @foreach($myRegisteredEvents as $event)
                                        <a href="{{ route('events.show', $event) }}" class="block p-3 border border-gray-200 rounded-lg hover:bg-gray-50">
                                            <p class="font-medium text-gray-900 text-sm">{{ $event->title }}</p>
                                            <p class="text-xs text-gray-500 mt-1">{{ $event->event_date->format('Y/m/d') }} - {{ $event->organizer->name }}</p>
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500 text-sm">参加予定のイベントはありません。</p>
                            @endif
                            <a href="{{ route('events.index') }}" class="mt-4 block w-full text-center py-2 px-4 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 text-sm font-medium">
                                イベントを探す
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
