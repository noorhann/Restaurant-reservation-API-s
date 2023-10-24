<?php

namespace Tests\Feature;

use App\Models\Meal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListMenuTest extends TestCase
{
    use RefreshDatabase;

    public function testListMenu()
    {
        Meal::factory(3)->create();

        $response = $this->get('/api/menu');

        $response->assertStatus(200);
       
    }
}
