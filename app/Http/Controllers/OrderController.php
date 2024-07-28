<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with('customer','candies')->get();

        if ($orders->isEmpty()) {
            return response()->json([
                'message' => "Não foi encontrado nenhum pedido!"
            ], 400, [], JSON_UNESCAPED_UNICODE);
        }

        return response()->json([
            'message' => 'Requisição feita com sucesso',
            'data' => $orders
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        try {
            $data = $request->all();
            $candies = $data["candies"];
            $order = Order::create([
                'customer_id' => $data['customer_id'],
                'status' => "pendente",
            ]);

            foreach ($candies as $candy_id => $value) {
                $order->addCandy($value);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "Não foi possível adicionar o cliente!"
            ], 400, [], JSON_UNESCAPED_UNICODE);
        }

        return response()->json([
            'message' => 'Pedido criado com sucesso!',
            'data' => $order
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $order)
    {
        try {
            $orderData = Order::findOrFail($order);
            $orderData->customer;
            $orderData->candies;
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "Não foi encontrado nenhum cliente!"
            ], 400, [], JSON_UNESCAPED_UNICODE);
        }
        
        return response()->json([
            'message' => 'Pedido encontrado!',
            'data' => $orderData
        ], 200, []);
    }
}
