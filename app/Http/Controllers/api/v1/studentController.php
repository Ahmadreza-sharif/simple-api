<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\student;
use Illuminate\Http\Request;
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
        
    }

    # LOGOUT METHOD
    public function logout()
    {
        
    }

    # STUDENT PROFILE
    public function profile()
    {
        
    }
}
