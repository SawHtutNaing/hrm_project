<div class="p-6   min-h-screen w-screen">
    <div class="max-w-7xl mx-auto  shadow rounded-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-semibold text-white">Staff Management</h1>
            <button
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                wire:click="create"
            >
                Add New Staff
            </button>
        </div>

        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-gray-100 border-b border-gray-300">
                <tr>
                    <th class="text-left p-2">#</th>
                    <th class="text-left p-2">Name</th>
                    <th class="text-left p-2">Staff No</th>
                    <th class="text-left p-2">Phone</th>
                    <th class="text-left p-2">Email</th>
                    <th class="text-center p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($staffs as $staff)
                <tr class="border-b border-gray-200">
                    <td class="p-2">{{ $loop->iteration }}</td>
                    <td class="p-2">{{ $staff->name }}</td>
                    <td class="p-2">{{ $staff->staff_no }}</td>
                    <td class="p-2">{{ $staff->phone }}</td>
                    <td class="p-2">{{ $staff->email }}</td>
                    <td class="p-2 flex justify-center space-x-2">
                        <button
                            class="bg-primary text-white px-2 py-1 rounded hover:bg-primary-600"
                            wire:click="edit({{ $staff->id }})"
                        >
                            Edit
                        </button>
                        <button
                            class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600"
                            wire:click="delete({{ $staff->id }})"
                        >
                            Delete
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $staffs->links() }}
        </div>
    </div>

    
    @if ($modalVisible)
    {{-- @if (true) --}}
    <div
        class="fixed inset-0  h-screen     bg-gray-900 bg-opacity-50 w-screen  mx-auto flex items-center justify-center z-50"
    >
        <div class="bg-white rounded-lg  h-3/4 overflow-scroll shadow-lg w-3/4  mx-auto p-6">
            <h2 class="text-lg font-semibold mb-4">
                {{ $isEdit ? 'Edit Staff' : 'Add New Staff' }}
            </h2>
            <form wire:submit.prevent="save">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-medium">Name</label>
                        <x-text-input
                            type="text"
                            wire:model="name"
                            class="w-full border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring"
                        />
                        @error('name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-medium">Nick Name</label>
                        <x-text-input
                            type="text"
                            wire:model="nick_name"
                            class="w-full border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring"
                        />
                        @error('nick_name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-medium">Other Name</label>
                        <x-text-input
                            type="text"
                            wire:model="other_name"
                            class="w-full border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring"
                        />
                        @error('other_name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>


                    <div>
                        <label class="block font-medium">Date Of Birth  </label>
                        <x-date-picker
                            
                            wire:model="dob"
                            class="w-full border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring"
                        />
                        @error('dob')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block font-medium">Staff No</label>
                        <x-text-input
                            type="text"
                            wire:model="staff_no"
                            class="w-full border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring"
                        />
                        @error('staff_no')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block font-medium">Phone</label>
                        <x-text-input
                            type="text"
                            wire:model="phone"
                            class="w-full border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring"
                        />
                        @error('phone')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>


                    <div>
                        <label class="block font-medium">Address</label>
                        <x-text-input
                            type="text"
                            wire:model="address"
                            class="w-full border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring"
                        />
                        @error('address')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    
                    <div>
                        <label class="block font-medium">Email</label>
                        <x-text-input
                            type="email"
                            wire:model="email"
                            class="w-full border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring"
                        />
                        @error('email')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>  

                    <div>
                        <label class="block font-medium">Department</label>
                


                    <x-searchable-select
                    property='department_id'
                        :values="$departments"
                    class="mt-1 block w-full h-40"
                    placeholder="Select an Option..." 
                    
                    />

                    </div>


                    <div>
                        <label class="block font-medium">Rank</label>
                


                    <x-searchable-select
                    property='rank_id'
                        :values="$ranks"
                    class="mt-1 block w-full h-40"
                    placeholder="Select an Option..." 
                    
                    />

                    </div>

                    <div>
                        <label class="block font-medium"> Attend id  </label>
                       <x-text-input
                       wire:model='attendid'
                       class="w-full border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring"
                       
                       /> 
                        @error('attendid')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>


                    
                    <div>
                        <label class="block font-medium"> Blood Type  </label>
                      
                    <x-searchable-select
                    property='blood_type_id'
                        :values="$bloodtypes"
                    class="mt-1 block w-full h-40"
                    placeholder="Select an Option..." 
                    
                    />
                        @error('blood_type_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>


                    
                    <div>
                        <label class="block font-medium"> Company Staff Number  </label>
                       <x-text-input
                       wire:model='company_staff_number'
                       class="w-full border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring"
                       
                       /> 
                        @error('company_staff_number')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    
                       <div>
                        <label class="block font-medium"> High  </label>
                       <x-text-input
                       type='number'
                       wire:model='height_feet'
                       class="w-full border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring"
                       
                       /> 
                        @error('height_feet')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    

                    <div>
                        <label class="block font-medium"> Hair Color   </label>
                       <x-text-input
                       wire:model='hair_color'
                       class="w-full border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring"
                       
                       /> 
                        @error('hair_color')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-medium"> Eye  Color   </label>
                       <x-text-input
                       wire:model='eye_color'
                       class="w-full border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring"
                       
                       /> 
                        @error('eye_color')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>



                    <div>
                        <label class="block font-medium"> Skin  Color   </label>
                       <x-text-input
                       wire:model='skin_color'
                       class="w-full border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring"
                       
                       /> 
                        @error('skin_color')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>




                    <div>
                        <label class="block font-medium"> Nrc Code    </label>
                       <x-text-input
                       wire:model='nrc_code'
                       class="w-full border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring"
                       
                       /> 
                        @error('nrc_code')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    


                    <div class="grid grid-cols-2 gap-4">
                        <!-- NRC Front Section -->
                        <div class="flex flex-col">
                            <div class="mb-4">

                                <img 
                                src="{{ $nrc_front ? (is_string($nrc_front) ? route('file', $nrc_front) : $nrc_front->temporaryUrl()) : asset('img/img.png') }}" 
                                class="w-40 h-40 rounded-md border-2 border-gray-400">
                            

                                {{-- @if ( $nrc_front)
                                    <img src="{{ route('file', $nrc_front) }}" class="w-40 h-40 rounded-md border-2 border-gray-400">
                                @else
                                    <img src="{{ $nrc_front ? $nrc_front->temporaryUrl() : asset('img/img.png') }}" class="w-40 h-40 rounded-md border-2 border-gray-400">
                                @endif --}}
                            </div>
                            <x-input-label for="nrc_front" :value="__('နိုင်ငံသားစိစစ်ရေးကတ်ပြား (အရှေ့ဘက်)')"/>
                            <x-input-file wire:model='nrc_front' id="nrc_front" accept=".jpg, .jpeg, .png" name="nrc_front" class="block w-full text-sm border rounded-lg cursor-pointer text-gray-700 focus:outline-none placeholder-gray-400 mt-1 font-arial bg-white border-gray-300" />
                            <x-input-error class="mt-1" :messages="$errors->get('nrc_front')" />
                        </div>
            
                        <!-- NRC Back Section -->
                        <div class="flex flex-col">
                            <div class="mb-4">
                                <img 
                                src="{{ $nrc_back ? (is_string($nrc_back) ? route('file', $nrc_back) : $nrc_back->temporaryUrl()) : asset('img/img.png') }}" 
                                class="w-40 h-40 rounded-md border-2 border-gray-400">
                            


                                {{-- @if ( $nrc_back)
                                    <img src="{{ route('file', $nrc_back) }}" class="w-40 h-40 rounded-md border-2 border-gray-400">
                                @else
                                    <img src="{{ $nrc_back ? $nrc_back->temporaryUrl() : asset('img/img.png') }}" class="w-40 h-40 rounded-md border-2 border-gray-400">
                                @endif --}}
                            </div>
                            <x-input-label for="nrc_back" :value="__('နိုင်ငံသားစိစစ်ရေးကတ်ပြား (အနောက်ဘက်)')"/>
                            <input wire:model='nrc_back' id="nrc_back" accept=".jpg, .jpeg, .png" name="nrc_back" type="file" class="block w-full text-sm border rounded-lg cursor-pointer text-gray-700 focus:outline-none placeholder-gray-400 mt-1 font-arial bg-white border-gray-300" />
                            <x-input-error class="mt-1" :messages="$errors->get('nrc_back')" />
                        </div>
                    </div>

                    



                    
                    



                 
                </div>
                <div class="mt-4 flex justify-end space-x-2">
                    <button
                        type="button"
                        class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400"
                        wire:click="$set('modalVisible', false)"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                    >
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
