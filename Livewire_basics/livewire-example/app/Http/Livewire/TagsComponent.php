<?php

namespace App\Http\Livewire;

use App\Models\Tag;
use Livewire\Component;

class TagsComponent extends Component
{
    public $tags;

    protected $listeners = [
        'tagAdded' => 'addTag',
        'tagRemoved' => 'removeTag'
    ];

    public function mount()
    {
        $this->tags = json_encode(Tag::pluck('name'));
    }

    public function addTag($tag)
    {
        Tag::create(['name' => $tag]);
        $this->emit('addedTag', $tag);
    }

    public function removeTag($tag)
    {
        Tag::where('name', $tag)->first()->delete();
    }

    public function render()
    {
        return view('livewire.tags-component');
    }
}
