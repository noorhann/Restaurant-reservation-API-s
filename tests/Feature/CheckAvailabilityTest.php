<?php

namespace Tests\Feature;

use App\Http\Controllers\ReservationController;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Table;
use App\Models\Reservation;
use App\Models\User;

class CheckAvailabilityTest extends TestCase
{

    use RefreshDatabase;

    public function testCheckAvailability()
    {
        // Create a table and reservation for testing
        $table = Table::factory()->create(['capacity' => 4]);
        $customer = Customer::factory()->create();

        $reservation = Reservation::factory()->create([
            'customer_id' => $customer->id,
            'table_id' => $table->id,
            'from_time' => '2023-10-18 12:00:00',
            'to_time' => '2023-10-18 14:00:00',
        ]);

        // Send a test request to the checkAvailability while user is not logged in
        $response = $this->json('POST', '/api/reservation/checkAvailabilty', [
            'from_time' => '2023-10-18 15:00:00',
            'to_time' => '2023-10-18 16:00:00',
            'guestsNo' => 3,
        ]);

        // Assert that the response indicates unsuccessful authentication
        $response->assertUnauthorized();

        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $this->actingAs($user);

        // Make a request to the authenticated route
        $response = $this->json('POST', '/api/reservation/checkAvailabilty', [
            'from_time' => '2023-10-18 15:00:00',
            'to_time' => '2023-10-18 16:00:00',
            'guestsNo' => 4,
        ]);

        // Assert that the response indicates a successful authentication
        $response->assertStatus(200);

        $response = $this->json('POST', '/api/reservation/checkAvailabilty', [
            'from_time' => '2023-10-18 15:00:00',
            'to_time' => '2023-10-18 16:00:00',
            'guestsNo' => 6,
        ]);

        // Assert that the response indicates no available tables
        $response->assertStatus(404);

        $response = $this->json('POST', '/api/reservation/checkAvailabilty', [
            'from_time' => '2023-10-18 15:00:00',
        ]);

        // Assert that the response indicates bad request
        $response->assertStatus(400);
    }

   
}

