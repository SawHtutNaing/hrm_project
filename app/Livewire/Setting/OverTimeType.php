<?php

namespace App\Livewire\Setting;

use App\Models\OverTimeType as ModelsOverTimeType;
use Livewire\Component;
use Livewire\WithPagination;

class OverTimeType extends Component
{
    use WithPagination;

    public $confirm_delete = false;

    public $confirm_edit = false;

    public $confirm_add = false;

    public $message = null;

    public $over_time_type_search;

    public $over_time_type_name;

    public $over_time_type_id;

    public $modal_title;

    public $submit_button_text;

    public $cancel_action;

    public $submit_form;

    // Validation
    protected $rules = [
        'over_time_type_name' => 'required|string|max:255',
    ];

    // Add New
    public function add_new()
    {
        $this->resetValidation();
        $this->reset(['over_time_type_name']);
        $this->confirm_add = true;
        $this->confirm_edit = false;
    }

    public function submitForm()
    {
        if ($this->confirm_add == true) {
            $this->createover_timeType();
        } else {
            $this->updateover_timeType();
        }
    }

    // create
    public function createover_timeType()
    {
        $this->validate();
        ModelsOverTimeType::create([
            'name' => $this->over_time_type_name,
        ]);
        $this->message = 'Created successfully.';
        $this->close_modal();
    }

    // close modal
    public function close_modal()
    {
        $this->resetValidation();
        $this->reset(['over_time_type_name']);
        $this->confirm_edit = false;
        $this->confirm_add = false;
    }

    // edit
    public function edit_modal($id)
    {
        $this->resetValidation();
        $this->confirm_add = false;
        $this->confirm_edit = true;
        $this->over_time_type_id = $id;
        $this->over_time_type_name = ModelsOverTimeType::find($this->over_time_type_id)->name;

    }

    // update
    public function updateover_timeType()
    {
        $this->validate();
        $over_time_type = ModelsOverTimeType::findOrFail($this->over_time_type_id);
        $over_time_type->update([
            'name' => $this->over_time_type_name,

        ]);
        $this->message = 'Updated successfully.';
        $this->close_modal();
    }

    // delete confirm
    public function delete_confirm($id)
    {
        $this->over_time_type_id = $id;
        $this->confirm_delete = true;
    }

    // delete
    public function delete($id)
    {
        ModelsOverTimeType::find($id)->delete();
        $this->confirm_delete = false;
    }

    public function render()
    {

        $this->modal_title = $this->confirm_add ? 'New over_time Type' : 'Edit over_time Type';
        $this->submit_button_text = 'Save';
        $this->cancel_action = 'close_modal';
        $this->submit_form = 'submitForm';
        $over_timeTypeSearch = '%'.$this->over_time_type_search.'%';
        $over_time_types = ModelsOverTimeType::query()->
        when($this->over_time_type_search, function ($query) use ($over_timeTypeSearch) {
            $query->where('name', 'LIKE', $over_timeTypeSearch);
        })
            ->paginate(10);

        return view('livewire.over-time-type',
            ['over_time_types' => $over_time_types]
        );

    }
}
