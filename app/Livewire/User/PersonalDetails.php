<?php

namespace App\Livewire\User;

use App\Models\BloodType;
use App\Models\Department;
use App\Models\Division;
use App\Models\EmployeeRole;
use App\Models\MartialStatusType;
use App\Models\Payscale;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class PersonalDetails extends Component
{
    use WithFileUploads;

    public $employeeRoles;

    public $payscales;

    public $bloodtypes;

    public $overtimeTypes;

    public $departments;

    public $martialStatusTypes;

    public $staff_type_id;

    public $status_id;

    public $country_id;

    public $personal_details;

    public $gender_id;

    public $role_id;

    use WithPagination;

    public $isEdit = false;

    public $modalVisible = false;

    public $staffId;

    public $staff_photo;

    public $staff_no;

    public $name;

    public $nick_name;

    public $other_name;

    public $dob;

    public $attendid;

    public $company_staff_number;

    public $height_feet;

    public $height_inch;

    public $hair_color;

    public $eye_color;

    public $skin_color;

    public $weight;

    public $blood_type_id;

    public $martial_status_type_id;

    public $nrc_code;

    public $nrc_front;

    public $nrc_back;

    public $phone;

    public $email;

    public $division_id;

    public $rank_id;

    public $address;

    public $staff;

    public $employee;

    protected $rules = [
        'staff_photo' => 'nullable|string', // Staff photo is optional
        'name' => 'required|string|max:255', // Name is required
        'staff_type_id' => 'nullable|string|max:255', // Optional, matching the table schema
        'status_id' => 'nullable|string|max:255', // Optional, matching the table schema
        'country_id' => 'nullable|string|max:255', // Optional, matching the table schema
        'personal_details' => 'required|array', // JSON field, required and should be an array
        'gender_id' => 'required|string|max:255', // Gender ID is required
        'role_id' => 'required|exists:roles,id', // Role ID is required and must exist in roles table
        'division_id' => 'required|exists:divisions,id', // Division ID is required and must exist in divisions table
        'nrc_code' => 'nullable|string|max:255', // Optional
        'nrc_front' => 'nullable|string|max:255', // Optional
        'nrc_back' => 'nullable|string|max:255', // Optional
        'phone' => 'nullable|string|max:255', // Optional
        'email' => 'nullable|email|max:255', // Optional, must be a valid email format
    ];

    public function mount($id = null)
    {
        $this->resetFields();
        $this->employeeRoles = EmployeeRole::all();

        $this->payscales = Payscale::all();
        $this->bloodtypes = BloodType::all();
        $this->departments = Department::all();
        $this->martialStatusTypes = MartialStatusType::all();
        $this->staff = User::find($id);

    }

    public function create()
    {
        $this->resetFields();
        $this->isEdit = false;
        $this->modalVisible = true;
    }

    public function save()
    {
        $this->validate();

        // Handle staff photo upload
        if ($this->staff_photo && ! is_string($this->staff_photo)) {
            $uploadedStaffPhoto = $this->staff_photo->store('staffs', 'upload');
            if ($this->staff && $this->staff->staff_photo) {
                Storage::disk('upload')->delete($this->staff->staff_photo);
            }
            $this->staff_photo = $uploadedStaffPhoto;
        } elseif ($this->staff) {
            $this->staff_photo = $this->staff->staff_photo;
        }

        // Prepare data for saving
        $data = [
            'staff_photo' => $this->staff_photo,
            'name' => $this->name,
            'staff_type_id' => $this->staff_type_id,
            'status_id' => $this->status_id,
            'country_id' => $this->country_id,
            'personal_details' => json_encode($this->personal_details),
            'gender_id' => $this->gender_id,
            'role_id' => $this->role_id,
            'division_id' => $this->division_id,
            'nrc_code' => $this->nrc_code,
            'nrc_front' => $this->nrc_front,
            'nrc_back' => $this->nrc_back,
            'phone' => $this->phone,
            'email' => $this->email,
        ];

        // Create or update operation
        if ($this->isEdit) {
            User::findOrFail($this->staff->id)->update($data);
        } else {
            User::create($data);
        }

        // Reset and close modal
        $this->modalVisible = false;
        $this->resetFields();
    }

    public function edit($id)
    {
        $this->staff = User::findOrFail($id);

        $this->staff_photo = $this->staff->staff_photo;
        $this->name = $this->staff->name;
        $this->staff_type_id = $this->staff->staff_type_id;
        $this->status_id = $this->staff->status_id;
        $this->country_id = $this->staff->country_id;
        $this->personal_details = json_decode($this->staff->personal_details, true);
        $this->gender_id = $this->staff->gender_id;
        $this->role_id = $this->staff->role_id;
        $this->division_id = $this->staff->division_id;
        $this->nrc_code = $this->staff->nrc_code;
        $this->nrc_front = $this->staff->nrc_front;
        $this->nrc_back = $this->staff->nrc_back;
        $this->phone = $this->staff->phone;
        $this->email = $this->staff->email;

        $this->isEdit = true;
        $this->modalVisible = true;
    }

    public function delete($id)
    {
        $staff = User::findOrFail($id);

        // Delete associated files
        if ($staff->staff_photo) {
            Storage::disk('upload')->delete($staff->staff_photo);
        }
        if ($staff->nrc_front) {
            Storage::disk('upload')->delete($staff->nrc_front);
        }
        if ($staff->nrc_back) {
            Storage::disk('upload')->delete($staff->nrc_back);
        }

        $staff->delete();
    }

    private function resetFields()
    {
        $this->reset([
            'staff_photo', 'name', 'staff_type_id', 'status_id', 'country_id',
            'personal_details', 'gender_id', 'role_id', 'division_id', 'nrc_code',
            'nrc_front', 'nrc_back', 'phone', 'email',
        ]);
    }

    public function render()
    {

        return view('livewire.personal-details');
    }
}
