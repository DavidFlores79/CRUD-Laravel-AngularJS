<?php

namespace App\Http\Controllers;

use App\Models\Campo;
use App\Models\TipoCampo;
use App\Models\TipoFormulario;
use App\Models\User;
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
        //return Schema::getColumnListing('users');
        // return "Hola mundo!";
        $campos_formularios = Campo::with('tipo_formulario','tipo_campo')->get();
        $formularios = TipoFormulario::all();
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
    {   //return $request;
        $rules = [
            'nombre' => 'required|string|max:255',
            'etiqueta' => 'required|string|max:255',
            'formulario' => 'required|exists:tipo_formularios,id',
            'tipo_campo' => 'required|exists:tipo_campos,id',
            'requerido' => 'boolean',
            'sololectura' => 'boolean',
            'minlength' => 'integer|max:255',
            'min' => 'integer|max:255',
            'ng_options_array' => 'nullable|string|max:255',
            'ng_options_item' => 'nullable|string|max:255',
        ];
        $this->validate($request, $rules);

        try {
            $campos_formulario = new Campo();
            $campos_formulario->nombre = $request->input('nombre');
            $campos_formulario->etiqueta = $request->input('etiqueta');
            $campos_formulario->tipo_formulario_id = $request->input('formulario');
            $campos_formulario->tipo_campo_id = $request->input('tipo_campo');
            ($request->input('requerido')) ? $campos_formulario->requerido = true : $campos_formulario->requerido = false;
            ($request->input('sololectura')) ? $campos_formulario->sololectura = true : $campos_formulario->sololectura = false;
            ($request->input('minlength')) ? $campos_formulario->minlength = $request->input('minlength') : null;
            ($request->input('min')) ? $campos_formulario->min = $request->input('min') : null;
            if ($request->input('ng_options')) {
                $campos_formulario->ng_options = "dato.id as dato.nombre disable when dato.estatus == 0 for dato in ".$request->input('ng_options');
            }
            //return $campos_formulario;
            //color.id as color.nombre disable when color.shade == 'dark' for color in colores
            $campos_formulario->save();
            $campos_formulario = $campos_formulario->load('tipo_formulario','tipo_campo');
    
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
        //return $request;
        //falta validar request
        $rules = [
            'nombre' => 'required|string|max:255',
            'etiqueta' => 'required|string|max:255',
        ];
        $this->validate($request, $rules);

        if($request->input('id'))
            $campos_formulario = Campo::where('id',$request->input('id'))->first();
        //return $campos_formulario;
        
        //return $request;
        try {
            if(is_object($campos_formulario)) {
            
                $campos_formulario->nombre = $request->input('nombre');
                $campos_formulario->etiqueta = $request->input('etiqueta');
                $campos_formulario->tipo_formulario_id = $request->input('tipo_formulario_id');
                $campos_formulario->tipo_campo_id = $request->input('tipo_campo_id');
                ($request->input('requerido')) ? $campos_formulario->requerido = true : $campos_formulario->requerido = false;
                ($request->input('sololectura')) ? $campos_formulario->sololectura = true : $campos_formulario->sololectura = false;
                ($request->input('minlength')) ? $campos_formulario->minlength = $request->input('minlength') : null;
                ($request->input('min')) ? $campos_formulario->min = $request->input('min') : null;
                ($request->input('ng_options')) ? $campos_formulario->ng_options = $request->input('ng_options') : null;
    
                $campos_formulario->save();
                $campos_formulario = $campos_formulario->load('tipo_formulario','tipo_campo');
                
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
