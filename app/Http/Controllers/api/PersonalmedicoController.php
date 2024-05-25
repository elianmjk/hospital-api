<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\PersonalMedico;

class PersonalMedicoController extends Controller
{
    public function index()
    {
        $personalMedico = PersonalMedico::all();

        return response()->json(['personal_medico' => $personalMedico]);
    }

    public function store(Request $request)
    {
        // Validar la solicitud
        $validator = Validator::make($request->all(), [

            'nombre' => 'required',
            'apellido' => 'required',
            'especialidad' => 'required',
            'horario' => 'required',

        ]);

        // Verificar si la validación falla
        if ($validator->fails()) {
            return response()->json([
                'msg' => 'Se produjo un error en las validaciones de la información',
                'statuscode' => 422,
                'errors' => $validator->errors()
            ], 422);
        }

        $personalMedico = new PersonalMedico;
        $personalMedico->nombre = $request->nombre;
        $personalMedico->apellido = $request->apellido;
        $personalMedico->especialidad = $request->especialidad;
        $personalMedico->horario = $request->horario;
        $personalMedico->save();
        


        return response()->json(['personalmedico' => $personalMedico], 201);
    }

    public function show($id)
    {
        $personalMedico = PersonalMedico::find($id);

        if (!$personalMedico) {
            return response()->json(['message' => 'Personal médico no encontrado'], 404);
        }

        return response()->json(['personalmedico' => $personalMedico]);
    }

    public function update(Request $request, $id)
    {
        $personalMedico = PersonalMedico::find($id);

        if (!$personalMedico) {
            return response()->json(['message' => 'Personal médico no encontrado'], 404);
        }

        // Validar la solicitud
        $validator = Validator::make($request->all(), [

            'nombre' => 'required',
            'apellido' => 'required',
            'especialidad' => 'required',
            'horario' => 'required',

        ]);

        // Verificar si la validación falla
        if ($validator->fails()) {
            return response()->json([
                'msg' => 'Se produjo un error en las validaciones de la información',
                'statuscode' => 422,
                'errors' => $validator->errors()
            ], 422);
        }



        $personalMedico->nombre = $request->nombre;
        $personalMedico->apellido = $request->apellido;
        $personalMedico->especialidad = $request->especialidad;
        $personalMedico->horario = $request->horario;
        $personalMedico->save();

        return response()->json(['personalmedico' => $personalMedico]);
    }

    public function destroy($id)
    {
        $personalMedico = PersonalMedico::find($id);

        if (!$personalMedico) {
            return response()->json(['message' => 'Personal médico no encontrado'], 404);
        }

        $personalMedico->delete();

        return response()->json(['message' => 'Personal médico eliminado correctamente']);
    }
}
