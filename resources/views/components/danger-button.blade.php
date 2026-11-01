<button {{ $attributes->merge(['type' => 'submit', 'class' => 'glass-button-danger']) }}>
    {{ $slot }}
</button>
