<?php

namespace App\Livewire\Setting;

use App\Models\Payscale as ModelsPayscale;
use Livewire\Component;
use Livewire\WithPagination;

class PayScale extends Component
{
    use WithPagination;

    public $confirm_delete = false;

    public $confirm_edit = false;

    public $confirm_add = false;

    public $message = null;

    public $payscale_search;

    public $name;

    public $min_salary;

    public $modal_title;

    public $submit_button_text;

    public $cancel_action;

    public $submit_form;

    public $payscale_id;

    // Validation
    protected $rules = [
        'name' => 'required|string|max:255',
        'min_salary' => 'string',

    ];

    // Add New
    public function add_new()
    {
        $this->resetValidation();
        $this->reset(['name', 'min_salary']);
        $this->confirm_add = true;
        $this->confirm_edit = false;
    }

    public function submitForm()
    {
        if ($this->confirm_add == true) {
            $this->createPayscale();
        } else {
            $this->updatePayscale();
        }
    }

    // create
    public function createPayscale()
    {
        $this->validate();
        ModelsPayscale::create([
            'name' => $this->name,

            'min_salary' => $this->min_salary,

        ]);
        $this->message = 'Created successfully.';
        $this->close_modal();
    }

    // close modal
    public function close_modal()
    {
        $this->resetValidation();
        $this->reset(['name', 'min_salary']);
        $this->confirm_edit = false;
        $this->confirm_add = false;
    }

    // edit
    public function edit_modal($id)
    {
        $this->resetValidation();
        $this->confirm_add = false;
        $this->confirm_edit = true;
        $this->payscale_id = $id;

        $payscale = ModelsPayscale::findOrFail($id);
        $this->name = $payscale->name;

        $this->min_salary = $payscale->min_salary;

    }

    // update
    public function updatePayscale()
    {
        $this->validate();
        $payscale = ModelsPayscale::findOrFail($this->payscale_id);

        $payscale->update([
            'name' => $this->name,

            'min_salary' => $this->min_salary,

        ]);
        $this->message = 'Updated successfully.';
        $this->close_modal();
    }

    // delete confirm
    public function delete_confirm($id)
    {
        $this->payscale_id = $id;
        $this->confirm_delete = true;
    }

    // delete
    public function delete($id)
    {
        ModelsPayscale::find($id)->delete();
        $this->confirm_delete = false;

    }

    public function render()
    {

        $this->modal_title = $this->confirm_add ? 'New payscale' : 'Edit payscale';
        $this->submit_button_text = 'Save';
        $this->cancel_action = 'close_modal';
        $this->submit_form = 'submitForm';
        $payscaleNameSearch = '%'.$this->payscale_search.'%';
        $payscales = ModelsPayscale::query()->
        when($this->payscale_search, function ($query) {})
            ->paginate(10);

        return view('livewire.pay-scale', [
            'payscales' => $payscales,

        ]);
    }
}
