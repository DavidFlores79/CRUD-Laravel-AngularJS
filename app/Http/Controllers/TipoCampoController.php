<?php

namespace App\Http\Controllers;

use App\Models\TipoCampo;
use Illuminate\Http\Request;

class TipoCampoController extends Controller
{
    //
    public function index()
    {
        return view('admin.tipo-campos.index');
    }

    function getTipoCampos()
    {
        // return "Hola mundo!";
        $tipo_campos = TipoCampo::all();
        
        if(is_object($tipo_campos)){
            $data = [
                'code' => 200,
                'status' => 'success',
                'tipo_campos' => $tipo_campos,
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
        ];
        $this->validate($request, $rules);

        try {
            $tipo_campo = new TipoCampo();
            $tipo_campo->nombre = $request->input('nombre');
            $tipo_campo->save();
    
            if(is_object($tipo_campo)) {
                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Usuario creado satisfactoriamente',
                    'tipo_campo' => $tipo_campo,
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
        ];
        $this->validate($request, $rules);
        
        if($request->input('id'))
            $tipo_campo = TipoCampo::where('id',$request->input('id'))->first();

        try {
            if(is_object($tipo_campo)) {
            
                $tipo_campo->nombre = $request->input('nombre');
                $tipo_campo->save();
                
                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Categoría editada.',
                    'tipo_campo' => $tipo_campo,
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
        $tipo_campo = TipoCampo::where('id',$id)->first();

        if(is_object($tipo_campo)) {
            $tipo_campo->delete();
            $data = [
                'code' => 200,
                'status' => 'success',
                'message' => 'Categoría eliminada satisfactoriamente',
                'tipo_campo' => $tipo_campo,
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
