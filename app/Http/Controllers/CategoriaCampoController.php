<?php

namespace App\Http\Controllers;

use App\Models\CategoriaCampo;
use Illuminate\Http\Request;

class CategoriaCampoController extends Controller
{
    //
        public function index()
    {
        return view('admin.categoria-campos.index');
    }

    function getCategoriaCampos()
    {
        // return "Hola mundo!";
        $categoria_campos = CategoriaCampo::all();
        
        if(is_object($categoria_campos)){
            $data = [
                'code' => 200,
                'status' => 'success',
                'categoria_campos' => $categoria_campos,
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
            $categoria_campo = new CategoriaCampo();
            $categoria_campo->nombre = $request->input('nombre');
            $categoria_campo->save();
    
            if(is_object($categoria_campo)) {
                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Usuario creado satisfactoriamente',
                    'categoria_campo' => $categoria_campo,
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
        if($request->input('id'))
            $categoria_campo = CategoriaCampo::where('id',$request->input('id'))->first();

        try {
            if(is_object($categoria_campo)) {
            
                $categoria_campo->nombre = $request->input('nombre');
                $categoria_campo->save();
                
                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Categoría editada.',
                    'categoria_campo' => $categoria_campo,
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
        $categoria_campo = CategoriaCampo::where('id',$id)->first();

        if(is_object($categoria_campo)) {
            $categoria_campo->delete();
            $data = [
                'code' => 200,
                'status' => 'success',
                'message' => 'Categoría eliminada satisfactoriamente',
                'categoria_campo' => $categoria_campo,
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
