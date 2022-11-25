<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class projectController extends baseController
{
    # CREATE PROJECT 
    public function createProject(Request $request)
    {
        # VALIDATION
        $validator = validator::make($request->all(),[
            'name' => 'required',
            'description' => 'required',
            'duration' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Error Validtion.',$validator->errors());
        }

        $studentId = $this->studentId();

        project::create(array_merge($request->all(),['studentId' => $studentId]));

        return $this->sendResponse('',"project created successfully.");
    }

    # LIST PROJECT 
    public function listProject()
    {
        // get user id
        $studentId = $this->studentId();

        // get user projects
        $projects = project::where('studentId',$studentId)->get();

        // send response
        return $this->sendResponse($projects,"List of Projects for user $studentId");

    }

    # GET SINGLE PROJECT
    public function singleProject($id)
    {
        // CHEKC THIS STUDENT HAVE THIS PROJECT OR NOT ? 
        $studentId = $this->studentId();
        $studentProjects = project::where('studentId',$studentId)->get();
        $studentProjectCount = $studentProjects->count();
        
        if ($studentProjects) {
            // RETURN PROJECT
            return $this->sendResponse($studentProjects,"Student number $studentId has $studentProjectCount Projects");
        }else {
            // NOT FOUNT
            return $this->sendError("Student $studentId hasn't project yet.");
        }
    }

    # DELETE PROJECT  
    public function deleteProject($id)
    {   
        // CHEKC PROJECT EXISTS
        $studentId = $this->studentId();
        $studentProject = project::where('studentId',$studentId)->where('id',$id)->get()->toArray();
        if ($studentProject) {
            // DELETE IT
            project::where('id',$id)->delete();
            return $this->sendResponse('',"Project Deleted successfully.");
        }else {
            // NOT FOUNT
            return $this->sendError("Project not found");
        }
    }
}
