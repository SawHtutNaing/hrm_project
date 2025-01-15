<?php

namespace App\Livewire\Admin;

use App\Models\Department;
use App\Models\EmployeeRole;
use Livewire\Component;

class Employee extends Component
{
    public $name;

    public $email;

    public $department_id;

    public $employee_role_id;

    public $nrc_code;

    public $password;

    public $departments;

    public $employeeRoles;

    public function mount()
    {
        $this->departments = Department::all();
        $this->employeeRoles = EmployeeRole::all();
    }

    public function render()
    {
        return view('livewire.employee');
    }

    public function save()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'department_id' => 'required',
            'employee_role_id' => 'required',
            'nrc_code' => 'required',
        ]);

        $employee = new \App\Models\User;
        $employee->name = $this->name;
        $employee->email = $this->email;
        $employee->department_id = $this->department_id;
        $employee->employee_role_id = $this->employee_role_id;
        $employee->nrc_code = $this->nrc_code;
        $employee->password = bcrypt($this->password);

        $employee->save();

        $this->reset();
    }
}
