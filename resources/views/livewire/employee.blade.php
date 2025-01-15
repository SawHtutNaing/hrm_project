<div class="p-6   min-h-screen w-screen">



    <div class="bg-white rounded-lg  shadow-lg w-3/4  mx-auto p-6">

        <form wire:submit.prevent="save">
            <div class="grid grid-cols-2 gap-4">
                <div class='my-10'> 
                    <label class="block  font-medium">Name</label>
                    <x-text-input type="text" wire:model="name"
                        class="w-full border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring" />
                    @error('name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class='my-10'> 
                    <label class="block font-medium">Email</label>
                    <x-text-input type="email" wire:model="email"
                        class="w-full border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring" />
                    @error('email')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class='my-10'> 
                    <label class="block font-medium">Password</label>
                    <x-text-input type="password" wire:model="password"
                        class="w-full border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring" />
                    @error('password')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>



                <div class='my-10'> 
                    <label class="block font-medium">Department</label>



                    <x-searchable-select property='department_id' :values="$departments" class="mt-1 block w-full h-40"
                        placeholder="Select an Option..." />

                </div>


                <div class='my-10'> 
                    <label class="block font-medium">Role</label>



                    <x-searchable-select property='employee_role_id' :values="$employeeRoles" class="mt-1 block w-full h-40"
                        placeholder="Select an Option..." />

                </div>


                <div class='my-10'> 
                    <label class="block font-medium"> Nrc Code </label>
                    <x-text-input wire:model='nrc_code'
                        class="w-full border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring" />
                    @error('nrc_code')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>


            </div>
            <div class="mt-4 flex justify-end space-x-2">
                {{-- <button
                        type="button"
                        class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400"
                        wire:click="$set('modalVisible', false)"
                    >
                        Cancel
                    </button> --}}
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>




