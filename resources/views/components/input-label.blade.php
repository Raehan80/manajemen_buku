@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-sm font-medium text-emerald-50/80']) }}>
    {{ $value ?? $slot }}
</label>
