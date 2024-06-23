<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class ShowUsers extends Component
{
    public Collection $users;

    public function mount(): void
    {
        $this->users = User::all();
    }

    public function render()
    {
        return view('livewire.show-users');
    }
}
