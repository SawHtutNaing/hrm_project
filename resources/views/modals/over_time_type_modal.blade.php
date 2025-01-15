<div class="fixed z-50 inset-0 overflow-y-auto bg-gray-900 bg-opacity-20 flex justify-center items-center text-left" wire:ignore.self>
    <!-- Modal Content -->
    <div class="bg-white rounded-lg shadow-xl w-96 p-4">
        <!-- Modal Content -->
        <h2 class="text-lg font-semibold mb-4 text-gray-500 font-arial uppercase">{{ $modal_title }}</h2>
        <form wire:submit.prevent="{{$submit_form}}">
            <div class="mb-4">
                <label for="over_time_type_name" class="block mb-1 text-gray-600 font-arial">Over Time </label>
                <input required type="text" wire:model="over_time_type_name" id="over_time_type_name" class="font-arial bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                @error('over_time_type_name') <span class="mt-1 text-red-500 text-xs font-arial font-semibold">{{ $message }}</span> @enderror
            </div>

 
           
        
       
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
