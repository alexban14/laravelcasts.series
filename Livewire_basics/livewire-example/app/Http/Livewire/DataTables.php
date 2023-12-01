<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\WithPagination;
use Livewire\Component;

class DataTables extends Component
{
    use WithPagination;

    public $active = true;
    public $search;
    public $sortField;
    public $sortAsc = true;

    // manipulating, updating the browser's query string
    protected $queryString = ['search', 'active', 'sortAsc', 'sortField'];

    public function sortBy($field)
    {
        if ($this->sortField == $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }
    // resetting pagination after filtering data
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function render()
    {
        $users = User::where(function ($query) {
            $query->where('name' ,'like', '%' . $this->search . '%')
                ->orWhere('email' ,'like', '%' . $this->search . '%');
        })->where('active', $this->active)
        ->when($this->sortField, function ($query) {
            $query->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
        })->paginate(10);

        return view('livewire.data-tables',[
            'users' => $users,
        ]);
    }
//    public function paginationView()
//    {
//        return 'livewire.custom-pagination-links-view';
//    }
}
