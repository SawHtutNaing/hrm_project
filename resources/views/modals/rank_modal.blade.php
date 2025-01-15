<div class="fixed z-50 inset-0 overflow-y-auto bg-light-900  flex justify-center items-center text-left" wire:ignore.self>
    <!-- Modal Content -->
    <div class="bg-neutral rounded-lg shadow-xl w-96 p-4">
        <!-- Modal Content -->
        <h2 class="text-lg font-semibold mb-4 text-light-500 font-arial uppercase">{{ $modal_title }}</h2>
        <form wire:submit.prevent="{{$submit_form}}">
            <div class="mb-4">
                <label for="name" class="block mb-1  text-white  font-arial"> Name </label>
                <input required type="text" wire:model="name" id="name" class="font-arial  border border-light-300 text-light-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                @error('name') <span class="mt-1 text-red-500 text-xs font-arial font-semibold">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="sort_no" class="block mb-1  text-white font-arial">Sort No </label>
                <input required type="text" wire:model="sort_no" id="sort_no" class="font-arial  border border-light-300 text-light-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                @error('sort_no') <span class="mt-1 text-red-500 text-xs font-arial font-semibold">{{ $message }}</span> @enderror
            </div>
    <x-searchable-select  property="payscale_id" :values="$payscales" 

          />
        
           
        
       
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
