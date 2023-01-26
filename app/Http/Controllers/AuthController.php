<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function create(Request $request) {


        $array['error'] = '';

        $rules = [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ];

        $validator = FacadesValidator::make($request->all(), $rules);

        if($validator->fails()) {

            $array['error'] = $validator->messages();

            return $array;

        }

        $user = new User();
        $user->email = $request['email'];
        $user->password = password_hash($request['password'], PASSWORD_DEFAULT);
        $user->token = '';
        $user->save();

        $array['success'] = 'Criado usuário com sucesso';

        return $array;

    }

    public function login(Request $request) {

        $array['error'] = '';

        $credentials = $request->only('email', 'password');

        if(Auth::attempt($credentials)) {


        $user = User::where('email', $credentials['email'])->first();

        $tokenString = time().rand(0, 9999);

        $token = $user->createToken($tokenString)->plainTextToken;

        $array['token'] = $token;


        return $array;

        }

        $array['error'] = 'Login ou senha incorretos';

        return $array;

    }

    public function logout(Request $request) {

        $array['error'] = '';

        $user = $request->user();

        $user->tokens()->delete();

        $array['success'] = 'Usuário deslogado';

        return $array;

    }

}
