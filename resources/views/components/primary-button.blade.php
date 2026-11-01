<button {{ $attributes->merge(['type' => 'submit', 'class' => 'glass-button-primary']) }}>
    {{ $slot }}
</button>
