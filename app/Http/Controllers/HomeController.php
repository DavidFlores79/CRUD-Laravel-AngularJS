<?php

namespace App\Http\Controllers;

use App\Models\Campo;
use App\Models\TipoFormulario;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    function getUsuarios()
    {
        $users = User::all();
        
        if(is_object($users)){
            $data = [
                'code' => 200,
                'status' => 'success',
                'users' => $users,
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email|min:3',
            'password' => 'required|string|min:8', // |confirmed
            'direccion' => 'string|nullable|max:255',
            'edad' => 'integer|nullable|max:255',
        ];
        $this->validate($request, $rules);

        try {
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            if($request->input('direccion')) $user->direccion = $request->input('direccion');
            if($request->input('edad')) $user->edad = $request->input('edad');
            $user->save();
    
            if(is_object($user)) {
                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Usuario creado satisfactoriamente',
                    'user' => $user,
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
            'name' => 'required|string|max:255',
            'id' => 'required|exists:users,id',
            'email' => 'required|string|min:3|unique:users,email,'.$request->input('id'),
            'password' => 'string|nullable|min:8', // |confirmed
            'direccion' => 'string|nullable|max:255',
            'edad' => 'integer|nullable|max:255',
        ];
        $this->validate($request, $rules);

        if($request->input('id'))
            $user = User::where('id',$request->input('id'))->first();

        try {
            if(is_object($user)) {
            
                $user->name = $request->input('name');
                $user->email = $request->input('email');
                $user->direccion = $request->input('direccion');
                $user->edad = $request->input('edad');
                $user->save();
                
                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Usuario editado.',
                    'user' => $user,
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
        $user = User::where('id',$id)->first();

        if(is_object($user) && ($user->id != auth()->user()->id )) {
            $user->delete();
            $data = [
                'code' => 200,
                'status' => 'success',
                'message' => 'Usuario eliminado satisfactoriamente',
                'user' => $user,
            ];
        } else {
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => 'No se encontró el usuario.',
            ];
        }
        return response()->json($data, $data['code']);
    }
}
