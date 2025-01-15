<div class="relative overflow-x-auto shadow-md sm:rounded-lg mb-5">

    <div
        class="font-sans text-lg uppercase text-gray-800 py-4 px-6 font-semibold flex flex-row justify-between items-center">
        {{ $title }}
        <div class="flex flex-row gap-3">
            <div class="relative">
                <div
                    class="absolute inset-y-0 left-0 rtl:inset-r-0 rtl:right-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>

                <input wire:model.live='{{ $search_id }}' type="text" id="{{ $search_id }}"
                    class="block p-2 ps-10 text-sm text-gray-700 border border-gray-300 rounded-lg w-64 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="{{ $title }} Search">
            </div>

            <button wire:click='add_new' type="button"
                class="text-blue-700 ring-blue-300 bg-white border border-gray-300 hover:bg-blue-200 hover:text-blue-900 focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-full p-2.5 text-center inline-flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span class="sr-only">Add Icon</span>
            </button>
        </div>
    </div>
    <table class="w-full text-sm text-gray-700">
        @if ($data_values->isEmpty())
            <tbody>
                <tr class="font-sans bg-white border-b hover:bg-gray-100">
                    <td colspan="3" class="px-6 py-4">No Information</td>
                </tr>
            </tbody>
        @else
            <thead class="font-sans text-xs text-center text-gray-600 uppercase bg-gray-200">
                <tr>
                    @foreach ($columns as $col)
                        <th scope="col" class="px-6 py-3">{{ $col }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="text-center">
                @foreach ($data_values as $value)
                    @php
                        $startIndex = ($data_values->currentPage() - 1) * $data_values->perPage() + 1;
                        $index = $startIndex + $loop->index;
                    @endphp
                    <tr class="font-sans bg-white border-b hover:bg-gray-100">
                        <td class="px-6 py-4 text-gray-600">{{ $index }}</td>
                        @foreach ($column_vals as $val)
                            <td class="px-6 py-4 text-gray-600">
                                @if ($val == 'status')
                                    {{ $value->$val == 1 ? 'Active' : 'Inactive' }}
                                @else
                                    @if (gettype($value->$val) == 'object')
                                        {{ $value->$val->name }}
                                    @elseif ((is_string($value->$val) && Str::contains($value->$val, 'staffs/')) || Str::contains($value->$val, 'avatars/'))
                                        <img src="{{ route('file', $value->$val) }}" alt="Image"
                                            class="w-20 h-20 mx-auto rounded-full">
                                    @else
                                        {{ $value->$val ? $value->$val : '-' }}
                                    @endif
                                @endif
                            </td>
                        @endforeach
                        <td class="px-4 py-3 flex gap-2">
                            <button wire:click="edit({{ $value->id }})"
                                class="text-blue-600 hover:underline">Edit</button>
                            <button wire:click="delete({{ $value->id }})"
                                class="text-red-600 hover:underline">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        @endif
    </table>
    <div class="px-6 py-3 bg-gray-200">
        <div class="px-6 bg-light">
            {{ $data_values->links() }}
        </div>
    </div>
    @if ($confirm_edit || $confirm_add)
        @include($modal)
    @endif
</div>



{{-- 
 <div class="relative overflow-x-auto shadow-md sm:rounded-lg mb-5">
    <div class="font-arial text-md uppercase text-black py-3 px-6 font-semibold flex flex-row justify-between items-center">
        {{ $title }}
        <div class="flex flex-row gap-3">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 rtl:inset-r-0 rtl:right-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                </div>
                <input wire:model.live='{{ $search_id }}' type="text" id="{{ $search_id }}" class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-64 bg-gray-50 focus:ring-green-500 focus:border-green-500" placeholder="{{$title}} Search">
            </div>
            <button wire:click='add_new' type="button" class="text-green-700 ring-green-300 bg-white border border-white hover:bg-green-200 hover:text-green-900 focus:ring-4 focus:outline-none focus:ring-green-300 font-bold rounded-full p-2.5 text-center inline-flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span class="sr-only">Add Icon</span>
            </button>
        </div>
    </div>
    <table class="w-full text-left text-sm text-main-text rtl:text-right">
        <thead class="bg-accent text-xs uppercase text-muted-text">
            <tr>
                <th scope="col" class="px-4 py-3">Customer name</th>
                <th scope="col" class="px-4 py-3">Date/Time</th>
                <th scope="col" class="px-4 py-3">Location</th>
                <th scope="col" class="px-4 py-3">Total</th>
                <th scope="col" class="px-4 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data_values as $value)
                @php
                    $startIndex = ($data_values->currentPage() - 1) * $data_values->perPage() + 1;
                    $index = $startIndex + $loop->index;
                @endphp
                <tr class="border-b bg-surface text-main-text">
                    <th scope="row" class="whitespace-nowrap px-4 py-3 font-medium">{{ $value->customer_name }}</th>
                    <td class="px-4 py-3">{{ $value->date_time }}</td>
                    <td class="px-4 py-3"><p class="w-28 truncate">{{ $value->location }}</p></td>
                    <td class="px-4 py-3">${{ $value->total }}</td>
                    <td class="px-4 py-3 flex gap-2">
                        <button wire:click="edit({{ $value->id }})" class="text-blue-600 hover:underline">Edit</button>
                        <button wire:click="delete({{ $value->id }})" class="text-red-600 hover:underline">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="px-6 py-3 bg-gray-100">
        <div class="px-6 bg-light">
            {{ $data_values->links() }}
        </div>
    </div>
    @if ($confirm_edit || $confirm_add)
        @include($modal)
    @endif
</div> --}}
