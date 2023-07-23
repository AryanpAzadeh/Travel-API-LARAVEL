<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\Travel;
use App\Models\User;
use Database\Seeders\RoleSeed;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTourTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_user_cannot_access_adding_tour(): void
    {
        $travel = Travel::factory()->create();
        $response = $this->postJson('/api/v1/admin/store/travel/'.$travel->id.'/tour');

        $response->assertStatus(401);
    }

    public function test_non_admin_user_cannot_access_adding_tour(): void
    {
        $this->seed(RoleSeed::class);
        $user = User::factory()->create();
        $user->roles()->attach(Role::where('name', 'editor')->value('id'));
        $travel = Travel::factory()->create();
        $response = $this->actingAs($user)->postJson('/api/v1/admin/store/travel/'.$travel->id.'/tour');

        $response->assertStatus(403);
    }

    public function test_saves_tour_successfully_with_valid_data(): void
    {
        $this->seed(RoleSeed::class);
        $user = User::factory()->create();
        $user->roles()->attach(Role::where('name', 'admin')->value('id'));
        $travel = Travel::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/v1/admin/store/travel/'.$travel->id.'/tour', [
            'name' => 'Tour name',
        ]);
        $response->assertStatus(422);

        $response = $this->actingAs($user)->postJson('/api/v1/admin/store/travel/'.$travel->id.'/tour', [
            'name' => 'Tour name',
            'starting_date' => now()->toDateString(),
            'ending_date' => now()->addDay()->toDateString(),
            'price' => 123456,
        ]);

        $response->assertStatus(201);

        $response = $this->get('/api/v1/travels/'.$travel->slug.'/tours');
        $response->assertJsonFragment(['name' => 'Tour name']);
    }
}
