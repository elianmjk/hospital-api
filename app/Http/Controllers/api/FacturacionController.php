<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Factura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Facturacion;

class FacturacionController extends Controller
{
    public function index()
    {
        $facturaciones = DB::table('facturacion')
        ->join('pacientes', 'facturacion.paciente_id', '=', 'pacientes.id')
        ->join('tratamientos', 'facturacion.tratamiento_id', '=', 'tratamientos.id')
        ->select('facturacion.*', 'pacientes.nombre as paciente_nombre', 'tratamientos.nombre as tratamiento_nombre')
        ->get();

        return response()->json(['facturaciones' => $facturaciones]);
    }

    public function store(Request $request)
    {
        // Validar la solicitud
        $validator = Validator::make($request->all(), [
            'paciente_id' => 'required|integer|exists:pacientes,id',
            'tratamiento_id' => 'required|integer|exists:tratamientos,id',
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

       
        $facturacion = new Factura();
        $facturacion->paciente_id = $request->paciente_id;
        $facturacion->tratamiento_id = $request->tratamiento_id;
        $facturacion->fecha_facturacion = $request->fecha_facturacion;
        $facturacion->total = $request->total;
        $facturacion->estado = $request->estado;
        $facturacion->save();

        return response()->json(['facturacion' => $facturacion], 201);
    }

    public function show($id)
    {
        $facturacion = Factura::find($id);

        if (!$facturacion) {
            return response()->json(['message' => 'Facturación no encontrada'], 404);
        }

        return response()->json(['facturacion' => $facturacion]);
    }

    public function update(Request $request, $id)
    {
        $facturacion = Factura::find($id);

        if (!$facturacion) {
            return response()->json(['message' => 'Facturación no encontrada'], 404);
        }

        // Validar la solicitud
        $validator = Validator::make($request->all(), [
            'paciente_id' => 'integer|exists:pacientes,id',
            'tratamiento_id' => 'integer|exists:tratamientos,id',
            'fecha_facturacion' => 'date',
            'total' => 'numeric|min:0',
            'estado' => 'in:pendiente,pagada',
        ]);

        // Verificar si la validación falla
        if ($validator->fails()) {
            return response()->json([
                'msg' => 'Se produjo un error en las validaciones de la información',
                'statuscode' => 422,
                'errors' => $validator->errors()
            ], 422);
        }

     
        $facturacion = new Factura();
        $facturacion->paciente_id = $request->paciente_id;
        $facturacion->tratamiento_id = $request->tratamiento_id;
        $facturacion->fecha_facturacion = $request->fecha_facturacion;
        $facturacion->total = $request->total;
        $facturacion->estado = $request->estado;
        $facturacion->save();

        return response()->json(['facturacion' => $facturacion]);
    }

    public function destroy($id)
    {
        $facturacion = Factura::find($id);

        if (!$facturacion) {
            return response()->json(['message' => 'Facturación no encontrada'], 404);
        }

        $facturacion->delete();

        return response()->json(['message' => 'Facturación eliminada correctamente']);
    }
}
