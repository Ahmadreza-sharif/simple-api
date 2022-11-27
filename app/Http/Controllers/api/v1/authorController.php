<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\author;
use Illuminate\Support\Facades\Validator;

class authorController extends baseController
{


    # REGISTER
    public function register(request $request)
    {
        # VALIDATION
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'name' => 'required',
            'phoneNumber' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Error Validtion.', $validator->errors());
        }

        # CREATE USER
        author::create([
            'email' => $request->email,
            'name' => $request->name,
            'phoneNumber' => $request->phoneNumber,
            'password' => bcrypt($request->password)
        ]);

        # SEND RESPONSE
        return $this->sendResponse('', "Author created successfully.");
    }

    # LOGIN
    public function login(Request $request)
    {
        // VALIDATION
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Error Validtion.', $validator->errors());
        }

        // AUTHENTICATE USER AND MAKE TOKEN 

        if (!$token = auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            return $this->sendError('Login Failed Check your password and email.', $validator->errors());
        } else {
            // SEND RESPONSE
            return $this->sendResponse($token, "Login successfully. Your token has been added to your account.");
        }
    }

    # LOGOUT
    public function logout()
    {
    }

    # PROFILE
    public function profile()
    {
    }
}
