<?php

namespace App\Http\Controllers\API\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UserRegistrationRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(UserRegistrationRequest $request)
    {
        //Etracting validated user detail from custom request
        $data = $request->validated();

        //Creating user to db using instance of User
        // $user = new User();
        // $user->name = $data['name'];
        // $user->mobile = $data['mobile'];
        // $user->email = $data['email'];
        // $user->password = Hash::make($data['password']);
        // $user->save();

        //Creating user using static method
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);

        //Generate t$oken for the user created
        $token = $user->createToken('user_token')->plainTextToken;

        return response()->json(['message' => "Account created successfully", "user" => $user, 'token' => $token], 201);
    }
}
