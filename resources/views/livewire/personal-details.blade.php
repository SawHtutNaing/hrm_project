<div class="p-8 min-h-screen w-screen bg-gray-100">

    <div class="bg-white rounded-xl shadow-xl w-3/4 mx-auto p-8">
        <form wire:submit.prevent="save">
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-lg font-semibold text-gray-700">Name</label>
                    <x-text-input type="text" wire:model="name" 
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-blue-300" />
                    @error('name')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-lg font-semibold text-gray-700">Email</label>
                    <x-text-input type="email" wire:model="email" 
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-blue-300" />
                    @error('email')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-lg font-semibold text-gray-700">Department</label>
                    <x-searchable-select property='department_id' :values="$departments" 
                        class="mt-2 block w-full h-40 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-300" 
                        placeholder="Select an Option..." />
                </div>

                <div>
                    <label class="block text-lg font-semibold text-gray-700">Rank</label>
                    <x-searchable-select property='rank_id' :values="$employeeRoles" 
                        class="mt-2 block w-full h-40 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-300" 
                        placeholder="Select an Option..." />
                </div>

                <div>
                    <label class="block text-lg font-semibold text-gray-700">NRC Code</label>
                    <x-text-input wire:model='nrc_code' 
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-blue-300" />
                    @error('nrc_code')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-4">
                <button type="submit" 
                    class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-300">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
