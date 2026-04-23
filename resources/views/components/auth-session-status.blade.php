@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm flex item-center justify-center text-green-600']) }}>
        {{ $status }}
    </div>
@endif
