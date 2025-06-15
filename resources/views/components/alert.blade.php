@props([
    'field' => null,
    'class' => 'text-red-500 text-sm mt-1'
])

@if ($field && $errors->has($field))
    <p {{ $attributes->merge(['class' => $class]) }}>
        {{ $errors->first($field) }}
    </p>
@endif
