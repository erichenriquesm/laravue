<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserController1;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CepController;
Route::middleware('auth:sanctum')->group(function(){
    // Route::prefix('/users')->group(function(){
    //     Route::get('/userss', [UserController::class, 'users']);
    //     Route::get('/', [UserController::class, 'user']);
    //     Route::put('/',  [UserController::class, 'atualizar']);
    //     Route::delete('/', [UserController::class, 'deletar']);
    // });

    Route::prefix('/product')->group(function(){
        Route::get('/', [ProductController::class, 'produtos']);
        Route::get('/{id}', [ProductController::class, 'produto']);
        Route::post('/', [ProductController::class, 'criarProduto']);
        Route::put('/{id}', [ProductController::class, 'atualizar']);
        Route::delete('/{id}', [ProductController::class, 'deletar']);

    });
    
});

Route::prefix('/user')->group(function(){
    Route::post('/', [UserController::class, 'criar']);
    Route::post('/login', [UserController::class, 'login']); 
    Route::post('/{user}', [UserController::class, 'insertCpf']);
});

Route::post('/file', function(Request $request){
    if($request->hasFile('file') && $request->file('file')->isValid()){
        $requestImage = $request->file;
        $extension = $requestImage->extension();
        $imageName = md5($requestImage->getClientOriginalName() . strtotime('now')) . '.' . $extension;
        $request->file('file')->store('solidao');
        return $imageName;
    }
 
});
Route::prefix('/cep')->group(function(){
    Route::get('/', [CepController::class, 'index']);
    Route::get('/{cep:cep}', [CepController::class, 'show']);
    Route::post('/', [CepController::class, 'store']);
    Route::put('/{cep}', [CepController::class, 'update']);
    Route::delete('/{cep}', [CepController::class, 'destroy']);
});


