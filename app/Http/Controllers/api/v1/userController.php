<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class userController extends baseController
{
    // USER REGISTER - POST
    public function register(request $request)
    {
        # VALIDATION
        $validator = Validator::make($request->all(),[
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'name' => 'required',
            'phoneNumber' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Error Validtion.',$validator->errors());
        }

        # CREATE USER
        user::create([
            'email' => $request->email,
            'name' => $request->name,
            'phoneNumber' => $request->phoneNumber,
            'password' => bcrypt($request->password)
        ]);

        # SEND RESPONSE
        return $this->sendResponse('',"user created successfully.");
    }

    // USER LOGIN - POST
    public function login(request $request)
    {
        // VALIDATION
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Error Validtion.',$validator->errors());
        }

        // AUTHENTICATE USER AND MAKE TOKEN 

        if (! $token = auth()->attempt(['email'=>$request->email,'password'=>$request->password])) {
            return $this->sendError('Login Failed Check your password and email.',$validator->errors());
        } else {
            // SEND RESPONSE
            return $this->sendResponse($token,"Login successfully. Your token has been added to your account."); 
        }
    }

    // USER PROFILE - GET
    public function profile()
    {
        $user = auth()->user();

        return $this->sendResponse($user,'User Profile.');
    }

    // USER LOGOUT - GET
    public function logout()
    {
        $user = auth()->logout();
        
        return $this->sendResponse($user,'User Logged out successfully.');
    }
}
