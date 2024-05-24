<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Paciente;

class PacienteController extends Controller
{
    public function index()
    {
        $pacientes = Paciente::all();

        return response()->json(['pacientes' => $pacientes]);
    }

    public function store(Request $request)
    {
    // Validar la solicitud
    $validator = Validator::make($request->all(), [
        'nombre' => 'required|string|max:255',
        'apellido' => 'required|string|max:255',
        'fecha_nacimiento' => 'required|date',
        'sexo' => 'required|in:Masculino,Femenino',
        'direccion' => 'required|string|max:255',
        'telefono' => 'required|string|max:20',
        'email' => 'required|email|unique:pacientes,email',
    ]);

    // Verificar si la validación falla
    if ($validator->fails()) {
        return response()->json([
            'msg' => 'Se produjo un error en las validaciones de la información',
            'statuscode' => 422,
            'errors' => $validator->errors()
        ], 422);
    }

    // Crear el nuevo paciente paso a paso
    $paciente = new Paciente();
    $paciente->nombre = $request->nombre;
    $paciente->apellido = $request->apellido;
    $paciente->fecha_nacimiento = $request->fecha_nacimiento;
    $paciente->sexo = $request->sexo;
    $paciente->direccion = $request->direccion;
    $paciente->telefono = $request->telefono;
    $paciente->email = $request->email;
    $paciente->save();

    return response()->json(['paciente' => $paciente], 201);
    }

    public function show($id)
    {
        $paciente = Paciente::find($id);

        if (!$paciente) {
            return response()->json(['message' => 'Paciente no encontrado'], 404);
        }

        return response()->json(['paciente' => $paciente]);
    }

    public function update(Request $request, $id)
    {
        $paciente = Paciente::find($id);

    if (!$paciente) {
        return response()->json(['message' => 'Paciente no encontrado'], 404);
    }

    // Validar la solicitud
    $validator = Validator::make($request->all(), [
        'nombre' => 'required|string|max:255',
        'apellido' => 'required|string|max:255',
        'fecha_nacimiento' => 'required|date',
        'sexo' => 'required|in:Masculino,Femenino',
        'direccion' => 'required|string|max:255',
        'telefono' => 'required|string|max:20',
        'email' => 'required|email|unique:pacientes,email,' . $id,
    ]);

    // Verificar si la validación falla
    if ($validator->fails()) {
        return response()->json([
            'msg' => 'Se produjo un error en las validaciones de la información',
            'statuscode' => 422,
            'errors' => $validator->errors()
        ], 422);
    }

    // Crear el nuevo paciente paso a paso
    $paciente = new Paciente();
    $paciente->nombre = $request->nombre;
    $paciente->apellido = $request->apellido;
    $paciente->fecha_nacimiento = $request->fecha_nacimiento;
    $paciente->sexo = $request->sexo;
    $paciente->direccion = $request->direccion;
    $paciente->telefono = $request->telefono;
    $paciente->email = $request->email;
    $paciente->save();

   

    return response()->json(['paciente' => $paciente]);
    }
    
    public function destroy($id)
    {
        $paciente = Paciente::find($id);

        if (!$paciente) {
            return response()->json(['message' => 'Paciente no encontrado'], 404);
        }

        $paciente->delete();

        return response()->json(['message' => 'Paciente eliminado correctamente']);
    }
}
