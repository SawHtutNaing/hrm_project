<?php

namespace App\Livewire\User;

use App\Livewire\Forms\AttendanceForm;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class CheckIn extends Component
{
    use WithFileUploads;

    public AttendanceForm $attendanceForm;

    public $user;

    public $checkInLocation;

    public $checkInTime;

    public $checkOutTime;

    public $checkOutLocation;

    public $date;

    public $note;

    public $hoursWorked;

    public $geolocation = ['lat' => null, 'lng' => null];

    public $screenshot; // Added screenshot property

    public function mount()
    {
        $this->user = User::find(Auth::id());
    }

    public function render()
    {
        return view('livewire.check-in');
    }

    public function save()
    {
        // dd($this->screenshot);
        if ($this->screenshot) {
            // dd('');
            $screenshotPath = $this->screenshot->store('screenshots', 'public');
            // You can save $screenshotPath to the database if needed
        }

        $this->attendanceForm->user_id = $this->user->id;
        // $this->attendanceForm->checkInTime = Carbon::now()->format('H i');
        $this->attendanceForm->checkInTime = Carbon::now('Europe/London')->format('H:i');

        $this->attendanceForm->date = Carbon::now()->toDateString();

        $this->attendanceForm->save();

        $this->dispatch('checkInSuccess');

        return redirect()->route('attendances');

    }

    public function getLocation()
    {
        $this->dispatchBrowserEvent('get-location');
    }
}
