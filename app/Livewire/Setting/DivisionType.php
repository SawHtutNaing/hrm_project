<?php

namespace App\Livewire\Setting;

use App\Models\DivisionType as ModelsDivisionType;
use Livewire\Component;
use Livewire\WithPagination;

class DivisionType extends Component
{
    use WithPagination;

    public $confirm_delete = false;

    public $confirm_edit = false;

    public $confirm_add = false;

    public $message = null;

    public $division_type_search;

    public $division_type_name;

    public $division_type_id;

    public $modal_title;

    public $submit_button_text;

    public $cancel_action;

    public $submit_form;

    // Validation
    protected $rules = [
        'division_type_name' => 'required|string|max:255',
    ];

    // Add New
    public function add_new()
    {
        $this->resetValidation();
        $this->reset(['division_type_name']);
        $this->confirm_add = true;
        $this->confirm_edit = false;
    }

    public function submitForm()
    {
        if ($this->confirm_add == true) {
            $this->createDivisionType();
        } else {
            $this->updateDivisionType();
        }
    }

    // create
    public function createDivisionType()
    {
        $this->validate();
        ModelsDivisionType::create([
            'name' => $this->division_type_name,

        ]);
        $this->message = 'Created successfully.';
        $this->close_modal();
    }

    // close modal
    public function close_modal()
    {
        $this->resetValidation();
        $this->reset(['division_type_name']);
        $this->confirm_edit = false;
        $this->confirm_add = false;
    }

    // edit
    public function edit_modal($id)
    {
        $this->resetValidation();
        $this->confirm_add = false;
        $this->confirm_edit = true;
        $this->division_type_id = $id;
        $division_type = ModelsDivisionType::findOrFail($id);
        $this->division_type_name = $division_type->name;

    }

    // update
    public function updateDivisionType()
    {
        $this->validate();
        $division_type = ModelsDivisionType::findOrFail($this->division_type_id);
        $division_type->update([
            'name' => $this->division_type_name,

        ]);
        $this->message = 'Updated successfully.';
        $this->close_modal();
    }

    // delete confirm
    public function delete_confirm($id)
    {
        $this->division_type_id = $id;
        $this->confirm_delete = true;
    }

    // delete
    public function delete($id)
    {
        ModelsDivisionType::find($id)->delete();
        $this->confirm_delete = false;
    }

    public function render()
    {

        $this->modal_title = $this->confirm_add ? 'New division Type' : 'Edit division Type';
        $this->submit_button_text = 'Save';
        $this->cancel_action = 'close_modal';
        $this->submit_form = 'submitForm';
        $divisionTypeSearch = '%'.$this->division_type_search.'%';
        $division_types = ModelsDivisionType::query()->
        when($this->division_type_search, function ($query) use ($divisionTypeSearch) {
            $query->where('name', 'LIKE', $divisionTypeSearch);
        })
            ->paginate(10);

        return view('livewire.division-type', [
            'division_types' => $division_types,
        ]);
    }
}
