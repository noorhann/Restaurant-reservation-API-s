<?php

namespace Tests\Feature;

use App\Http\Controllers\ReservationController;
use App\Models\Customer;
use App\Models\Table;
use App\Models\User;
use App\Services\ReservationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreReservationTest extends TestCase
{

    use RefreshDatabase;

    public function testStoreReservation()
    {
        $table = Table::factory()->create(['capacity' => 4]);
        $customer = Customer::factory()->create();

        $requestData = [
            'from_time' => '2023-10-18 12:00:00',
            'to_time' => '2023-10-18 14:00:00',
            'table_id' => $table->id,
            'customer_id' => $customer->id,
        ];

        $response = $this->json('POST', '/api/reservation/store',$requestData);

        // Assert that the response indicates unsuccessful authentication
        $response->assertUnauthorized();

        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $this->actingAs($user);

        $response = $this->json('POST', '/api/reservation/store', $requestData);

        // Assert that the response indicates a successful reservation creation
        $response->assertStatus(201); 

    }
}

