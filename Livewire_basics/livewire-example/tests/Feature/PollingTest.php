<?php

namespace Tests\Feature;

use App\Http\Livewire\PollingExample;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class PollingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     *
     */
    public function mainPageContainsPollingComponent()
    {
        $this->get('/')
            ->assertSeeLivewire('polling-example');
    }

    /**
     * @test
     *
     */
    public function pollSumsOrdersCorrectly()
    {
        $orderA = Order::create(['price' => 20]);
        $orderB = Order::create(['price' => 20]);

        Livewire::test(PollingExample::class)
            ->call('getRevenue')
            ->assertSet('revenue', 40)
            ->assertSee('40 $');

        $orderC = Order::create(['price' => 20]);

        Livewire::test(PollingExample::class)
            ->call('getRevenue')
            ->assertSet('revenue', 60)
            ->assertSee('60 $');
    }
}
