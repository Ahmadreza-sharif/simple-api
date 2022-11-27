<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class courseController extends baseController
{
    // ADD USER TO COURSES
    public function create(request $request)
    {
        # VALIDATION
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'description' => 'required',
            'total_video' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Error Validtion.',$validator->errors());
        }

        # CREATE COURSE
        course::create([
            'user_id' => auth()->user()->id,
            'title' => $request->title,
            'description' => $request->description,
            'total_video' => $request->total_video
        ]);

        # SEND         
        return $this->sendResponse('',"Course created successfully.");
    }
    // TOTAL COURSES
    public function total() 
    {
        $user = auth()->user()->id;
        $courses = User::find($user)->courses;

        return $this->sendResponse($courses,"Courses for user $user :");
    }

    // DELETE USER FROM COURSES
    public function deleteCourse($id)
    {
        $user = auth()->user()->id;
        if (course::where(['user_id' => $user,'id'=>$id])->exists()) {
            $course = course::find($id)->delete();
            return $this->sendResponse('',"course deleted successfully.");
        } else {
            return $this->sendError('Course not founded.');
        }
        
    }
}
