<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\employee;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isNull;

class employeeController extends Controller
{

    public function listEmployees(Request $request)
    {
        $list = employee::all();
        return response()->json([
            'status' => 1,
            'message' => 'Listing Employees',
            'data' => $list
        ],200);
    }

    public function createEmployee(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'lastName' => 'required',
            'age' => 'required|integer',
            'gender' => 'required|string',
            'city' => 'required|string',
            'email' => 'required|email|unique:employees'
        ]);

        employee::create([
            'name' => $request->name,
            'lastName' => $request->lastName,
            'age' => $request->age,
            'gender' => $request->gender,
            'city' => $request->city,
            'email' => $request->email
        ]);
        // var_dump($request);

        return response()->json([
            'status' => 200,
            'message' => 'user Created Successfully.'
        ]);
    }

    public function updateEmployee(Request $request,$id)
    {
        if (employee::where('id',$id)->exists()) {
            $record = employee::find($id);

            $record->name = !is_null($request->name) ? $request->name : $record->name;
            $record->lastName = !is_null($request->lastName) ? $request->lastName : $record->lastName;
            $record->age = !is_null($request->age) ? $request->age : $record->age;
            $record->gender = !is_null($request->gender) ? $request->gender : $record->gender;
            $record->city = !is_null($request->city) ? $request->city : $record->city;
            $record->email = !is_null($request->email) ? $request->email     : $record->email;

            $record->save();

            return response()->json([
                'status' => 1,
                'message' => 'Update Record Successfully.'
            ]);

        }else {
            return response()->json([
                'status' => 0,
                'message' => 'employee not found.',
                
            ],404);
        }
    }

    public function deleteEmployee($id)
    {
        if (employee::where('id',$id)->exists()) {
            $record = employee::where('id',$id)->delete();
            return response()->json([
                'status' => 1,
                'message' => 'Records Deleted Successfully',
            ]);
        }else {
            return response()->json([
                'status' => 0,
                'message' => 'employee not found',
                
            ],404);
        }
    }

    public function getSingleEmployee($id)
    {
        if (employee::where('id',$id)->exists()) {
            $record = employee::find($id);
            return response()->json([
                'status' => 1,
                'message' => 'Getting Records Successfully',
                'data' => $record
            ]);
        }else {
            return response()->json([
                'status' => 0,
                'message' => 'employee not found',
                
            ],404);
        }
        
    }
}
