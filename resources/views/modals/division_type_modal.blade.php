<div class="fixed z-50 inset-0 overflow-y-auto bg-gray-900 bg-opacity-20 flex justify-center items-center text-left" wire:ignore.self>
    <!-- Modal Content -->
    <div class="bg-white rounded-lg shadow-xl w-96 p-4">
        <!-- Modal Content -->
        <h2 class="text-lg font-semibold mb-4 text-gray-500 font-arial uppercase">{{ $modal_title }}</h2>
        <form wire:submit.prevent="{{$submit_form}}">
            <div class="mb-4">
                <label for="division_type_name" class="block mb-1 text-gray-600 font-arial">Division Type </label>
                <input required type="text" wire:model="division_type_name" id="division_type_name" class="font-arial bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                @error('division_type_name') <span class="mt-1 text-red-500 text-xs font-arial font-semibold">{{ $message }}</span> @enderror
            </div>
      
        
           
            
        
            <br>
            <button
            type="submit"
  class="inline-flex h-10 items-center justify-center gap-1 rounded-md bg-primary px-3 text-sm text-primary-text transition-colors duration-150 hover:bg-primary/90 active:brightness-95"
>
{{ $submit_button_text }}
</button>

            
            <button type="button" wire:click="{{ $cancel_action }}" 
            class="inline-flex h-10 items-center justify-center gap-1 rounded-md bg-secondary px-3 text-sm text-secondary-text transition-colors duration-150 hover:bg-secondary/90 active:brightness-95"

            >close</button>
        </form>
    </div>
</div>















{{-- <div class="fixed z-50 inset-0 overflow-y-auto bg-gray-900 bg-opacity-20 flex justify-center items-center text-left" wire:ignore.self>
    <!-- Modal Content -->
    <div class="bg-white rounded-lg shadow-xl w-96 p-4">
        <!-- Modal Content -->
        <h2 class="text-lg font-semibold mb-4 text-gray-500 font-arial uppercase">{{ $modal_title }}</h2>
        <form wire:submit.prevent="{{$submit_form}}">
            <div class="mb-4">
                <label for="name" class="block mb-1 text-gray-600 font-arial">ခွင့်အမျိုးအစား
                </label>
                <input required type="text" wire:model="leave_type" id="name" class="font-arial bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                @error('leave_type') <span class="mt-1 text-red-500 text-xs font-arial font-semibold">{{ $message }}</span> @enderror
            </div>
            <label for="allowed" class="block mb-1 text-gray-600 font-arial">ခွင့်
            </label>
            <input required type="number" wire:model="allowed" id="allowed" class="font-arial bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
            @error('allowed') <span class="mt-1 text-red-500 text-xs font-arial font-semibold">{{ $message }}</span> @enderror
            <br>

            <div class="relative">
                <select
                    wire:model="day_or_month_name"
                    class="text-sm font-arial block w-full mb-4 p-2.5 border border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50">
                    <option value="" selected>နေ့(သို့မဟုတ်)လရွေးပါ</option>
                    @foreach ($dayOrMonths as $dayOrMonth)
                        <option value="{{ $dayOrMonth->id }}"> {{ $dayOrMonth->name }} </option>
                    @endforeach
                </select>
            </div>
            </div>
            <label for="sort_no" class="block mb-1 text-gray-600 font-arial">SortNo
            </label>
            <input required type="number" wire:model="sort_no" id="sort_no" class="font-arial bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
            @error('sort_no') <span class="mt-1 text-red-500 text-xs font-arial font-semibold">{{ $message }}</span> @enderror
            <br>

            <div>
                <label for="is_yearly" class="block mb-1 text-gray-600 font-arial">နှစ်စဉ်
                </label>
                <x-radio-input id1="is_yearly_1" id2="is_yearly_2" wire="is_yearly" />
                <x-input-error class="mt-2" :messages="$errors->get('is_yearly')" />
            </div>
            <br>
            <button type="submit" class=" hover:bg-primary-800 text-white px-4 py-2 rounded font-arial">{{ $submit_button_text }}</button>
            <button type="button" wire:click="{{ $cancel_action }}" class="font-arial bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">close</button>
        </form>
    </div>
</div> --}}
