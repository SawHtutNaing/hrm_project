<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // /home/sawhtut/Desktop/hrmproject/////attendance/checkIn.blade.php
        // View::addNamespace('fieldservice', base_path('Modules/FieldService/Resources/views'));

        //        return view('fieldservice::attendance.index',compact('campaigns'));
        Gate::define('check_in', function (User $user) {

            return ! $user->checkIn()->exists() && $user->employee_role_id == 2;
        });
        Gate::define('check_out', function (User $user) {

            return $user->checkIn()->exists() && $user->employee_role_id == 2;
        });

        Gate::define('view_setting', function (User $user) {
            return $user->employee_role_id == 1;
        });
        Gate::define('att_management', function (User $user) {
            return $user->employee_role_id == 1;
        });

        Gate::define('hr_att', function (User $user) {
            return $user->employee_role_id == 1;
        });

    }
}
