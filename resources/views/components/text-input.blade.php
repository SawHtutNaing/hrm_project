@props(['disabled' => false , 'placeholder' => " "])



<div class="   w-80">
    <input
    @disabled($disabled)
     {{ $attributes->merge(['class' => '
     peer flex h-10 w-full rounded-md border bg-transparent px-3 py-2 text-sm outline-none placeholder:text-muted-text autofill:shadow-[inset_0_0_0px_1000px_hsl(var(--surface))] autofill:[-webkit-text-fill-color:hsl(hsl(--main-text))_!important] focus-visible:border-input-border focus-visible:outline-none focus-visible:ring-1'])
    }}
    
      {{-- placeholder={{ $placeholder }} --}}
      {{-- id={{$attributes['id']}} --}}
    />
  </di



  