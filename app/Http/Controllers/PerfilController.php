<?php

namespace App\Http\Controllers;

use App\Models\Campo;
use App\Models\Perfil;
use App\Models\TipoFormulario;
use App\Traits\FormularioTrait;
use Illuminate\Http\Request;

class PerfilController extends Controller
{
    use FormularioTrait;
        /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.perfiles.index');
    }

    function getPerfiles()
    {
        $perfiles = Perfil::all();
        
        if(is_object($perfiles)){
            $data = [
                'code' => 200,
                'status' => 'success',
                'datos' => $perfiles,
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

    public function create(Request $request)
    {
        //validar el request
        $rules = [
            'formulario_crear' => 'required|string|exists:tipo_formularios,nombre',
        ];
        $this->validate($request, $rules);
        
        $campos = Campo::where('tipo_formulario_id', TipoFormulario::where('nombre', $request->input('formulario_crear'))->pluck('id')->first())->get();
        $campos = $campos->load('tipo_formulario', 'tipo_campo');

        $data = [
            'code' => 200,
            'status' => 'success',
            'formulario_crear' => $campos,
        ];
        return response()->json($data, $data['code']);
    }

    public function store(Request $request) 
    {
        //return $request;
        
        $rules = [
            'nombre' => 'required|string|max:255',
            'visible' => 'nullable|boolean',
            'estatus' => 'nullable|boolean',
        ];
        $this->validate($request, $rules);

        try {
            $perfil = new Perfil();
            $perfil->nombre = $request->input('nombre');
            if ($request->input('visible')) $perfil->visible = $request->input('visible');
            if ($request->input('status')) $perfil->status = $request->input('status');
            $perfil->save();
    
            if(is_object($perfil)) {
                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Perfil creado satisfactoriamente',
                    'dato' => $perfil,
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

    public function edit(Request $request)
    {
        //validar el request
        $rules = [
            'formulario_editar' => 'required|string|exists:tipo_formularios,nombre',
        ];
        $this->validate($request, $rules);

        $campos = Campo::where('tipo_formulario_id', TipoFormulario::where('nombre', $request->input('formulario_editar'))->pluck('id')->first())->get();
        $campos = $campos->load('tipo_formulario', 'tipo_campo');

        $data = [
            'code' => 200,
            'status' => 'success',
            'formulario_editar' => $campos,
        ];
        return response()->json($data, $data['code']);
    }

    public function update(Request $request)
    {
        //return $request;
        //validar request
        $rules = [
            'nombre' => 'string|max:255',
            'id' => 'exists:perfiles,id',
        ];
        $this->validate($request, $rules);

        if($request->input('id'))
            $perfil = Perfil::where('id',$request->input('id'))->first();

        try {
            if(is_object($perfil)) {
            
                if ($request->input('nombre')) $perfil->nombre = $request->input('nombre');
                if ($request->input('visible')) $perfil->visible = $request->input('visible');
                if ($request->input('status')) $perfil->status = $request->input('status');    
                $perfil->save();
                
                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Perfil editado.',
                    'dato' => $perfil,
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
        $perfil = Perfil::where('id',$id)->first();

        if(is_object($perfil)) {
            $perfil->delete();
            $data = [
                'code' => 200,
                'status' => 'success',
                'message' => 'Perfil eliminado satisfactoriamente',
                'perfil' => $perfil,
            ];
        } else {
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => 'No se encontró el Perfil.',
            ];
        }
        return response()->json($data, $data['code']);
    }

}
