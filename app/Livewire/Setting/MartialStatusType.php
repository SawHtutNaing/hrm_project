<?php

namespace App\Livewire\Setting;

use App\Models\MartialStatusType as ModelsMartialStatusType;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class MartialStatusType extends Component
{
    use WithPagination;

    public $confirm_delete = false;

    public $confirm_edit = false;

    public $confirm_add = false;

    public $message = null;

    public $martial_status_type_search;

    public $martial_status_type_name;

    public $martial_status_type_id;

    public $modal_title;

    public $submit_button_text;

    public $cancel_action;

    public $submit_form;

    // Validation
    protected $rules = [
        'martial_status_type_name' => 'required|string|max:255',
    ];

    // Add New
    public function add_new()
    {
        $this->resetValidation();
        $this->reset('martial_status_type_name');
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
        ModelsMartialStatusType::create([
            'name' => $this->martial_status_type_name,
        ]);
        $this->message = 'Created successfully.';
        $this->close_modal();
    }

    // close modal
    public function close_modal()
    {
        $this->resetValidation();
        $this->reset('martial_status_type_name');
        $this->confirm_edit = false;
        $this->confirm_add = false;
    }

    // edit
    public function edit_modal($id)
    {
        $this->resetValidation();
        $this->confirm_add = false;
        $this->confirm_edit = true;
        $this->martial_status_type_id = $id;
        $martial_status_type = ModelsMartialStatusType::findOrFail($id);
        $this->martial_status_type_name = $martial_status_type->name;
    }

    // update
    public function updatePosition()
    {
        $this->validate();
        ModelsMartialStatusType::findOrFail($this->martial_status_type_id)->update([
            'name' => $this->martial_status_type_name,
        ]);
        $this->message = 'Updated successfully.';
        $this->close_modal();
    }

    // delete confirm
    public function delete_confirm($id)
    {
        $this->martial_status_type_id = $id;
        $this->confirm_delete = true;
    }

    // delete
    public function delete($id)
    {
        ModelsMartialStatusType::find($id)->delete();
        $this->confirm_delete = false;
    }

    #[On('render_martial_status_type')]
    public function render_martial_status_type()
    {
        $this->render();
    }

    public function render()
    {
        $this->modal_title = $this->confirm_add ? 'New martial_statusType
' : 'Edit martial_statusType
';
        $this->submit_button_text = $this->confirm_add ? 'Save' : 'Update';
        $this->cancel_action = 'close_modal';
        $this->submit_form = 'submitForm';

        $martial_statusTypeSearch = '%'.$this->martial_status_type_search.'%';
        $martial_statusTypeQuery = ModelsMartialStatusType::query();
        if ($this->martial_status_type_search) {
            $this->resetPage();
            $martial_statusTypeQuery->where('name', 'LIKE', $martial_statusTypeSearch);
            $martial_status_types = $martial_statusTypeQuery->paginate($martial_statusTypeQuery->count() > 10 ? $martial_statusTypeQuery->count() : 10);
        } else {
            $martial_status_types = $martial_statusTypeQuery->paginate(10);
        }

        return view('livewire.martial-status-type', [
            'martial_status_types' => $martial_status_types,
        ]);
    }
}
