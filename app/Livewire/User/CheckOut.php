<?php

namespace App\Livewire\User;

use App\Livewire\Forms\AttendanceForm;
use App\Models\AttendanceRecords;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CheckOut extends Component
{
    public AttendanceForm $attendanceForm;

    public $user;

    public $checkInLocation;

    public $checkInTime;

    public $checkOutTime;

    public $checkOutLocation;

    public $date;

    public $note;

    public $hoursWorked;

    public $checkInData;

    public $geolocation = ['lat' => null, 'lng' => null];

    public function mount()
    {
        $this->user = User::find(Auth::id());
        $this->checkInData = AttendanceRecords::where('user_id', $this->user->id)->where('date', Carbon::now()->toDateString())->first();

    }

    public function update()
    {

        $this->attendanceForm->checkOutTime = Carbon::now('Europe/London')->format('H:i');

        $checkInTime = Carbon::parse($this->checkInData->check_in_time);
        $checkOutTime = Carbon::parse($this->attendanceForm->checkOutTime);
        $this->attendanceForm->workingHours = $checkInTime->diffInHours($checkOutTime);

        $this->attendanceForm->checkOut($this->checkInData->id);

        $this->dispatch('checkOutSuccess');

    }

    public function getLocation()
    {
        $this->dispatchBrowserEvent('get-location');
    }

    public function render()
    {
        return view('livewire.check-out');
    }
}
