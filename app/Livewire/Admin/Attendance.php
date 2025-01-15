<?php

namespace App\Livewire\Admin;

use App\Exports\AttendanceRecordsExport;
use App\Livewire\Forms\AttendanceForm;
use App\Models\AttendanceRecords;
use App\Models\Department;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class Attendance extends Component
{
    public AttendanceForm $AttendanceForm;

    public $showForm = false;

    // show data

    public $currentDate;

    public $currentTime;

    // show data
    public $attendanceRecord_id;

    public $message;

    public $employee;

    public $departments;

    public $confirm_edit;

    public $confirm_delete;

    public $confirm_add;

    // filter

    public $filterDate = 1;

    public $selectedDepartment = null;

    public $checkInTimeFilter = 1;

    public $user;

    public function mount()
    {
        $this->employee = User::all();
        $this->departments = Department::all();
        $this->currentDate = Carbon::now()->toDateString();
        $this->currentTime = Carbon::now()->format('h:i A');

        $this->user = User::find(auth()->id());

    }

    public function ToggleShowForm()
    {

        $this->showForm = ! $this->showForm;
    }

    public function update()
    {

        // dd($this->AttendanceForm->id);
        $this->AttendanceForm->update($this->AttendanceForm->id);
    }

    public function submitForm()
    {
        $this->AttendanceForm->save();
        $this->message = 'Record added successfully';
    }

    public function render()
    {

        $getTime = Carbon::now();

        if ($this->user->employeeRole->id == 1) {
            $attendanceRecords = $this->getRecords();

        } else {
            $attendanceRecords = $this->getRecords(2);

        }

        return view('livewire.attendance',

            [
                'attendanceRecords' => $attendanceRecords,
            ]
        );
    }

    public function showDetails($id)
    {

        $this->ToggleShowForm();
        $this->AttendanceForm->setModel(AttendanceRecords::find($id));

    }

    public function export()
    {
        return Excel::download(new AttendanceRecordsExport, 'att_records.xlsx');
    }

    public function getRecords($role = null)
    {

        $getTime = Carbon::now();
        $query = AttendanceRecords::query();
        if ($role == 2) {
            $query->where('user_id', $this->user->id);
        }
        // dep id
        $query->when($this->selectedDepartment, fn ($subQ) => $subQ->whereHas('user', fn ($subQ) => $subQ->where('department_id', $this->selectedDepartment)))

        // check in time
            ->when($this->checkInTimeFilter == 2, fn ($subQ) => $subQ->where('check_in_time', '<=', '8:00'))
            ->when($this->checkInTimeFilter == 3, fn ($subQ) => $subQ->where('check_in_time', '>', '8:00'));

        if ($this->filterDate == 2) {
            return $query->where('date', $getTime->toDateString())->paginate(20);
        } elseif ($this->filterDate == 3) {
            return $query->where('date', '>=', $getTime->subWeek()->toDateString())->paginate(20);
        } elseif ($this->filterDate == 4) {
            return $query->where('date', '>=', $getTime->subMonth()->toDateString())->paginate(20);
        }

        return $query->
        paginate(20);
    }
}
