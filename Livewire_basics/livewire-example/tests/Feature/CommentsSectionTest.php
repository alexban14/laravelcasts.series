<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CommentsSectionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     *
     */
    public function mainPageContainsPosts()
    {
        $post = Post::create([
            'title' => 'Title Here',
            'content' => 'Content here'
        ]);

        $this->get('/')
            ->assertSee($post->title);
    }

    /**
     * @test
     *
     */
    public function postPageContainsCommentsComponent()
    {
        $post = Post::create([
            'title' => 'Title Here',
            'content' => 'Content here'
        ]);

        $this->get(route('post.show', $post))
            ->assertSeeLivewire('comments-section');
    }

    /**
     * @test
     *
     */
    public function validCommentCanBePosted()
    {
        $post = Post::create([
            'title' => 'Title Here',
            'content' => 'Content here'
        ]);

        Livewire::test(CommentsSectionTest::class)
            ->set('post', $post)
            ->set('comment', 'this is my comment')
            ->call('postComment')
            ->assertSee('Comment was posted')
            ->assertSee('This is my comment');
    }


    /**
     * @test
     *
     */
    public function commentIsRequired()
    {
        $post = Post::create([
            'title' => 'Title Here',
            'content' => 'Content here'
        ]);

        Livewire::test(CommentsSectionTest::class)
            ->set('post', $post)
            ->call('postComment')
            ->assertHasErrors(['comment' => 'required'])
            ->assertSee('The comment field is required');
    }

    /**
     * @test
     *
     */
    public function commentMin4Chars()
    {
        $post = Post::create([
            'title' => 'Title Here',
            'content' => 'Content here'
        ]);

        Livewire::test(CommentsSectionTest::class)
            ->set('post', $post)
            ->set('comment', 'com')
            ->call('postComment')
            ->assertHasErrors(['comment' => 'min'])
            ->assertSee('The comment must be at least 4 characters');
    }
}
