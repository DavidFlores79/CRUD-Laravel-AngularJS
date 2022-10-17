<?php

namespace App\Http\Controllers;

use App\Models\TipoFormulario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TipoFormularioController extends Controller
{
    public function index()
    {        
        return view('admin.tipo_formularios.index');
    }

    function getTipoFormularios()
    {
        $tipo_formularios = TipoFormulario::all();
        $tablas = $this->getTablas();

        if(is_object($tipo_formularios)){
            $data = [
                'code' => 200,
                'status' => 'success',
                'tipo_formularios' => $tipo_formularios,
                'tablas' => $tablas,
            ];
        } else {
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'Ocurrió un error al realizar la búsqueda.',
            ];
        }
        return response()->json($data, $data['code']);
    }

    public function create()
    {
        $data = [
            'code' => 200,
            'status' => 'success',
        ];
        return response()->json($data, $data['code']);
    }

    public function store(Request $request) 
    {   
        $rules = [
            'nombre' => 'required|string|max:255',
            'tabla' => 'required|string|max:255',
        ];
        $this->validate($request, $rules);

        try {
            $tipo_formulario = new TipoFormulario();
            $tipo_formulario->nombre = $request->input('nombre');
            $tipo_formulario->tabla = $request->input('tabla');
            $tipo_formulario->save();
    
            if(is_object($tipo_formulario)) {
                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Usuario creado satisfactoriamente',
                    'tipo_formulario' => $tipo_formulario,
                ];
            }
            return response()->json($data, $data['code']);
        } catch (\Throwable $th) {
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'Se ha producido un error al guardar.'.$th,
            ];
            return response()->json($data, $data['code']);
        }

    }

    public function edit()
    {
        $tablas = $this->getTablas();

        $data = [
            'code' => 200,
            'status' => 'success',
            'tablas' => $tablas,
        ];
        return response()->json($data, $data['code']);
    }

    public function update(Request $request)
    {
        //return $request;
        //falta validar request
        $rules = [
            'id' => 'required|exists:tipo_formularios,id',
            'nombre' => 'required|string|max:255',
            'tabla' => 'required|string|max:255',
        ];
        $this->validate($request, $rules);

        if($request->input('id'))
            $tipo_formulario = TipoFormulario::where('id',$request->input('id'))->first();

        try {
            if(is_object($tipo_formulario)) {
            
                $tipo_formulario->nombre = $request->input('nombre');
                $tipo_formulario->tabla = $request->input('tabla');
                $tipo_formulario->save();
                
                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Categoría editada.',
                    'tipo_formulario' => $tipo_formulario,
                ];

                return response()->json($data, $data['code']);
            }
        } catch (\Throwable $th) {
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => 'Error al actualizar.'.$th,
            ];
            return response()->json($data, $data['code']);
        }
             
    }


    public function destroy($id)
    {
        $tipo_formulario = TipoFormulario::where('id',$id)->first();

        if(is_object($tipo_formulario)) {
            $tipo_formulario->delete();
            $data = [
                'code' => 200,
                'status' => 'success',
                'message' => 'Categoría eliminada satisfactoriamente',
                'tipo_formulario' => $tipo_formulario,
            ];
        } else {
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => 'No se encontró la categoría.',
            ];
        }
        return response()->json($data, $data['code']);
    }

    public function getTablas() {
        $all_tablas = array_map('reset', DB::select('SHOW TABLES'));
        return array_filter(array_map(function($n) { if(($n != 'migrations') && ($n != 'failed_jobs') && ($n != 'password_resets')) return $n; }, $all_tablas));
    }
}
