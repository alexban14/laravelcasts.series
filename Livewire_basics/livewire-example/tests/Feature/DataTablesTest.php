<?php

namespace Tests\Feature;

use App\Http\Livewire\DataTables;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class DataTablesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     *
     */
    public function mainPageContainsDataTables()
    {
        $this->get('/')
            ->assertSeeLivewire('data-tables');
    }

    /**
     * @test
     */
    public function dataTablesActiveCheckbox()
    {
        $userA = User::create([
            'name' => 'User',
            'email' => 'user@user.com',
            'password' => bcrypt('password'),
            'active' => true,
        ]);

        $userB = User::create([
            'name' => 'Another',
            'email' => 'another@another.com',
            'password' => bcrypt('password'),
            'active' => false,
        ]);

        Livewire::test(DataTables::class)
            ->assertSee($userA->name)
            ->assertDontSee($userB->name)
            ->set('active', false)
            ->assertSee($userB->name)
            ->assertDontSee($userA->name);
    }

    /**
     * @test
     */
    public function dataTablesSearchesName()
    {
        $userA = User::create([
            'name' => 'User',
            'email' => 'user@user.com',
            'password' => bcrypt('password'),
            'active' => true,
        ]);

        $userB = User::create([
            'name' => 'Another',
            'email' => 'another@another.com',
            'password' => bcrypt('password'),
            'active' => true,
        ]);

        Livewire::test(DataTables::class)
            ->set('search', 'user')
            ->assertSee($userA->name)
            ->assertDontSee($userB->name);
    }

    /**
     * @test
     */
    public function dataTablesSearchesEmail()
    {
        $userA = User::create([
            'name' => 'User',
            'email' => 'user@user.com',
            'password' => bcrypt('password'),
            'active' => true,
        ]);

        $userB = User::create([
            'name' => 'Another',
            'email' => 'another@another.com',
            'password' => bcrypt('password'),
            'active' => true,
        ]);

        Livewire::test(DataTables::class)
            ->set('search', 'another@another.com')
            ->assertSee($userB->name)
            ->assertDontSee($userA->name);
    }

    /**
     * @test
     */
    public function dataTablesSortsNameAsc()
    {
        $userC = User::create([
            'name' => 'Cathy C',
            'email' => 'cathy@cathy.com',
            'password' => bcrypt('password'),
            'active' => true,
        ]);

        $userA = User::create([
            'name' => 'Andre A',
            'email' => 'andre@andre.com',
            'password' => bcrypt('password'),
            'active' => true,
        ]);

        $userB = User::create([
            'name' => 'Brian B',
            'email' => 'brian@brian.com',
            'password' => bcrypt('password'),
            'active' => true,
        ]);

        Livewire::test(DataTables::class)
            ->call('sortBy', 'name')
            ->assertSeeInOrder([$userA->name, $userB->name, $userC->name]);
    }

    /**
     * @test
     */
    public function dataTablesSortsNameDsc()
    {
        $userC = User::create([
            'name' => 'Cathy C',
            'email' => 'cathy@cathy.com',
            'password' => bcrypt('password'),
            'active' => true,
        ]);

        $userA = User::create([
            'name' => 'Andre A',
            'email' => 'andre@andre.com',
            'password' => bcrypt('password'),
            'active' => true,
        ]);

        $userB = User::create([
            'name' => 'Brian B',
            'email' => 'brian@brian.com',
            'password' => bcrypt('password'),
            'active' => true,
        ]);

        Livewire::test(DataTables::class)
            ->call('sortBy', 'name')
            ->call('sortBy', 'name')
            ->assertSeeInOrder([$userC->name, $userB->name, $userA->name,]);
    }

    /**
     * @test
     */
    public function dataTablesSortsEmailAsc()
    {
        $userC = User::create([
            'name' => 'Cathy C',
            'email' => 'cathy@cathy.com',
            'password' => bcrypt('password'),
            'active' => true,
        ]);

        $userA = User::create([
            'name' => 'Andre A',
            'email' => 'andre@andre.com',
            'password' => bcrypt('password'),
            'active' => true,
        ]);

        $userB = User::create([
            'name' => 'Brian B',
            'email' => 'brian@brian.com',
            'password' => bcrypt('password'),
            'active' => true,
        ]);

        Livewire::test(DataTables::class)
            ->call('sortBy', 'email')
            ->assertSeeInOrder([$userA->name, $userB->name, $userC->name]);
    }

    /**
     * @test
     */
    public function dataTablesSortsEmailDsc()
    {
        $userC = User::create([
            'name' => 'Cathy C',
            'email' => 'cathy@cathy.com',
            'password' => bcrypt('password'),
            'active' => true,
        ]);

        $userA = User::create([
            'name' => 'Andre A',
            'email' => 'andre@andre.com',
            'password' => bcrypt('password'),
            'active' => true,
        ]);

        $userB = User::create([
            'name' => 'Brian B',
            'email' => 'brian@brian.com',
            'password' => bcrypt('password'),
            'active' => true,
        ]);

        Livewire::test(DataTables::class)
            ->call('sortBy', 'email')
            ->call('sortBy', 'email')
            ->assertSeeInOrder([$userC->name, $userB->name, $userA->name,]);
    }
}
