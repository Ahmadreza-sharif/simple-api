<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class studentController extends baseController
{
    # REGISTER MTHOD
    public function register(Request $request)
    {
        # VALIDATION
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email|unique:students',
            'password' => 'required|confirmed',
            'phoneNumber' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Error Validtion.',$validator->errors());
        }

        # SAVE 
        student::create([
            'name' => $request->name,
            'email' => $request->email,
            'phoneNumber' => $request->phoneNumber,
            'password' => Hash::make($request->password)
        ]);

        # RESPONSE
        return $this->sendResponse('','User Successfully Created.');
    }

    # LOGIN METHOD
    public function login(Request $request)
    {
        # VALIDATION
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Error Validtion.',$validator->errors());
        }

        # CHECK USER AND PASSWORD
        $student = student::where('email',$request->email)->first();
        if (isset($student->id)) {
            if (Hash::check($request->password, $student->password)) {

                $token = $student->createToken("auth_token")->plainTextToken;
                $data = ['access_token' => $token];

                return $this->sendResponse($data,'User Successfully Created.');
            }else {
                return $this->sendError('Email or password is incorrect.');
            }
        }else {
            return $this->sendError('User Doesnt Exists.');
        }

        # CREATE TOKEN
    }

    # LOGOUT METHOD
    public function logout()
    {
        Auth::user()->tokens()->delete();
        return $this->sendResponse('',"Logout Successfully.");
    }

    # STUDENT PROFILE
    public function profile()
    {
        return $this->sendResponse(Auth::user(),'Student Profile.');
    }
}
