<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $customers = Customer::all();

        if (empty($customers)) {
            return response()->json([
                'message' => "Não foi encontrado nenhum cliente!"
            ], 400, [], JSON_UNESCAPED_UNICODE);
        }

        return response()->json([
            'message' => 'Requisição feita com sucesso',
            'data' => $customers
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $customer = Customer::create([
                'name' => $data['name'],
                'phone' => $data['phone'],
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "Não foi possível adicionar o cliente!"
            ], 400, [], JSON_UNESCAPED_UNICODE);
        }

        return response()->json([
            'message' => 'Cliente criado com sucesso!',
            'data' => $customer
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $customer): JsonResponse
    {
        try {
            $customer = Customer::findOrFail($customer);
            $customer->orders;
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "Não foi encontrado nenhum cliente!"
            ], 400, [], JSON_UNESCAPED_UNICODE);
        }
        
        return response()->json([
            'message' => 'Cliente encontrado!',
            'data' => $customer
        ], 200, []);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $customer): JsonResponse
    {
        try {
            $data = $request->all();
            $customer = Customer::findOrFail($customer);
            $customer->update($data);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Algo deu errado ao atualizar: ' . $th->getMessage(),
                'data' => $customer
            ], 400);
        }
       
        return response()->json([
            'message' => 'Cliente autailizado!',
            'data' => $customer
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $customer): JsonResponse
    {
        try {
            $customer = Customer::findOrFail($customer);
            $customer->delete();
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Algo deu errado ao deletar: ' . $th->getMessage()
            ], 400);
        }
       
        return response()->json([
            'message' => 'Cliente deletado!'
        ], 200);
    }
}
