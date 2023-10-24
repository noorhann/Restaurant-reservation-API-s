<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Meal;
use App\Models\Reservation;
use App\Models\Table;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PlaceOrderTest extends TestCase
{
    use RefreshDatabase;

    public function testStoreReservation()
    {
        $customer = Customer::factory()->create();
        $table = Table::factory()->create(['capacity' => 4]);
        $reservation = Reservation::factory()->create([
            'customer_id' => $customer->id,
            'table_id' => $table->id,
            'from_time' => '2023-10-18 12:00:00',
            'to_time' => '2023-10-18 14:00:00',
        ]);
        $meal1 = Meal::factory()->create();
        $meal2 = Meal::factory()->create();

        $requestData = [
            'customer_id' => $customer->id,
            'reservation_id' => $reservation->id,
            'table_id'=>$table->id,
            'meal_id' => [$meal1->id, $meal2->id],

        ];

        $response = $this->json('POST', '/api/order/create', $requestData);

        $response->assertUnauthorized();

        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $this->actingAs($user);

        $requestData = [
            'customer_id' => $customer->id,
            'reservation_id' => $reservation->id,
            'table_id' => $table->id,
            'meal_id' => [$meal1->id, $meal2->id],
        ];

        $response = $this->json('POST', '/api/order/create', $requestData);

        $response->assertStatus(201);

        $requestData = [
            'customer_id' => $customer->id,
            'meal_id' => [$meal1->id, $meal2->id],
        ];

        $response = $this->json('POST', '/api/order/create', $requestData);

        $response->assertStatus(400);

        
    }
}
