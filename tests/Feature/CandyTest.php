<?php

namespace Tests\Feature;

use App\Models\Candy;
use App\Models\User;
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
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();
        $data = [];
        $candies = Candy::factory(10)->create();
        $response = $this->actingAs($user)->getJson(route('candy.index'));

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

    public function test_show_candy(): void
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();
        $candy = Candy::factory()->create();
        $response = $this->actingAs($user)->getJson(route('candy.show', ['candy'=> $candy->id]));
        
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
