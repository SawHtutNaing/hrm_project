<?php

namespace App\Livewire\Setting;

use App\Models\BloodType as ModelsBloodType;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class BloodType extends Component
{
    use WithPagination;

    public $confirm_delete = false;

    public $confirm_edit = false;

    public $confirm_add = false;

    public $message = null;

    public $blood_type_search;

    public $blood_type_name;

    public $blood_type_id;

    public $modal_title;

    public $submit_button_text;

    public $cancel_action;

    public $submit_form;

    // Validation
    protected $rules = [
        'blood_type_name' => 'required|string|max:255',
    ];

    // Add New
    public function add_new()
    {
        $this->resetValidation();
        $this->reset('blood_type_name');
        $this->confirm_add = true;
        $this->confirm_edit = false;
    }

    public function submitForm()
    {
        if ($this->confirm_add == true) {
            $this->createPosition();
        } else {
            $this->updatePosition();
        }
    }

    // create
    public function createPosition()
    {
        $this->validate();
        ModelsBloodType::create([
            'name' => $this->blood_type_name,
        ]);
        $this->message = 'Created successfully.';
        $this->close_modal();
    }

    // close modal
    public function close_modal()
    {
        $this->resetValidation();
        $this->reset('blood_type_name');
        $this->confirm_edit = false;
        $this->confirm_add = false;
    }

    // edit
    public function edit_modal($id)
    {
        $this->resetValidation();
        $this->confirm_add = false;
        $this->confirm_edit = true;
        $this->blood_type_id = $id;
        $blood_type = ModelsBloodType::findOrFail($id);
        $this->blood_type_name = $blood_type->name;
    }

    // update
    public function updatePosition()
    {
        $this->validate();
        ModelsBloodType::findOrFail($this->blood_type_id)->update([
            'name' => $this->blood_type_name,
        ]);
        $this->message = 'Updated successfully.';
        $this->close_modal();
    }

    // delete confirm
    public function delete_confirm($id)
    {
        $this->blood_type_id = $id;
        $this->confirm_delete = true;
    }

    // delete
    public function delete($id)
    {
        ModelsBloodType::find($id)->delete();
        $this->confirm_delete = false;
    }

    #[On('render_blood_type')]
    public function render_blood_type()
    {
        $this->render();
    }

    public function render()
    {
        $this->modal_title = $this->confirm_add ? 'New BloodType
' : 'Edit BloodType
';
        $this->submit_button_text = $this->confirm_add ? 'Save' : 'Update';
        $this->cancel_action = 'close_modal';
        $this->submit_form = 'submitForm';

        $bloodTypeSearch = '%'.$this->blood_type_search.'%';
        $bloodTypeQuery = ModelsBloodType::query();
        if ($this->blood_type_search) {
            $this->resetPage();
            $bloodTypeQuery->where('name', 'LIKE', $bloodTypeSearch);
            $blood_types = $bloodTypeQuery->paginate($bloodTypeQuery->count() > 10 ? $bloodTypeQuery->count() : 10);
        } else {
            $blood_types = $bloodTypeQuery->paginate(10);
        }

        return view('livewire.blood-type', [
            'blood_types' => $blood_types,
        ]);
    }
}
