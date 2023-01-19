<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;

class ProductController extends Controller
{
    public function produtos(Request $request)
    {
        $produtos = Product::where('user_id', '=', $request->user()->id)->paginate(15);
        return response()->json($produtos);
    }

    public function produto($id, Request $request)
    {
        $query = Product::where([
            'id' => $id,
            'user_id' => $request->user()->id
        ])->get();

        if(count($query) > 0){
        return response()->json($query);
        }

        return response()->json([
            'mensage' => 'Nenhum produto encontrado' 
        ], 404);

        
    }

    public function criarProduto(Request $request)
    {
        $user = $request->user();
        $request->validate([
            'produto' => 'required'
        ]);
        $produto = $user->produtos()->create([
            'produto' => $request->produto
        ]);

        return response()->json([
            'mensage' => 'Produto criado com sucesso',
            'produto' => $produto
        ]);
    }

    public function atualizar($id, Request $request)
    {
        $product = Product::where([
            'id' => $id,
            'user_id' => $request->user()->id
        ])->update([
            'produto' => $request->produto
        ]);

        if ($product) {
            return response()->json([
                'mensage' => 'Produto atualizado com sucesso'
            ]);
        }
        return response()->json([
            'mensage' => 'Produto não encontrado'
        ], 404);
    }

    public function deletar($id, Request $request)
    {
        $product = Product::where([
            'id' => $id,
            'user_id' => $request->user()->id
        ])->delete();

        if ($product) {
            return response()->json([
                'mensage' => 'Produto deletado com sucesso'
            ]);
        }
        return response()->json([
            'mensage' => 'Produto não encontrado'
        ], 404);
    }
}
