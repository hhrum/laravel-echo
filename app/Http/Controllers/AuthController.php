<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    /// Регистрация
    public function signup(Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email:rfc', 'unique:users'],
            'password' => ['required', 'min:6']
        ]);

        if ($validator->fails()) {
            return response()->json($this->generateResponseData('error', [
                'InvalidFormError' => $validator->failed()
            ]), 401);
        }

        $user = new User;

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;

        $user->save();

        return response()->json($this->generateResponseData('tokel' ,['token' => $user->createToken('user')->plainTextToken]), 200);
    }

    /// Авторизация
    public function signin(Request $request) {

        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email:rfc'],
            'password' => ['required', 'min:6']
        ]);

        if ($validator->fails()) {
            return response()->json($this->generateResponseData('error', [
                'InvalidFormError' => $validator->failed()
            ]), 401);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || Hash::check($user->password, $request->password)){
            return response()
                ->json($this->generateResponseData('error', [
                    'errors' => 'Неправильный логин или пароль'
                ]), 401);
        }

        return response()->json($this->generateResponseData('token' ,['token' => $user->createToken('user')->plainTextToken]), 200);
    }

    public function signout(Request $request) {
        $user = $request->user();
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();

        return response()->json($this->generateResponseData('signout', []), 200);
    }

    private  function generateResponseData($type, $data) {
        return [
            'type' => $type,
            'data' => $data
        ];
    }
}
