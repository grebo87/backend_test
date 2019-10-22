<?php

namespace App\Http\Controllers\Api;

use App\User;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Psr\Http\Message\ServerRequestInterface;
use \Laravel\Passport\Http\Controllers\AccessTokenController as ATC;

class AuthController extends ATC
{
    /**
     * Login Api
     *
     * @param  Psr\Http\Message\ServerRequestInterface  $request
     * @return \Illuminate\Http\Response
     */
    public function login(ServerRequestInterface $request){

        //se valida que el username y password esten presentes
        $validator = Validator::make($request->getParsedBody(), [
            'password' => 'required',
            'username' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error'   => 'Bad request',
                'message' => 'El usuario y la contraseña son requeridos'
            ],400);
        }

        //se convierte en objeto los datos enviados
        $dataRequest = (object) $request->getParsedBody();

        //array de parametros a consultar en la db para el login, por defecto se necesita el username y password
        $data = [
                	'username' => $dataRequest->username,
                    'password' => $dataRequest->password,
                ];

        //verifica si el usuario cumple con todos los parametros
        if(Auth::attempt($data)){
            //se genera el token
            $tokenResponse = parent::issueToken($request);

            //se obtienen los datos del token en cadena json
            $content = $tokenResponse->getContent();

            return response()->json(json_decode($content,true));//convertir la respuesta de cadena json a array con json_decode

        } else {
            return response()->json([
                'error'   => 'invalid_client',
                'message' => 'Client authentication failed'
            ],401);
        }
    }

    /**
     * Logout Api
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        //se obtine el usuario
        $user = $request->user('api');
        //se revoca el token
        $user->token()->revoke();

        return response()->json([
            'status'  => 'success',
            'message' => 'Successfully logged out'
        ]);
    }

    public function register(Request $request)
    {
    	$validatedData = $request->validate([
            'name'=>'required|max:55',
            'email'=>'email|required|unique:users',
            'password'=>'required',
            'username' => 'required'
        ]);

        $validatedData['password'] = bcrypt($request->password);

        $user = User::create($validatedData);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response(['user'=> $user, 'access_token'=> $accessToken]);
    }
}
