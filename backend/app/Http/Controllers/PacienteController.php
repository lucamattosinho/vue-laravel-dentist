<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            "first_name"=> "required|string|max:255",
            "last_name"=> "required|string|max:255",
            "cpf"=> "required|string|max:14|unique:pacientes,cpf",
            "phone"=> "required|string|max:15"
        ]);

        $paciente = Paciente::create([
            "first_name"=> $request->first_name,
            "last_name"=> $request->last_name,
            "cpf"=> $request->cpf,
            "phone"=> $request->phone
        ]);

        return response()->json($paciente, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
