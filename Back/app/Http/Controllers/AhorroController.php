<?php

namespace App\Http\Controllers;

use App\Models\Ahorro;
use Illuminate\Http\Request;

class AhorroController extends Controller
{
    public function index()
    {
        $ahorros = Ahorro::all();
        return response()->json($ahorros);
    }

    public function store(Request $request)
    {
        // Valida los datos de entrada
        $request->validate([
            'descripcion' => 'required|string',
            'meta_id' => 'required|integer',
            'importe' => 'required|numeric',
        ]);

        // Crea un nuevo ingreso
        $ahorros = Ahorro::create([
            'descripcion' => $request->input('descripcion'),
            'user_id' => auth()->user()->id, // Asigna el ID del usuario actual
            'meta_id' => $request->input('meta_id'),
            'importe' => $request->input('importe'),
        ]);

        return response()->json(['message' => 'Ahorro creado con éxito', 'data' => $ahorros], 201);
    }

    public function update(Request $request, $id)
    {
        // Valida los datos de entrada
        $request->validate([
            'descripcion' => 'required|string',
            'meta_id' => 'required|integer',
            'importe' => 'required|numeric',
        ]);

        // Busca el ahorro por su ID
        $ahorros = Ahorro::find($id);

        if (!$ahorros) {
            return response()->json(['message' => 'Ahorro no encontrado'], 404);
        }

        // Actualiza los campos del ahorro
        $ahorros->update([
            'descripcion' => $request->input('descripcion'),
            'meta_id' => $request->input('meta_id'),
            'importe' => $request->input('importe'),
        ]);

        return response()->json(['message' => 'Ahorro actualizado con éxito', 'data' => $ahorros]);
    }

    public function destroy($id)
    {
        // Busca el ahorro por su ID
        $ahorros = Ahorro::find($id);

        if (!$ahorros) {
            return response()->json(['message' => 'Ahorro no encontrado'], 404);
        }

        // Elimina el ahorro
        $ahorros->delete();

        return response()->json(['message' => 'Ahorro eliminado con éxito']);
    }

}