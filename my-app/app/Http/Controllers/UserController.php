<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cpf;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller

{
    // public function __construct()
    // {
    //     // $this->middleware('checkToken')->only('user');
    //     $this->middleware(function (){
    //         dd('foi');
    //     })->only('user');
    // }
    public function insertCpf(Request $request, User $user)
    {
        $request->validate([
            'cpf' => 'min:11|max:11|unique:cpfs'
        ]);
        $query = Cpf::where('user_id', '=', $user->id)->get();
        if (count($query) === 0) {
            $cpf = $user->cpf()->create([
                'cpf' => $request->cpf
            ]);
            return response()->json([
                'mensage' => 'sucesso',
                'cpf' => $cpf
            ], 200);
        } else {
            return response()->json([
                'mensage' => 'Não se pode registrar mais de um cpf na mesma conta'
            ]);
        }
    }
    public function users(Request $request, $id)
    {
        $users = User::paginate(15);
        // return response()->json($users);
        return $id;
    }

    public function user(User $user)
    {
        $user->token = $user->createToken($user->email)->plainTextToken;
        return $user;
    }

    public function criar(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string'
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        $user->token = $user->createToken($request->email)->plainTextToken;
        return response()->json($user);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = auth()->user();
            $user->token = $user->createToken($user->email)->plainTextToken;
            return response()->json($user);
        }
        return response()->json([
            'mensage' => 'Erro ao logar'
        ], 401);
    }

    public function atualizar(Request $request)
    {
        $user = $request->user();
        if ($request->name) {
            $request->validate([
                'name' => 'string|min:3'
            ]);
            $user->update([
                'name' => $request->name
            ]);
        }

        if ($request->email) {
            $request->validate([
                'email' => 'email|unique:users'
            ]);
            $user->update([
                'email' => $request->email
            ]);
        }

        if ($request->password) {
            $request->validate([
                'password' => 'string|min:6'
            ]);
            $user->update([
                'password' => bcrypt($request->password)
            ]);
        }

        $user->token = $user->createToken($user->email)->plainTextToken;

        return response()->json($user);
    }

    public function deletar(Request $request)
    {
        $request->user()->delete();
        return response()->json([
            'mensage' => 'Usuário deletado com sucesso'
        ]);
    }
}
