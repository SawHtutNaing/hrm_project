<?php

namespace App\Livewire\Setting;

use App\Models\Department as ModelDepartment;
use App\Models\DivisionType;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Department extends Component
{
    use WithPagination;

    public $confirm_delete = false;

    public $confirm_edit = false;

    public $confirm_add = false;

    public $message = null;

    public $division_search;

    public $division_name;

    public $nick_name;

    public $division_type_name;

    public $division_id;

    public $modal_title;

    public $submit_button_text;

    public $cancel_action;

    public $submit_form;

    // Validation
    protected $rules = [
        'division_name' => 'required|string|max:255',
        'nick_name' => 'required|string|max:255',
        'division_type_name' => 'required',

    ];

    // Add New
    public function add_new()
    {
        $this->resetValidation();
        $this->reset(['division_name', 'nick_name',
            'division_type_name',
        ]);
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
        ModelDepartment::create([
            'name' => $this->division_name,
            'nick_name' => $this->nick_name,
            'division_type_id' => $this->division_type_name,

        ]);
        $this->message = 'Created successfully.';
        $this->close_modal();
    }

    // close modal
    public function close_modal()
    {
        $this->resetValidation();
        $this->reset(['division_name', 'nick_name', 'division_type_name',
        ]);
        $this->confirm_edit = false;
        $this->confirm_add = false;
    }

    // edit
    public function edit_modal($id)
    {
        $this->resetValidation();
        $this->confirm_add = false;
        $this->confirm_edit = true;
        $this->division_id = $id;
        $division = ModelDepartment::findOrFail($id);
        $this->division_name = $division->name;
        $this->nick_name = $division->nick_name;
        $this->division_type_name = $division->division_type_id;

    }

    // update
    public function updatePosition()
    {
        $this->validate();
        $division = ModelDepartment::findOrFail($this->division_id);
        $division->update([
            'name' => $this->division_name,
            'nick_name' => $this->nick_name,
            'division_type_id' => $this->division_type_name,

        ]);
        $this->message = 'Updated successfully.';
        $this->close_modal();
    }

    // delete confirm
    public function delete_confirm($id)
    {
        $this->division_id = $id;
        $this->confirm_delete = true;
    }

    // delete
    public function delete($id)
    {
        ModelDepartment::find($id)->delete();
        $this->confirm_delete = false;
    }

    #[On('render_division')]
    public function render_division()
    {
        $this->render();
    }

    public function render()
    {
        $division_types = DivisionType::get();

        $this->modal_title = $this->confirm_add ? 'New Division
' : 'Edit Division
';
        $this->submit_button_text = $this->confirm_add ? 'Save' : 'Edit';
        $this->cancel_action = 'close_modal';
        $this->submit_form = 'submitForm';

        $divisionSearch = '%'.$this->division_search.'%';
        $divisionQuery = ModelDepartment::query();
        if ($this->division_search) {
            $this->resetPage();
            $divisionQuery->where(fn ($q) => $q->where('name', 'LIKE', $divisionSearch)->orWhereHas('divisionType', fn ($query) => $query->where('name', 'LIKE', $divisionSearch)));
            $divisions = $divisionQuery->with('divisionType')->paginate($divisionQuery->count() > 10 ? $divisionQuery->count() : 10);
        } else {
            $divisions = $divisionQuery->with('divisionType')->paginate(10);
        }

        return view('livewire.division', [
            'divisions' => $divisions,
            'division_types' => $division_types,

        ]);
    }
}
