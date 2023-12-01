<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use App\Models\Post;
use Livewire\Component;

class CommentsSection extends Component
{
    public $post;
    public $comment;
    public $successMessage;

    public array $rules = [
        'comment' => 'required|min:4'
    ];

    public function mount(Post $post)
    {
        $this->post = $post;
    }

    public function postComment()
    {
        $this->validate();

        Comment::create([
            'post_id' => $this->post->id,
            'username' => 'Guest',
            'content' => $this->comment,
        ]);

        $this->post = Post::find($this->post->id);

        $this->successMessage = 'Comment was posted';
    }

    public function render()
    {
        return view('livewire.comments-section');
    }
}
