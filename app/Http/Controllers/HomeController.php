<?php

namespace App\Http\Controllers;

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
        // return "Hola mundo!";
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
            'email' => 'required|string|unique:users,email|min:1',
            'name' => 'required|string|max:255',
            'password' => 'required|min:8|max:255',
        ];
        $this->validate($request, $rules);

        try {
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
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
            $user = User::where('id',$request->input('id'))->first();

        try {
            if(is_object($user)) {
            
                $user->name = $request->input('name');
                $user->email = $request->input('email');
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
