@props(['mesyellows'])

@if ($mesyellows)
    <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 space-y-1']) }}>
        @foreach ((array) $mesyellows as $mesyellow)
            <li>{{ $mesyellow }}</li>
        @endforeach
    </ul>
@endif
