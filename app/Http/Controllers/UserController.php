<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;

class UserController extends Controller
{

    protected $UserService;

    public function __construct(UserService $UserService) {
        $this->UserService = $UserService;
    }

    public function getUsers(){

        return $this->UserService->getAllUsers();

    }

    public function insertNewUser(Request $request){

        //return json_encode($request->all());

        $dataUser = $request->validate([
            'name' => 'required|unique:users',
            'email' => 'required',
            'cpf_cnpj' => 'required',
            'user_type_uuid' => 'required',
        ]);

/*         return response()->json([
            "message" => "user record created"
        ], 201); */

    }
}