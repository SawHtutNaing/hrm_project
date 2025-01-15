<div class="  px-5 py2 ">


  <div class=" ms-auto  w-32 my-5">

    <div>
      {{$currentDate}}
    </div>
    <div>
      {{$currentTime}}
    </div>

  </div>
    
  @can('hr_att')
  <div class=" my-5 flex  gap-x-6">


        <x-primary-button wire:click='ToggleShowForm'>
        
            {{
              $showForm ? 'Back' : 'Add Attendence '
            }}
        </x-primary-button>
        @if(!$showForm)
        <x-primary-button class=" !me-auto bg-green-500"  wire:click='export'>
        
          Export Excel
      </x-primary-button>
@endif 
    </div>

    @endcan 
@if (!$showForm)
<div
class="relative
 w-full   overflow-auto rounded-2xl border border-main-border bg-surface"
>
@can('hr_att')

<div class=" flex  justify-start gap-x-5 items-center ">
  <div class="my-5  max-w-sm ms-5">
    <select 
      wire:model.live="filterDate" 
      id="" 
        class="block
       p-3
       w-32 bg-white border border-gray-300 text-gray-700 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 ">
      <option value="1">All Time </option>
      <option value="2">Today</option>
      <option value="3">This Week</option>
      <option value="4">This Month</option>
    </select>
  </div>
  
  <div class="my-5  w-32  ms-5">
    <x-select
    class="block
    p-3
    w-full bg-white border border-gray-300 text-gray-700 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 "
      :values='$departments'
      placeholder='All Dept'
      wire:model.live='selectedDepartment'/>
  </div>

  <div class="my-5  max-w-sm ms-5">
    <select 
    wire:model.live="checkInTimeFilter" 
    id="" 
    class="block w-32 bg-white border border-gray-300 text-gray-700 text-sm rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2.5 hover:bg-gray-50 transition-colors duration-200 ease-in-out">
    <option value="1" class="text-gray-700">All Check In</option>
    <option value="2" class="text-gray-700">Arrive In Time</option>
    <option value="3" class="text-gray-700">Late</option>
</select>

  </div>


</div>
@endcan 

<table class="w-full text-left text-sm text-main-text rtl:text-right">
  <thead class="bg-accent text-xs uppercase text-muted-text">
    <tr>
      <th scope="col" class="px-4 py-3">Name</th>
      <th scope="col" class="px-4 py-3">Rank</th>
      <th scope="col" class="px-4 py-3">Date</th>
      <th scope="col" class="px-4 py-3">Check In Time </th>
      <th scope="col" class="px-4 py-3">Check In Location </th>
      <th scope="col" class="px-4 py-3">Check Out Time </th>
      <th scope="col" class="px-4 py-3">Check Out Location </th>
      <th scope="col" class="px-4 py-3">Working Hours </th>
    </tr>
  </thead>

  <tbody>
    @foreach ( $attendanceRecords as $attendanceRecord )
    <tr class="border-b bg-surface text-main-text"
    
  
  @can('hr_att')
  
    wire:click='showDetails({{$attendanceRecord->id}})'

    @endcan
    >
      <th scope="row" class="whitespace-nowrap px-4 py-3 font-medium">
       {{$attendanceRecord->user->name}}
      </th>
      
      <td class="px-4 py-3">{{$attendanceRecord->user->employeeRole->name}}</td>
      <td class="px-4 py-3">{{$attendanceRecord->date}}</td>

      <td class="px-4 py-3">
        {{ \Carbon\Carbon::parse($attendanceRecord->check_in_time)->format('h:i A') }}

      </td>
      <td class="px-4 py-3">{{$attendanceRecord->check_in_location}}</td>
      <td class="px-4 py-3">
        {{-- {{$attendanceRecord->check_out_time}} --}}
        {{ \Carbon\Carbon::parse($attendanceRecord->check_out_time)->format('h:i A') }}

      </td>
      <td class="px-4 py-3">{{$attendanceRecord->check_out_location}}</td>
     
    
    
      <td class="px-4 py-3">
        {{$attendanceRecord->hours_worked}}
      </td>

    </tr>

  
    @endforeach
  </tbody>
</table>
</div>
@else 



<form class= " min-w-[60vw] mx-auto bg-white p-5 rounded-lg shadow-md" 
@if('AttendanceForm.user_id')
wire:submit='update'

@else 
wire:submit='submitForm'
@endif 
>

  <div class="mb-5">


    <x-searchable-select
    
    :values='$employee'
    property='AttendanceForm.user_id'
    />
  </div>

  
  <div class="mb-5">
    
    <label for="checkInLocation" class="block mb-2 text-sm font-medium text-gray-700">Check In Location </label>
    <x-text-input type="text" id="checkInLocation" 
    wire:model='AttendanceForm.checkInLocation'
    class="bg-white border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Check In Location" required />
  </div>
  <div class="mb-5">
    <label for="checkOutLocation" class="block mb-2 text-sm font-medium text-gray-700">Check Out Location</label>
    <x-text-input type="text" id="checkOutLocation" 
    wire:model='AttendanceForm.checkOutLocation'
    class="bg-white border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Check Out Location" required />


  </div>
  <div class="mb-5">
    <label for="checkInTime" class="block mb-2 text-sm font-medium text-gray-700">Check In Time</label>
    <x-text-input type="time" id="checkInTime" 
    wire:model='AttendanceForm.checkInTime'
    class="bg-white border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="" required />

  </div>
  <div class="mb-5">
    <label for="checkOutTime" class="block mb-2 text-sm font-medium text-gray-700">Check Out Time</label>
    <x-text-input type="time" id="checkOutTime" 
    wire:model='AttendanceForm.checkOutTime'
    class="bg-white border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="" required />


  </div>
  <div class="mb-5">
    <label for="workingHours" class="block mb-2 text-sm font-medium text-gray-700">Working Hours</label>
    <x-text-input type="text" id="workingHours" 
    wire:model='AttendanceForm.workingHours'
    class="bg-white border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="" required />



  </div>
  <div class="mb-5">
    <label for="date" class="block mb-2 text-sm font-medium text-gray-700">Date</label>
    <x-text-input type="date" id="date" 
    wire:model='AttendanceForm.date'
    class="bg-white border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="" required />



  </div>
  <div class="mb-5">
    <label for="note" class="block mb-2 text-sm font-medium text-gray-700">Note</label>
    <textarea id="note" 
    wire:model='AttendanceForm.note'
    class="bg-white border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="" required ></textarea>
  </div>




  <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Submit</button>
</form>



@endif
</div>