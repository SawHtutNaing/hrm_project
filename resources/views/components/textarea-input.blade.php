@props(['disabled' => false])

<textarea {{ $disabled ? 'disabled' : '' }} 
{!! $attributes->merge(['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block p-2.5 font-arial']) !!}
rows="4" 
>
{{ $slot }}</textarea>



