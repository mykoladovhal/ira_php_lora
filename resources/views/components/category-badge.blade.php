@props(['category'])

@php
    $colors = [
        1 => 'bg-blue-100 text-blue-800',      // 博覧会
        2 => 'bg-green-100 text-green-800',    // 見本市・展示会
        3 => 'bg-purple-100 text-purple-800',  // 会議イベント
        4 => 'bg-amber-100 text-amber-800',    // 文化イベント
        5 => 'bg-red-100 text-red-800',        // スポーツイベント
        6 => 'bg-pink-100 text-pink-800',      // 販促イベント
        7 => 'bg-gray-100 text-gray-800',      // その他
    ];
    $colorClass = $colors[$category->id] ?? 'bg-gray-100 text-gray-800';
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {$colorClass}"]) }}>
    {{ $category->name }}
</span>
