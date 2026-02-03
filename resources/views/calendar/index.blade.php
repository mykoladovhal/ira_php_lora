<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            カレンダー
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        #calendar {
            max-width: 1100px;
            margin: 0 auto;
        }
        .fc-event {
            cursor: pointer;
        }
        .fc-toolbar-title {
            font-size: 1.25rem !important;
        }
        .fc-button {
            background-color: #4f46e5 !important;
            border-color: #4f46e5 !important;
        }
        .fc-button:hover {
            background-color: #4338ca !important;
            border-color: #4338ca !important;
        }
        .fc-button-active {
            background-color: #3730a3 !important;
            border-color: #3730a3 !important;
        }
        .fc-daygrid-day-number {
            color: #374151;
        }
        .fc-col-header-cell-cushion {
            color: #374151;
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');

            const calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: [FullCalendar.dayGridPlugin, FullCalendar.interactionPlugin],
                initialView: 'dayGridMonth',
                locale: 'ja',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,dayGridWeek'
                },
                buttonText: {
                    today: '今日',
                    month: '月',
                    week: '週'
                },
                events: '{{ route("calendar.events") }}',
                eventClick: function(info) {
                    if (info.event.url) {
                        info.jsEvent.preventDefault();
                        window.location.href = info.event.url;
                    }
                },
                eventDidMount: function(info) {
                    info.el.title = info.event.extendedProps.category + ' - ' + info.event.extendedProps.location;
                },
                height: 'auto',
                firstDay: 0,
                dayMaxEvents: 3,
                moreLinkText: 'その他 +',
            });

            calendar.render();
        });
    </script>
    @endpush
</x-app-layout>
