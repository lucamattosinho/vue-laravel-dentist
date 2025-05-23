<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Consulta;

class ConsultaController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        return Consulta::with('paciente')->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'data_hora' => 'required|date',
            'tratamento' => 'required|string|max:255',
            'descricao' => 'nullable|string',
        ]);

        $consulta = Consulta::create($request->all());

        return response()->json([
            'message' => 'Consulta criada com sucesso.',
            'consulta' => $consulta,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $consulta = Consulta::with('paciente')->findOrFail($id);
        return response()->json($consulta);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $consulta = Consulta::findOrFail($id);
        $consulta->update($request->all());
        return response()->json($consulta);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $consulta = Consulta::findOrFail($id);
        $consulta->delete();
        return response()->json([
            'message' => 'Consulta deletada com sucesso.',
        ]);
    }
}
