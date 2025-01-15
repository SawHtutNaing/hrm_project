<?php

namespace App\Livewire\Setting;

use App\Models\LeaveType as ModelsLeaveType;
use Livewire\Component;
use Livewire\WithPagination;

class LeaveType extends Component
{
    use WithPagination;

    public $confirm_delete = false;

    public $confirm_edit = false;

    public $confirm_add = false;

    public $message = null;

    public $leave_type_search;

    public $leave_type_name;

    public $deduction_amount;

    public $leave_type_id;

    public $modal_title;

    public $submit_button_text;

    public $cancel_action;

    public $submit_form;

    // Validation
    protected $rules = [
        'leave_type_name' => 'required|string|max:255',
        'deduction_amount' => 'required',
    ];

    // Add New
    public function add_new()
    {
        $this->resetValidation();
        $this->reset(['leave_type_name', 'deduction_amount']);
        $this->confirm_add = true;
        $this->confirm_edit = false;
    }

    public function submitForm()
    {
        if ($this->confirm_add == true) {
            $this->createLeaveType();
        } else {
            $this->updateLeaveType();
        }
    }

    // create
    public function createLeaveType()
    {
        $this->validate();
        ModelsLeaveType::create([
            'name' => $this->leave_type_name,

            'deduction_amount' => $this->deduction_amount,
        ]);
        $this->message = 'Created successfully.';
        $this->close_modal();
    }

    // close modal
    public function close_modal()
    {
        $this->resetValidation();
        $this->reset(['leave_type_name', 'deduction_amount']);
        $this->confirm_edit = false;
        $this->confirm_add = false;
    }

    // edit
    public function edit_modal($id)
    {
        $this->resetValidation();
        $this->confirm_add = false;
        $this->confirm_edit = true;
        $this->leave_type_id = $id;
        $leave_type = ModelsLeaveType::findOrFail($id);
        $this->leave_type_name = $leave_type->name;
        $this->deduction_amount = $leave_type->deduction_amount;

    }

    // update
    public function updateLeaveType()
    {
        $this->validate();
        $leave_type = ModelsLeaveType::findOrFail($this->leave_type_id);
        $leave_type->update([
            'name' => $this->leave_type_name,

            'deduction_amount' => $this->deduction_amount,
        ]);
        $this->message = 'Updated successfully.';
        $this->close_modal();
    }

    // delete confirm
    public function delete_confirm($id)
    {
        $this->leave_type_id = $id;
        $this->confirm_delete = true;
    }

    // delete
    public function delete($id)
    {
        ModelsLeaveType::find($id)->delete();
        $this->confirm_delete = false;
    }

    public function render()
    {

        $this->modal_title = $this->confirm_add ? 'New Leave Type' : 'Edit Leave Type';
        $this->submit_button_text = 'Save';
        $this->cancel_action = 'close_modal';
        $this->submit_form = 'submitForm';
        $LeaveTypeSearch = '%'.$this->leave_type_search.'%';
        $leave_types = ModelsLeaveType::query()->
        when($this->leave_type_search, function ($query) use ($LeaveTypeSearch) {
            $query->where('name', 'LIKE', $LeaveTypeSearch);
        })
            ->paginate(10);

        return view('livewire.leave-type', [
            'leave_types' => $leave_types,
        ]);
    }
}
