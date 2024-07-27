<?php

namespace Tests\Feature;

use App\Models\Candy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CandyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_get_all_candies(): void
    {
        $data = [];
        $candies = Candy::factory(10)->create();
        $response = $this->getJson(route('candy.index'));

        foreach ($candies as $key => $candy) {
            $data[] = [
                'name' => $candy->name,
                'price' => $candy->price,
                'unit' => $candy->unit
            ];
        }

        $response->assertOk();
        $response->assertJson(['data' => $data]);
    }

    public function test_show_candy()
    {
        $candy = Candy::factory()->create();
        $response = $this->getJson(route('candy.show', ['candy'=> $candy->id]));
        
        $response->assertOk();
        $response->assertJson([
            'data' => [
                'name' => $candy->name,
                'price' => $candy->price,
                'unit' => $candy->unit,
            ]
        ]);
    }
}
