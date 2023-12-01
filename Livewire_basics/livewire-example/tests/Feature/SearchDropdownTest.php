<?php

namespace Tests\Feature;

use App\Http\Livewire\SearchDropdown;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class SearchDropdownTest extends TestCase
{
    /**
     * @test
     */
    public function searchDropdownSearchesCorrectly(): void
    {
        Livewire::test(SearchDropdown::class)
            ->assertDontSee('John Lennon')
            ->set('search', 'Imagine')
            ->assertSee('John Lennon');
    }

    /**
     * @test
     */
    public function searchDropdownSearchesShowNonExisting(): void
    {
        Livewire::test(SearchDropdown::class)
            ->set('search', 'foeinboen')
            ->assertSee('No results found');
    }
}
