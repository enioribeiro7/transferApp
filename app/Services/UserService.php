<?php

namespace App\Services;

use App\User;

class UserService {

    
/*     public function __construct() {
        return "construct function was initialized.";
    } */

    public function getAllUsers() {
        
        $users = User::All();

        $students = User::get()->toJson(JSON_PRETTY_PRINT);

        return response($students, 200);
    }


    public function createNewUser(){

       /*  $user = new User;
        $user->name = $request->name;
        $user->course = $request->course;
        $user->save(); */
    }
}