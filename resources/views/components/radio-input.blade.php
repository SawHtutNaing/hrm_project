<div class="flex gap-2 mt-1 w-full">
    <div class="flex items-center me-4">
        <input id="{{$id1}}" type="radio" value="1" wire:model.live="{{$wire}}" class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 focus:ring-primary-500">
        <label for="{{$id1}}" class="font-arial ms-2 text-sm font-medium text-gray-900">Yes</label>
    </div>
    <div class="flex items-center me-4">
        <input id="{{$id2}}" type="radio" value="0" wire:model.live="{{$wire}}" class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 focus:ring-primary-500">
        <label for="{{$id2}}" class="font-arial ms-2 text-sm font-medium text-gray-900">No</label>
    </div>
</div>
