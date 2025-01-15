@props(['disabled' => false, 'values' => [], 'placeholder' => '', 'all' => false])
{{-- {{$disabled ? 'true' : ' false '}} --}}

<select {{ $disabled ? 'disabled' : '' }} {!!
 $attributes->merge(['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 p-2.5 font-arial']) !!}>
    @if($all == true)
        <option value="all">All</option>
    @endif
    @if ($placeholder)
        <option value="">{{ $placeholder }}</option>
    @endif
    @foreach ($values as $value)
        <option value="{{ $value->id }}">{{ $value->name }}</option>
    @endforeach
</select>



