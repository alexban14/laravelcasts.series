<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class AddUser extends Component
{
    use WithFileUploads;

    public string $name = "Kevin McKee";
    public string $email = "kevin@lc.com";
    public string $department = 'information_technology';
    public string $title = "Instructor";
    public $photo;
    public int $status = 1;
    public string $role = 'admin';
    public $application;

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
            'photo' => 'image', // 1MB Max
            'application' => 'file|mimes:pdf',
        ]);

        $filename = $this->savePhotoS3Pub();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'department' => $this->department,
            'title' => $this->title,
            'status' => $this->status,
            'role' => $this->role,
            'photo' => $filename,
            'password' => bcrypt($this->name . $this->email),
        ]);

        $filename = pathinfo($this->application->getClientOriginalName(), PATHINFO_FILENAME)
            . '_' . now()->timestamp . '.' . $this->application->getClientOriginalExtension();

        $this->application->storeAs('/documents/' . $user->id . '/', $filename, 's3');

        $user->documents()->create([
            'type' => 'application',
            'filename' => $filename,
            'extension' => $this->application->getClientOriginalExtension(),
            'size' => $this->application->getSize(),
        ]);

        session()->flash('success', 'New member in your team');
    }

    public function render()
    {
        return view('livewire.add-user');
    }

    private function savePhotoS3Pub(): string
    {
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
