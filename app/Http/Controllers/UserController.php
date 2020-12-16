<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index(Request $request) {
        $user = $request->user();

        $user->role;

        return response()->json($this->generateResponseData('user', [
            'user' => $user
        ]), 200);
    }

    private  function generateResponseData($type, $data) {
        return [
            'type' => $type,
            'data' => $data
        ];
    }
}
