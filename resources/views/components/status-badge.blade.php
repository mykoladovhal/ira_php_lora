@props(['status'])

@php
    $config = [
        'registered' => [
            'class' => 'bg-green-100 text-green-800',
            'label' => '申込み済'
        ],
        'cancelled' => [
            'class' => 'bg-gray-100 text-gray-800',
            'label' => 'キャンセル済'
        ],
    ];
    $statusConfig = $config[$status] ?? $config['registered'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {$statusConfig['class']}"]) }}>
    {{ $statusConfig['label'] }}
</span>
