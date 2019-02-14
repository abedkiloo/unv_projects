<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function store(Request $request)
    {

        $this->validate($request, [
            'names' => 'required|string|max:191',
            'user_email' => 'required|email|unique:users,email',
            'user_password' => 'required|string|min:6'
        ]);
        $user = $request->all();
        if (User::where('email', $user['user_email'])->exists()) {
            return $request;
        } else {
            $new_user = new User();
            $new_user->name = $user['names'];
            $new_user->email = $user['user_email'];
            $new_user->type = $user['type'];
            $new_user->password = Hash::make($user['user_password']);
            $new_user->bio = $user['bio'];
            $new_user->save();
            return "saved";
        }

    }

}
