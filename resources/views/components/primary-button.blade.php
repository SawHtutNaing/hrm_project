<button
    {{ $attributes->merge([
        'type' => 'submit',
        'class' => '
            inline-flex h-10 items-center justify-center gap-1 rounded-md
            bg-primary px-3 text-sm text-primary-text transition-colors 
            duration-150 hover:bg-primary/90 active:brightness-95
        '
    ]) }}
>
    {{ $slot }}
</button>
