<?php

namespace App\Http\Controllers;

use App\Models\Candy;
use Illuminate\Http\Request;

class CandyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $candies = Candy::all();

        if (empty($candies)) {
            return response()->json([
                'message' => "Não foi encontrado nenhum doce!"
            ], 400, [], JSON_UNESCAPED_UNICODE);
        }

        return response()->json([
            'message' => 'Requisição feita com sucesso',
            'data' => $candies
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $candy)
    {
        try {
            $candy = Candy::findOrFail($candy);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "Não foi encontrado nenhum doce!"
            ], 400, [], JSON_UNESCAPED_UNICODE);
        }
        
        return response()->json([
            'message' => 'Doce encontrado!',
            'data' => $candy
        ], 200, []);
    }
}
