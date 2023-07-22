<?php

namespace Tests\Feature;

use App\Models\Tour;
use App\Models\Travel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ToursListTest extends TestCase
{
    use RefreshDatabase;
    public function test_tours_list_by_travel_slug_(): void
    {
        $travel = Travel::factory()->create();
        $tour = Tour::factory()->create(['travel_id' => $travel->id]);
        $response = $this->get('/api/v1/travels/' . $travel->slug . '/tours' );

        $response->assertStatus(200);
        $response->assertJsonCount(1 , 'data');
        $response->assertJsonFragment(['id' => $tour->id]);
    }

    public function test_tours_price_match(): void
    {
        $travel = Travel::factory()->create();
        Tour::factory()->create(['travel_id' => $travel->id , 'price' => 11000000]);
        $response = $this->get('/api/v1/travels/'.$travel->slug.'/tours' );

        $response->assertStatus(200);
        $response->assertJsonCount(1 , 'data');
        $response->assertJsonFragment(['price' => '1,100,000']);
    }

    public function test_tours_list_with_pagination(): void
    {
        $travel = Travel::factory()->create();
        Tour::factory(16)->create(['travel_id' => $travel->id]);

        $response = $this->get('/api/v1/travels/'.$travel->slug.'/tours' );

        $response->assertStatus(200);
        $response->assertJsonCount(15, 'data');
        $response->assertJsonPath('meta.last_page' , 2);
    }
}
