<?php

namespace Tests\Feature;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_get_all_customers(): void
    {
        $customer = Customer::factory()->create();
        $response = $this->getJson(route('customer.index'));

        $response->assertOk();
        $response->assertJson([
            'data' => [
                [
                    'name' => $customer->name,
                    'phone' => $customer->phone,
                ]
            ]
        ]);
    }

    public function test_store_customer()
    {
        $newCustomerData = Customer::factory()->make();
        $customer =  $newCustomerData->toArray();

        $response = $this->postJson(
            route('customer.store'),
            $customer
        );

        $response->assertCreated();
        $response->assertJson([
            'data' => [
                'name' => $customer['name'],
                'phone' => $customer['phone'],
            ]
        ]);
        $this->assertDatabaseHas('customers', $customer);
    }

    public function test_show_customer()
    {
        $customer = Customer::factory()->hasOrders(2)->create();
        $response = $this->getJson(route('customer.show', ['customer'=> $customer->id]));
        
        $response->assertOk();
        $response->assertJson([
            'data' => [
                'id' => $customer->id,
                'name' => $customer->name,
                'phone' => $customer->phone,
                'orders' => [
                    [
                        'id' => $customer->orders[0]->id,
                        'status' => $customer->orders[0]->status
                    ],
                    [
                        'id' => $customer->orders[1]->id,
                        'status' => $customer->orders[1]->status
                    ]
                ]
            ]
        ]);
    }

    public function test_update_customer()
    {
        $customerCurrentData = Customer::factory()->create();
        $newCustomer = Customer::factory()->make();
        $newCustomerArray = $newCustomer->toArray();
        $response = $this->putJson(
            route('customer.update', $customerCurrentData),
            $newCustomerArray
        );

        $response->assertOk();
        $response->assertJson([
            'data' => [
                'name' => $newCustomer->name,
                'phone' => $newCustomer->phone,
            ]
        ]);
        $this->assertDatabaseHas('customers', $newCustomerArray);
    }

    public function test_delete_customer()
    {
        $customer = Customer::factory()->create();

        $this->deleteJson(route('customer.destroy', ['customer'=> $customer->id]));
        $this->assertDatabaseMissing('customers', $customer->toArray());
    }
}
