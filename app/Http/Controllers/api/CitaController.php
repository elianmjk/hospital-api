<?php

namespace App\Http\Controllers\api;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Cita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator ;

class CitaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $citas = DB::table('citas')
        ->join('pacientes', 'citas.paciente_id', '=', 'pacientes.id')
        ->join('personal_medico', 'citas.medico_id', '=', 'personal_medico.id') // Asegúrate de usar `medico_id`
        ->select('citas.*', 'pacientes.nombre as paciente_nombre', 'personal_medico.nombre as personal_medico_nombre')
        ->get();

        return response()->json(['citas' => $citas]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

       // Validar la solicitud manualmente
       $validator = Validator::make($request->all(), [
        'paciente_id' => 'required|integer|exists:pacientes,id',
        'medico_id' => 'required|integer|exists:personal_medico,id',
        'tipo' => 'required|in:consulta,revision,urgencia',
        'estado' => 'required|in:programada,completada,cancelada',
        'fecha_hora' => 'required|date_format:Y-m-d H:i:s',
    ]);

    // Verificar si la validación falla
    if ($validator->fails()) {
        return response()->json([
            'msg' => 'Se produjo un error en las validaciones de la información',
            'statuscode' => 422, // Usualmente 422 Unprocessable Entity para errores de validación
            'errors' => $validator->errors()
        ], 422);
    }

         // Crear la nueva cita
         $cita = Cita::create([
            'paciente_id' => $request->paciente_id,
            'medico_id' => $request->medico_id,
            'tipo' => $request->tipo,
            'estado' => $request->estado,
            'fecha_hora' => $request->fecha_hora,
        ]);

        return response()->json(['cita' => $cita], 201);
    }

    /**
     * Display the specified resource.
     */
    
    /**
     * Update the specified resource in storage.
     
     */

     public function show(string $id)
    {
         // Validar la solicitud
         $validator = Validator::make(['id' => $id], [
            'id' => 'exists:citas,id',
        ]);

        // Verificar si la validación falla
        if ($validator->fails()) {
            return response()->json([
                'msg' => 'Se produjo un error en las validaciones de la información',
                'statuscode' => 422, // Usualmente 422 Unprocessable Entity para errores de validación
                'errors' => $validator->errors()
            ], 422);
        }

        // Buscar la cita
        $cita = Cita::find($id);

        if (!$cita) {
            return response()->json(['message' => 'Cita no encontrada'], 404);
        }

        return response()->json(['cita' => $cita]);
    }
    

    public function update(Request $request, string $id)
    {
         // Validar la solicitud
         $validate = Validator::make($request->all(), [
            'paciente_id' => 'integer|exists:pacientes,id',
            'medico_id' => 'integer|exists:personal_medico,id',
            'tipo' => 'in:consulta,revision,urgencia',
            'estado' => 'in:programada,completada,cancelada',
            'fecha_hora' => 'date_format:Y-m-d H:i:s',
        ]);

        // Verificar si la validación falla
        if ($validate->fails()) {
            return response()->json([
                'msg' => 'Se produjo un error en las validaciones de la información',
                'statuscode' => 422, // Usualmente 422 Unprocessable Entity para errores de validación
                'errors' => $validate->errors()
            ], 422);
        }

        // Buscar la cita
        $cita = Cita::find($id);

        if (!$cita) {
            return response()->json(['message' => 'Cita no encontrada'], 404);
        }

        // Actualizar la cita
        $cita->update($request->all());

        return response()->json(['cita' => $cita]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Buscar la cita
        $cita = Cita::find($id);

        // Verificar si la cita existe
        if (!$cita) {
            return response()->json(['message' => 'Cita no encontrada'], 404);
        }

        // Eliminar la cita
        $cita->delete();

        return response()->json(['message' => 'Cita eliminada correctamente']);
    }
}
