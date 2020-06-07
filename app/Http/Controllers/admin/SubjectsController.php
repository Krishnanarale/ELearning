<?php

namespace App\Http\Controllers\admin;
use App\Subjects;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubjectsController extends Controller
{
    
    public function allSubjects(){
    	$result = Subjects::join('courses', 'courses.id', '=', 'subjects.course')
    			->join('levels', 'courses.level', '=', 'levels.id')
    			->select('courses.course as course_name', 'levels.level as level_name', 'subjects.*')
    			->where('subjects.status', '1')
    			->get();
        if($result){
            return $this->responser('success', 'Subjects found', $result);
        }else{
            return $this->responser('failed', 'Subjects not found', '');
        }
    }


    public function addSubject(Request $request){

	         $validator = Validator::make($request->all(), [
	            'level' => 'required|integer',
	            'course' => 'required|integer',
	            'subject' => 'required|unique:subjects|max:20',
	            'description' => 'required|string|max:255',
	            'thumbnail' => 'required|mimes:jpeg,bmp,png'
	        ]);

	        if ($validator->fails()) {
	            return $this->responser('error', 'validation error', $validator->errors());
	        }


	        if($request->file('thumbnail')){
	            $file = $request->file('thumbnail');
	            $destinationPath = 'uploads/subjects/';
	            $fileName = $file->getClientOriginalName();

	            if(!$file->move($destinationPath,$file->getClientOriginalName())){
	                return $this->responser('error', 'failed to upload file', '');
	            }
	        }else{
	                $fileName = 'default.png';
	        }


	        $subjectData = array(
	            'level' => $request->input('level'),
	            'course' => $request->input('course'),
	            'subject' => $request->input('subject'),
	            'description' => $request->input('description'),
	            'thumbnail' =>  $fileName,
	        );
	        
	        $result = Subjects::create($subjectData);

	        if($result){
	            return $this->responser('success', 'Subject added', '');
	        }else{
	            return $this->responser('failed', 'Failed to add subject', '');
	        }
	    }

	    public function editSubject(Request $request, $id){
	        $validator = Validator::make($request->all(), [
	            'level' => 'required|integer',
	            'course' => 'required|integer',
	            'subject' => 'required|string|max:20',
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
	            $destinationPath = 'uploads/subjects/';

	            $fileData = Subjects::where('id', $id)
						            ->where('subjects.status', '1')
					    			->where('subjects.deleted', '0')
					    			->select('thumbnail')
					    			->first();
	            
	            $previousfileName = $fileData['thumbnail'];
	            
	            if(!$file->move($destinationPath, $file->getClientOriginalName())){
	                return $this->responser('error', 'Failed to move file', '');
	            }
	            
	            Storage::delete((public_path('uploads/subjects/'.$previousfileName.'')));
	            $filename = $file->getClientOriginalName();

	            $subjectData = array(
	                'level' => $request->input('level'),
	                'course' => $request->input('course'),
	                'subject' => $request->input('subject'),
	                'description' => $request->input('description'),
	                'thumbnail' =>  $filename,
	            );
	        }else{
	            $subjectData = array(
	                'level' => $request->input('level'),
	                'subject' => $request->input('subject'),
	                'course' => $request->input('course'),
	                'description' => $request->input('description'),
	            );
	        }

	        $result = Subjects::find($id);

	        if($result){
	        	$result->update($subjectData);
	        	$result->save();
	        	if($result){
	            	return $this->responser('success', 'Subject updated', '');
	        	}else{
	            	return $this->responser('failed', 'Failed to update subject', '');
	        	}
	        }else{
	            return $this->responser('failed', 'Failed to update subject', '');
	        }
	    }


	        public function getSubject($subject){
		        $result = Subjects::join('courses', 'courses.id', '=', 'subjects.course')
    			->join('levels', 'courses.level', '=', 'levels.id')
    			->select(
    				'courses.course as course_name',
    				'levels.level as level_name',
    				'levels.id as level_id',
    				'subjects.*'
    			)
    			->where('subjects.id', $subject)
    			->where('subjects.status', '1')
    			->first();

		        if($result){
		            return $this->responser('success', 'Subject found', $result);
		        }else{
		            return $this->responser('failed', 'Subject not found', '');
		        }
		    }

		    public function subjectsByCourse($course){
		        $result = Subjects::join('courses', 'courses.id', '=', 'subjects.course')
    			->join('levels', 'courses.level', '=', 'levels.id')
    			->select(
    				'courses.course as course_name',
    				'levels.level as level_name', 
    				'levels.id as level_id', 
    				'subjects.*')
    			->where('subjects.course', $course)
    			->where('subjects.status', '1')
    			->get();

		        if($result){
		            return $this->responser('success', 'Subjects found', $result);
		        }else{
		            return $this->responser('failed', 'Subjects not found', '');
		        }
		    }

		    public function deleteSubject($id){
		        // $fileData = Subjects::where('id', $id)->select('thumbnail')->first();
		        // $fileName = $fileData['thumbnail'];

		        // if(file_exists(public_path('uploads/subjects/'.$fileName.''))){
		        //     Storage::delete((public_path('uploads/subjects/'.$fileName.'')));
		        // }
		        
		        $result = Subjects::find($id)->delete();
		        if($result){
		            return $this->responser('success', 'Subject Deleted Successfully', '');
		        }else{
		            return $this->responser('failed', 'Subject to delete level', '');
		        }
		   }
}
