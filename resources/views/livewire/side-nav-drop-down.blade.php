<div x-data="{ open: false }">
    <button @click="open = !open" type="button" class="{{collect($lists)->contains(fn($list) => request()->routeIs($list['route_name'])) ? 'bg-primary text-main' : 'text-black'}} flex items-center p-2 w-full text-base font-semibold rounded-lg transition duration-75 group  ">
        {!! $icon !!}
        <span class="flex-1 ml-3 text-left whitespace-nowrap font-arial text-sm">{{ $label }}</span>
        <svg :class="{ 'rotate-180': open }" aria-hidden="true" class="w-5 h-5 transform transition-transform" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
        </svg>
    </button>
    <ul x-show="open" x-cloak x-transition class="py-2 space-y-2 font-arial text-sm text-black">
        @foreach ($lists as $list)
            @if($list['route_name'] == 'sperator')
                <div class=" bg-slate-600  h-[1px] w-full ">

                </div>
            @else
                <li>
                    <a href="{{ route($list['route_name']) }}" class="{{request()->routeIs($list['route_name']) ? 'bg-white/90 text-primary-700' : 'text-black'}} flex items-center p-2 pl-11 w-full rounded-lg transition duration-75 group  hover:text-black font-semibold" wire:navigate>{{ $list['name'] }}</a>
                </li>
            @endif
        @endforeach
    </ul>
</div>
