<?php

namespace App\Livewire;

use App\Models\EmployeeRole;
use App\Models\Payscale;
use Livewire\Component;
use Livewire\WithPagination;

class Rank extends Component
{
    use WithPagination;

    public $confirm_delete = false;

    public $confirm_edit = false;

    public $confirm_add = false;

    public $message = null;

    public $rank_search;

    public $name;

    public $sort_no;

    public $rank_id;

    public $payscale_id;

    public $modal_title;

    public $submit_button_text;

    public $cancel_action;

    public $submit_form;

    // Validation
    protected $rules = [
        'name' => 'required|string|max:255',
        'sort_no' => 'required',

    ];

    // Add New
    public function add_new()
    {
        $this->resetValidation();
        $this->reset(['name', 'sort_no', 'payscale_id']);
        $this->confirm_add = true;
        $this->confirm_edit = false;
    }

    public function submitForm()
    {
        if ($this->confirm_add == true) {
            $this->createRank();
        } else {
            $this->updateRank();
        }
    }

    // create
    public function createRank()
    {
        $this->validate();
        EmployeeRole::create([
            'name' => $this->name,
            'sort_no' => $this->sort_no,
            'payscale_id' => $this->payscale_id,

        ]);
        $this->message = 'Created successfully.';
        $this->close_modal();
    }

    // close modal
    public function close_modal()
    {
        $this->resetValidation();
        $this->reset(['name', 'sort_no', 'payscale_id']);
        $this->confirm_edit = false;
        $this->confirm_add = false;
    }

    // edit
    public function edit_modal($id)
    {
        $this->resetValidation();
        $this->confirm_add = false;
        $this->confirm_edit = true;
        $this->rank_id = $id;

        $rank = EmployeeRole::findOrFail($id);
        $this->name = $rank->name;
        $this->sort_no = $rank->sort_no;
        $this->payscale_id = $rank->payscale_id;

    }

    // update
    public function updateRank()
    {
        $this->validate();
        $rank = EmployeeRole::findOrFail($this->rank_id);
        $rank->update([

            'name' => $this->name,
            'sort_no' => $this->sort_no,
            'payscale_id' => $this->payscale_id,

        ]);
        $this->message = 'Updated successfully.';
        $this->close_modal();
    }

    // delete confirm
    public function delete_confirm($id)
    {
        $this->rank_id = $id;
        $this->confirm_delete = true;
    }

    // delete
    public function delete($id)
    {
        EmployeeRole::find($id)->delete();
        $this->confirm_delete = false;
    }

    public function render()
    {

        $this->modal_title = $this->confirm_add ? 'New Rank' : 'Edit Rank';
        $this->submit_button_text = 'Save';
        $this->cancel_action = 'close_modal';
        $this->submit_form = 'submitForm';
        $rankNameSearch = '%'.$this->rank_search.'%';
        $ranks = EmployeeRole::query()->
        when($this->rank_search, function ($query) use ($rankNameSearch) {
            $query->where('name', 'LIKE', $rankNameSearch);
        })
            ->paginate(10);

        $payscales = Payscale::all();

        return view('livewire.rank', [
            'ranks' => $ranks,
            'payscales' => $payscales,
        ]);
    }
}
