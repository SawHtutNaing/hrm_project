<?php

namespace App\Livewire\Forms;

use App\Models\AttendanceRecords;
use Carbon\Carbon;
use Livewire\Attributes\Validate;
use Livewire\Form;

class AttendanceForm extends Form
{
    public $user_id;

    public $checkInLocation;

    public $checkInTime;

    public $checkOutTime;

    public $checkOutLocation;

    public $workingHours;

    public $date;

    public $note;

    public $id;

    public function save()
    {
        // $this->validate([
        //     'user_id' => 'required',
        //     'check_in_location' => 'required',
        //     'check_in_time' => 'required',
        //     'check_out_time' => 'required',
        //     'check_out_location' => 'required',
        //     'hours_worked' => 'required',
        // ]);

        // Save the record
        $attendanceRecord = new AttendanceRecords;
        $attendanceRecord->user_id = $this->user_id;
        $attendanceRecord->check_in_location = $this->checkInLocation;
        // dd( $this->checkInTime);
        $attendanceRecord->check_in_time = $this->checkInTime;
        // $attendanceRecord->check_in_time = '1:00:00'; // Set

        $attendanceRecord->check_out_time = $this->checkOutTime;
        $attendanceRecord->check_out_location = $this->checkOutLocation;
        $attendanceRecord->hours_worked = $this->workingHours;
        $attendanceRecord->date = $this->date;

        $attendanceRecord->note = $this->note;

        $attendanceRecord->save();

        // Reset the form
        $this->reset();
    }

    public function setModel(AttendanceRecords $attendanceRecord): void
    {
        // $this->attendanceRecord = $attendanceRecord;

        // $this->fill($attendanceRecord);
        $this->user_id = $attendanceRecord->user_id;
        $this->id = $attendanceRecord->id;
        $this->checkInLocation = $attendanceRecord->check_in_location;
        $this->checkInTime = $attendanceRecord->check_in_time;
        $this->checkOutTime = $attendanceRecord->check_out_time;
        $this->checkOutLocation = $attendanceRecord->check_out_location;
        $this->workingHours = $attendanceRecord->hours_worked;
        $this->date = $attendanceRecord->date;

        $this->note = $attendanceRecord->note;

    }

    public function update($id)
    {
        $attendanceRecord = AttendanceRecords::find($id);

        if ($attendanceRecord) {

            $attendanceRecord->user_id = $this->user_id;
            $attendanceRecord->id = $this->id;
            $attendanceRecord->check_in_location = $this->checkInLocation;
            $attendanceRecord->check_in_time = $this->checkInTime;

            $attendanceRecord->check_out_time = $this->checkOutTime;
            $attendanceRecord->check_out_location = $this->checkOutLocation;
            $attendanceRecord->hours_worked = Carbon::parse($this->checkInTime)->diffInHours(Carbon::parse($this->checkOutTime));
            // $this->workingHours;
            $attendanceRecord->date = $this->date;

            $attendanceRecord->note = $this->note;

            $attendanceRecord->check_out_time = $this->checkOutTime;
            $attendanceRecord->check_out_location = $this->checkOutLocation;
            $attendanceRecord->hours_worked = $this->workingHours;

            $attendanceRecord->update();

            $this->reset();
        } else {
            // Handle the case where the record is not found
            session()->flash('error', 'Attendance record not found.');
        }
    }

    public function checkOut($id)
    {
        $attendanceRecord = AttendanceRecords::find($id);

        if ($attendanceRecord) {

            $attendanceRecord->check_out_time = $this->checkOutTime;
            $attendanceRecord->check_out_location = $this->checkOutLocation;
            $attendanceRecord->hours_worked = $this->workingHours;

            $attendanceRecord->update();

            $this->reset();
        } else {
            // Handle the case where the record is not found
            session()->flash('error', 'Attendance record not found.');
        }
    }
}
