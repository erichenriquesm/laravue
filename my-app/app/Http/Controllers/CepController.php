<?php

namespace App\Http\Controllers;

use App\Models\Cep;
use Illuminate\Http\Request;

class CepController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Cep $cep)
    {
        return Cep::paginate(3);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'cep' => 'required|unique:ceps|min:8|max:8|string',
            'cidade' => 'required|unique:ceps|string',
            'estado' => 'required|max:2|string'
        ]);

        $cep = Cep::create([
            'cep' => $request->cep,
            'cidade' => $request->cidade,
            'estado' => $request->estado
        ]);

        return response()->json($cep, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cep  $cep
     * @return \Illuminate\Http\Response
     */
    public function show(Cep $cep)
    {
        return $cep;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cep  $cep
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Cep $cep)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cep  $cep
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cep $cep)
    {
        if($cep->cep !== $request->cep && $cep->cidade === $request->cidade){
            $request->validate([
                'cep' => 'required|unique:ceps|min:8|max:8|string',
                'cidade' => 'required|string',
                'estado' => 'required|max:2|string'
            ]);
            $cep->update([
                'cep' => $request->cep,
                'estado' => $request->estado
            ]);
            return response()->json($cep, 200);
        }

        if($cep->cidade !== $request->cidade && $cep->cep === $request->cep){
            $request->validate([
                'cep' => 'required|min:8|max:8|string',
                'cidade' => 'required|unique:ceps||string',
                'estado' => 'required|max:2|string'
            ]);
            $cep->update([
                'cidade' => $request->cidade,
                'estado' => $request->estado
            ]);
            return response()->json($cep, 200);
        }

        $request->validate([
            'cep' => 'required|unique:ceps|min:8|max:8|string',
            'cidade' => 'required|unique:ceps|string',
            'estado' => 'required|max:2|string'
        ]);

        $cep->update([
            'cep' => $request->cep,
            'cidade' => $request->cidade,
            'estado' => $request->estado
        ]);

        return response()->json($cep, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cep  $cep
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cep $cep)
    {
        $cep->delete();
        return response()->json([
            'mensage' => 'Deletado'
        ]);
    }
}
