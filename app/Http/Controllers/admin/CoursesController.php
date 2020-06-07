<?php

namespace App\Http\Controllers\admin;

use App\Courses;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CoursesController extends Controller
{
	    public function addCourse(Request $request){

	         $validator = Validator::make($request->all(), [
	            'level' => 'required|integer',
	            'course' => 'required|unique:courses|max:20',
	            'description' => 'required|string|max:255',
	            'thumbnail' => 'required|mimes:jpeg,bmp,png'
	        ]);

	        if ($validator->fails()) {
	            return $this->responser('error', 'validation error', $validator->errors());
	        }


	        if($request->file('thumbnail')){
	            $file = $request->file('thumbnail');
	            $destinationPath = 'uploads/courses/';
	            $fileName = $file->getClientOriginalName();

	            if(!$file->move($destinationPath,$file->getClientOriginalName())){
	                return $this->responser('error', 'failed to upload file', '');
	            }
	        }else{
	                $fileName = 'default.png';
	        }


	        $levelData = array(
	            'level' => $request->input('level'),
	            'course' => $request->input('course'),
	            'description' => $request->input('description'),
	            'thumbnail' =>  $fileName,
	        );
	        
	        $result = Courses::create($levelData);

	        if($result){
	            return $this->responser('success', 'Course added', '');
	        }else{
	            return $this->responser('failed', 'Failed to add course', '');
	        }
	    }

	    public function editCourse(Request $request, $id){
	        $validator = Validator::make($request->all(), [
	            'level' => 'required|integer',
	            'course' => 'required|string|max:20',
	            'description' => 'string|max:255',
	        ]);

	        if ($validator->fails()) {
	            return $this->responser('error', 'validation error', $validator->errors());
	        }

	        if($request->file('thumbnail')){
	            $validator = Validator::make($request->all(), [
	                'thumbnail' => 'nullable|mimes:jpeg,bmp,png'
	            ]);

	            if ($validator->fails()) {
	                return $this->responser('error', 'validation error', $validator->errors());
	            }

	            $file = $request->file('thumbnail');
	            $destinationPath = 'uploads/courses/';

	            $fileData = Courses::where('id', $id)->select('thumbnail')->first();
	            
	            $previousfileName = $fileData['thumbnail'];
	            
	            if(!$file->move($destinationPath, $file->getClientOriginalName())){
	                return $this->responser('error', 'Failed to move file', '');
	            }
	            
	            Storage::delete((public_path('uploads/courses/'.$previousfileName.'')));
	            $filename = $file->getClientOriginalName();

	            $courseData = array(
	                'level' => $request->input('level'),
	                'course' => $request->input('course'),
	                'description' => $request->input('description'),
	                'thumbnail' =>  $filename,
	            );
	        }else{
	            $courseData = array(
	                'level' => $request->input('level'),
	                'course' => $request->input('course'),
	                'description' => $request->input('description'),
	            );
	        }
	        	        
	        $result = Courses::find($id)->update($courseData);
	        if($result){
	            	return $this->responser('success', 'Course updated', '');
	        }else{
	            return $this->responser('failed', 'Failed to update course', '');
	        }

	    }

	    public function getCourse($course){
	        $result = Courses::join('levels', 'levels.id', '=', 'courses.level')
	        	->select('levels.level','courses.*')
	        	->where('courses.id', $course)
                ->where('courses.status', '1')
	        	->first();

	        if($result){
	            return $this->responser('success', 'Course found', $result);
	        }else{
	            return $this->responser('failed', 'Course not found', '');
	        }
	    }

	    public function allCourses(Request $request){
	        $result = Courses::join('levels', 'levels.id', '=', 'courses.level')
	        				->select('levels.level as level_name', 'courses.*')
                			->where('courses.status', '1')
	        				->get();

	        if($result){
	            return $this->responser('success', 'Courses found', $result);
	        }else{
	            return $this->responser('failed', 'Courses not found', '');
	        }
	    }

	    public function deleteCourse($id){
	        // $fileData = Courses::where('id', $id)->select('thumbnail')->first();
	        // $fileName = $fileData['thumbnail'];

	        // if(file_exists(public_path('uploads/courses/'.$fileName.''))){
	        //     Storage::delete((public_path('uploads/courses/'.$fileName.'')));
	        // }
	        
	        $result = Courses::find($id)->deleted();
	        if($result){
	            return $this->responser('success', 'Course Deleted Successfully', '');
	        }else{
	            return $this->responser('failed', 'Course to delete level', '');
	        }

	   }

	   public function coursesByLevel($level){
	   		$result = Courses::join('levels', 'levels.id', '=', 'courses.level')
	   					->select('courses.*', 'levels.level as level_name')
	   					->where('courses.level', $level)
	   					->get();

	        if($result){
	            return $this->responser('success', 'Courses found', $result);
	        }else{
	            return $this->responser('failed', 'Course not found', '');
	        }
	   }
}
