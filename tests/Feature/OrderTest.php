<?php

namespace Tests\Feature;

use App\Enums\CandyEnum;
use App\Models\Candy;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_get_all_orders(): void
    {
        $customer = Customer::factory()->create();
        $order = Order::factory()->create(["customer_id" => $customer->id]);
        $candy1 = Candy::factory()->create();
        $candy2 = Candy::factory()->create();

        $order->addCandy($candy1->id);
        $order->addCandy($candy2->id);

        $response = $this->getJson(route('order.index'));

        $response->assertOk();
        $response->assertJson([
            'message' => 'Requisição feita com sucesso',
            'data' => [
                [
                    'id' => $order->id,
                    'status' => $order->status,
                    'customer' => [
                        'id' => $customer->id,
                        'name' => $customer->name,
                        'phone' => $customer->phone,
                    ],
                    'candies' => [
                        [
                            'id' => $candy1->id,
                            'name' => $candy1->name,
                            'price' => $candy1->price,
                            'unit' => $candy1->unit,
                        ],
                        [
                            'id' => $candy2->id,
                            'name' => $candy2->name,
                            'price' => $candy2->price,
                            'unit' => $candy2->unit,
                        ],
                    ]
                ]
            ]
        ]);
    }

    public function test_store_order(): void
    {
        $customer = Customer::factory()->create();
        $candy1 = Candy::factory()->create();
        $order = Order::factory()
            ->withOtherStatus('pendente')
            ->make(["customer_id" => $customer->id]);
            
        $orderData = [
            "customer_id" => $order->customer->id,
            "candies" => [
                $candy1->id
            ]
        ];
        $response = $this->postJson(route('order.store'), $orderData);

        $response->assertCreated();
        $response->assertJson([
            'data' => [
                'customer_id' => $order->customer_id,
                'status' => $order->status,
            ]
        ]);

        $createdOrder = Order::latest()->first();

        $this->assertDatabaseHas(
            'orders', 
            ['customer_id' => $customer->id, 'status' => 'pendente']
        );
        $this->assertDatabaseHas(
            'order_candies', 
            ['order_id' => $createdOrder->id, 'candy_id' => $candy1->id]
        );
    }
}
