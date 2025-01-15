<?php

use App\Livewire\Admin\AssignTask;
use App\Livewire\Admin\Attendance;
use App\Livewire\Admin\Employee;
use App\Livewire\Rank;
use App\Livewire\Setting\BloodType;
use App\Livewire\Setting\Department;
use App\Livewire\Setting\DivisionType;
use App\Livewire\Setting\LeaveType;
use App\Livewire\Setting\MartialStatusType;
use App\Livewire\Setting\OverTimeType;
use App\Livewire\Setting\PayScale;
use App\Livewire\Staff;
use App\Livewire\User\CheckIn;
use App\Livewire\User\CheckOut;
use App\Livewire\User\Fine;
use App\Livewire\User\PersonalDetails;
use App\Livewire\User\RequestLeave;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::view('profile', 'profile')

    ->name('profile');

// Route::get('/', Attendance::class)->name('dashboard');

Route::group(['prefix' => 'management'], function () {

    Route::get('/division-types', DivisionType::class)->name('division_types');
    Route::get('/departments', Department::class)->name('departments');
    Route::get('/over_time', OverTimeType::class)->name('over_time');
    Route::get('/leave_types', LeaveType::class)->name('leave_types');
    Route::get('/ranks', action: Rank::class)->name('ranks');
    Route::get('/payscale', PayScale::class)->name('payscale');
    Route::get('/staff', Staff::class)->name('staff');

    // /
    Route::get('/attendance', Attendance::class)->name('attendances');
    Route::get('/request-leave', RequestLeave::class)->name('request_leave');
    Route::get('/assign-task', AssignTask::class)->name('assign_task');
    Route::get('/blood_types', BloodType::class)->name('blood_type');
    Route::get('/martial_status_type', MartialStatusType::class)->name('martial_status_type');

    Route::get('/file/{path}', function ($path) {
        $filePath = Storage::disk('upload')->path($path);
        if (File::exists($filePath)) {
            return response()->file($filePath);
        }
        abort(404, 'File Not Found');
    })->name('file')->where('path', '.*');

    // personal details edit

});

Route::get('/my-info', PersonalDetails::class)->name('my-info');

//

// user management
Route::get('/', Employee::class)->name('employee');

// check in

Route::get('/check-in', CheckIn::class)->name('check-in');
Route::get('/check-out', CheckOut::class)->name('check-out');

Route::group(['prefix' => 'staff'],

    function () {
        Route::get('{staff}/fine', Fine::class)->name('staff.fine');

    }
);
