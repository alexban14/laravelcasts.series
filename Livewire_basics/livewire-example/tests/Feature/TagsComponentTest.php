<?php

namespace Tests\Feature;

use Livewire\Livewire;
use App\Http\Livewire\TagsComponent;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TagsComponentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     *
     */
    public function mainPageContainsTags()
    {
        $this->get('/')
            ->assertSeeLivewire('tags-component');
    }

    /**
     * @test
     *
     */
    public function loadsExistingTags()
    {
        $tagA = Tag::create(['name' => 'one']);
        $tagB = Tag::create(['name' => 'two']);

        Livewire::test(TagsComponent::class)
            ->assertSee('tags', json_encode([
                $tagA->name,
                $tagB->name,
            ]));
    }

    /**
     * @test
     *
     */
    public function addsTags()
    {
        $tagA = Tag::create(['name' => 'one']);
        $tagB = Tag::create(['name' => 'two']);

        Livewire::test(TagsComponent::class)
            ->emit('tagAdded', 'three')
            ->assertEmitted('addedTag', 'three');

        $this->assertDatabaseHas('tags', [
            'name' => 'three',
        ]);
    }


    /**
     * @test
     *
     */
    public function removesTags()
    {
        $tagA = Tag::create(['name' => 'one']);
        $tagB = Tag::create(['name' => 'two']);

        Livewire::test(TagsComponent::class)
            ->emit('tagRemoved', 'two');

        $this->assertDatabaseMissing('tags', [
            'name' => 'two',
        ]);
    }
}
