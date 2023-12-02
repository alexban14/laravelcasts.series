<?php

namespace Tests\Feature;

use App\Http\Livewire\PostEdit;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class PostEditTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     *
     */
    public function postEditPageContainsLivewire()
    {
        $post = Post::create([
            'title' => 'Title Here',
            'content' => 'Content here'
        ]);

        $this->get(route('post.edit', $post))
            ->assertSeeLivewire('post-edit');
    }

    /**
     * @test
     *
     */
    public function  postEditFormWorks()
    {
        $post = Post::create([
            'title' => 'Title Here',
            'content' => 'Content here'
        ]);

        Livewire::test(PostEdit::class, ['post' => $post])
            ->set('title', 'new title')
            ->set('content', 'new content')
            ->call('submitForm')
            ->assertSee('Post was updated successfully');

        // making sure the post was updated in the db
        $post->refresh();

        $this->assertEquals('new title', $post->title);
        $this->assertEquals('new content', $post->content);
    }

    /**
     * @test
     *
     */
    public function  postEditFormUploadsImages()
    {
        $post = Post::create([
            'title' => 'Title Here',
            'content' => 'Content here'
        ]);

        Storage::fake('public');

        $file = UploadedFile::fake()->create('photo.jpg', 1200, 'image');

        Livewire::test(PostEdit::class, ['post' => $post])
            ->set('title', 'new title')
            ->set('content', 'new content')
            ->set('photo', $file)
            ->call('submitForm')
            ->assertSee('Post was updated successfully!');

        $post->refresh();

        $this->assertNotNull($post->photo);
        Storage::disk('public')->assertExists($post->photo);
    }

    /**
     * @test
     *
     */
    public function  postEditFormUploadsFile()
    {
        $post = Post::create([
            'title' => 'Title Here',
            'content' => 'Content here'
        ]);

        Storage::fake('public');

        $file = UploadedFile::fake()->create('document.pdf', 200);

        Livewire::test(PostEdit::class, ['post' => $post])
            ->set('title', 'new title')
            ->set('content', 'new content')
            ->set('photo', $file)
            ->call('submitForm')
            ->assertSee('The photo must be an image')
            ->assertHasErrors(['photo' => 'image']);

        $post->refresh();

        $this->assertNull($post->photo);
        Storage::disk('public')->assertMissing($post->photo);
    }
}
