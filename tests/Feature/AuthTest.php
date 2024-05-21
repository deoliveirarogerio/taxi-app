<?php

use App\Models\Ride;
use App\Models\User;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;
use function Pest\Laravel\postJson;

it('allows a user to create a ride', function () {
    // Arrange
    $email = 'user_' . Str::random(10) . '@example.com';
    $user = User::factory()->create([
        'email' => $email,
    ]);
    Sanctum::actingAs($user);

    // Act
    $response = postJson('/api/request-ride', [
        'pickup_location' => 'Rua dos Fulanos, 33',
        'dropoff_location' => 'Rua dos Ciclanos, 188',
    ]);

    // Assert
    $response->assertStatus(201)
             ->assertJsonStructure(  ['ride' =>
                 'id', 'pickup_location', 'dropoff_location', 'user_id', 'created_at', 'updated_at',
             ]);
});

it('allows a user to cancel a ride', function () {
    // Arrange
    $email = 'user_' . Str::random(10) . '@example.com';
    $user = User::factory()->create([
        'email' => $email,
    ]);
    Sanctum::actingAs($user);

    $ride = Ride::create([
        'user_id' => $user->id,
        'pickup_location' => 'Rua dos Fulanos, 33',
        'dropoff_location' => 'Rua dos Ciclanos, 188',
        'status' => 'requested',
    ]);

    // Act
    $response = postJson("/api/cancel-ride/{$ride->id}");

    // Assert
    $response->assertStatus(201)
             ->assertJson(['message' => 'Ride canceled successfully.']);

    $this->assertDatabaseHas('rides', [
        'id' => $ride->id,
        'status' => 'canceled',
    ]);
});