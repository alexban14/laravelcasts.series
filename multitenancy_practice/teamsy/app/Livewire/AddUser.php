<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class AddUser extends Component
{
    use WithFileUploads;

    public $name = "Kevin McKee";
    public $email = "kevin@lc.com";
    public $department = 'information_technology';
    public $title = "Instructor";
    public $photo;
    public $status = 1;
    public $role = 'admin';

    public function save()
    {
    }

    public function submit()
    {
        $this->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'department' => 'required|string',
            'title' => 'required|string',
            'status' => 'required|boolean',
            'role' => 'required|string',
        ]);

        $filename = $this->savePhotoS3Pub();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'department' => $this->department,
            'title' => $this->title,
            'status' => $this->status,
            'role' => $this->role,
            'photo' => $filename,
            'password' => bcrypt($this->name . $this->email),
        ]);

        session()->flash('success', 'New member in your team');
    }

    public function render()
    {
        return view('livewire.add-user');
    }

    private function savePhotoS3Pub(): string
    {
        $this->validate([
            'photo' => 'image', // 1MB Max
        ]);

        $path = '';

        try {
            $path = $this->photo->store('photos', 's3-public');
            Log::info($path);
        } catch (\Exception $e) {
            Log::info('Failed to upload to S3:' . $e->getMessage());
        }

        return $path;
    }
}
