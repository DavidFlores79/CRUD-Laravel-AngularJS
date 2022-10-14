<?php

namespace App\Http\Controllers;

use App\Models\Campo;
use App\Models\CategoriaCampo;
use App\Models\TipoCampo;
use Illuminate\Http\Request;

class CampoController extends Controller
{
    //
        public function index()
    {
        return view('admin.campos_formularios.index');
    }

    function getCampos()
    {
        // return "Hola mundo!";
        $campos_formularios = Campo::with('categoria','tipo_campo')->get();
        $formularios = CategoriaCampo::all();
        $tipos_campo = TipoCampo::all();

        
        if(is_object($campos_formularios)){
            $data = [
                'code' => 200,
                'status' => 'success',
                'campos_formularios' => $campos_formularios,
                'formularios' => $formularios,
                'tipos_campo' => $tipos_campo,    
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
            'etiqueta' => 'required|string|max:255',
            'formulario' => 'required|string|max:255',
            'tipo_campo' => 'required|string|exists:tipo_campos,nombre|max:255',
            'requerido' => 'boolean',
            'sololectura' => 'boolean',
            'minlength' => 'integer|max:255',
            'min' => 'integer|max:255',
        ];
        $this->validate($request, $rules);
        //return $request;
        try {
            $campos_formulario = new Campo();
            $campos_formulario->nombre = $request->input('nombre');
            $campos_formulario->etiqueta = $request->input('etiqueta');
            $campos_formulario->categoria_id = $request->input('formulario');
            $campos_formulario->tipo_campo_id = TipoCampo::where('nombre', $request->input('tipo_campo'))->pluck('id')->firstOrFail();
            if($request->input('requerido')) $campos_formulario->requerido = $request->input('requerido');
            if($request->input('sololectura')) $campos_formulario->sololectura = $request->input('sololectura');
            if($request->input('minlength')) $campos_formulario->minlength = $request->input('minlength');
            if($request->input('min')) $campos_formulario->min = $request->input('min');
            //return $campos_formulario;

            $campos_formulario->save();
            $campos_formulario = $campos_formulario->load('categoria','tipo_campo');
    
            if(is_object($campos_formulario)) {
                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Usuario creado satisfactoriamente',
                    'campos_formulario' => $campos_formulario,
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
        $data = [
            'code' => 200,
            'status' => 'success',
        ];
        return response()->json($data, $data['code']);
    }

    public function update(Request $request)
    {
        // return $request;
        //falta validar request
        $rules = [
            'nombre' => 'required|string|max:255',
            'etiqueta' => 'required|string|max:255',
        ];
        $this->validate($request, $rules);

        if($request->input('id'))
            $campos_formulario = Campo::where('id',$request->input('id'))->first();

        try {
            if(is_object($campos_formulario)) {
            
                $campos_formulario->nombre = $request->input('nombre');
                $campos_formulario->etiqueta = $request->input('etiqueta');
                $campos_formulario->tipo_campo_id = $request->input('tipo_campo_id');
                $campos_formulario->categoria_id = $request->input('categoria_id');
                $campos_formulario->save();
                $campos_formulario = $campos_formulario->load('categoria','tipo_campo');
                
                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Categoría editada.',
                    'campos_formulario' => $campos_formulario,
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
        $campos_formulario = Campo::where('id',$id)->first();

        if(is_object($campos_formulario)) {
            $campos_formulario->delete();
            $data = [
                'code' => 200,
                'status' => 'success',
                'message' => 'Categoría eliminada satisfactoriamente',
                'campos_formulario' => $campos_formulario,
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
}
