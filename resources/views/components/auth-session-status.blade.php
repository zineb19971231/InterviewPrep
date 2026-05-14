@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'px-4 py-3 bg-success-50 border border-success-200 text-success-700 rounded-xl text-sm']) }}>
        {{ $status }}
    </div>
@endif