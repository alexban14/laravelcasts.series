<?php

namespace App\Livewire;

use App\Models\Department;
use Livewire\Component;

class DepartmentForm extends Component
{
    public string $name = 'Accounting';
    public bool $success = false;
    public function mount($departmentId = null): void
    {
        if ($departmentId) {
            $this->name = Department::findOrFail($departmentId)->name;
        }
    }
    public function submit(): void
    {
        Department::create([
            'name' => $this->name,
        ]);

        $this->success = true;
    }
    public function render()
    {
        return view('livewire.department-form');
    }
}
