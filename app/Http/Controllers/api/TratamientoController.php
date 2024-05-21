<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Tratamiento;

class TratamientoController extends Controller
{
    public function index()
    {
        $tratamientos = Tratamiento::all();

        return response()->json(['tratamientos' => $tratamientos]);
    }

    public function store(Request $request)
    {
        // Validar la solicitud
        $validator = Validator::make($request->all(), [
            'fecha_facturacion' => 'required|date',
            'total' => 'required|numeric|min:0',
            'estado' => 'required|in:pendiente,pagada',
        ]);

        // Verificar si la validación falla
        if ($validator->fails()) {
            return response()->json([
                'msg' => 'Se produjo un error en las validaciones de la información',
                'statuscode' => 422,
                'errors' => $validator->errors()
            ], 422);
        }

        // Crear el nuevo tratamiento
        $tratamiento = Tratamiento::create($request->all());

        return response()->json(['tratamiento' => $tratamiento], 201);
    }

    public function show($id)
    {
        $tratamiento = Tratamiento::find($id);

        if (!$tratamiento) {
            return response()->json(['message' => 'Tratamiento no encontrado'], 404);
        }

        return response()->json(['tratamiento' => $tratamiento]);
    }

    public function update(Request $request, $id)
    {
        $tratamiento = Tratamiento::find($id);

        if (!$tratamiento) {
            return response()->json(['message' => 'Tratamiento no encontrado'], 404);
        }

        // Validar la solicitud
        $validator = Validator::make($request->all(), [
            'fecha_facturacion' => 'sometimes|required|date',
            'total' => 'sometimes|required|numeric|min:0',
            'estado' => 'sometimes|required|in:pendiente,pagada',
        ]);

        // Verificar si la validación falla
        if ($validator->fails()) {
            return response()->json([
                'msg' => 'Se produjo un error en las validaciones de la información',
                'statuscode' => 422,
                'errors' => $validator->errors()
            ], 422);
        }

        // Actualizar el tratamiento
        $tratamiento->update($request->all());

        return response()->json(['tratamiento' => $tratamiento]);
    }

    public function destroy($id)
    {
        $tratamiento = Tratamiento::find($id);

        if (!$tratamiento) {
            return response()->json(['message' => 'Tratamiento no encontrado'], 404);
        }

        $tratamiento->delete();

    
    }}