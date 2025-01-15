<div class="relative overflow-x-auto shadow-md sm:rounded-lg mb-5">
    @if ($message)
        <div id="alert-border-1" class="flex items-center p-4 text-primary-800 border-t-4 border-primary-300 bg-primary-50" role="alert">
            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <div class="ms-3 text-sm font-medium font-arial"> {{$message}} </div>
            <button type="button" wire:click="$set('message', null)" class="ms-auto -mx-1.5 -my-1.5 bg-primary-50 text-primary-500 rounded-lg focus:ring-2 focus:ring-primary-400 p-1.5 hover:bg-primary-200 inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#alert-border-1" aria-label="Close">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
    @endif
    <div class="font-arial text-md uppercase text-white bg-primary py-3 px-6 font-semibold flex flex-row justify-between items-center">
        {{ $title }}
        @if(is_null($data_values?->retire_type_id))

        <div class="flex flex-row gap-3">

            <button wire:click='add_new' type="button" class="text-primary-500 bg-white border border-white hover:bg-primary-200 hover:text-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span class="sr-only">Add Icon</span>
            </button>
        </div>
        @endif
    </div>
    <table class="w-full text-sm text-gray-500">
        @if (!$data_values)
            <tbody>
                <tr class="font-arial bg-white border-b hover:bg-gray-50">
                    <td colspan="3" class="px-6 py-4">No Information</td>
                </tr>
            </tbody>
        @else
            <thead class="font-arial text-xs text-center text-gray-700 uppercase bg-gray-50">
                <tr>
                    @foreach ($columns as $col)
                        <th scope="col" class="px-6 py-3">{{$col}}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="text-center">



                    <tr class="font-arial bg-white border-b hover:bg-gray-50">
                        <td class="px-6 py-4 text-gray-500">1</td>
                        @foreach ($column_vals as $val)

                            <td class="px-6 py-4 text-gray-500">

                           @if (gettype($data_values->$val)== 'object')

                           {{$data_values->$val->name}}
                               @else
                               {{$data_values->$val}}
                           @endif
                            </td>





                        @endforeach


                        <td class="px-6 py-4">
                            @if($confirm_delete == true )
                                <div>
                                    <div>Confirm?</div>
                                    <button wire:click="delete({{$data_values->id}})" class="text-red-600 hover:underline">Delete</button> |
                                    <button wire:click="$set('confirm_delete', false)" class="text-primary-600 hover:underline">Back</button>
                                </div>
                            @else
                                @if (isset($data_values->staff_no))
                                    <button type="button" wire:click='open_report({{$data_values->id}})' class="font-medium text-yellow-600 hover:underline">Reports</button> |
                                @endif
                                <button type="button" wire:click='edit_modal({{$data_values->id}})' class=" font-medium text-primary-600 hover:underline">Edit</button>



                                @if(!($disabledMode ?? false) == 'toggle')
                                |





                                <button type="button" wire:click="delete_confirm({{ $data_values->id }})" class="font-medium text-red-600 hover:underline">Remove</button>
                            @endif
                            @endif
                        </td>
                    </tr>

            </tbody>
        @endif
    </table>

    @if ($confirm_edit || $confirm_add)

        @include($modal)
    @endif
</div>
