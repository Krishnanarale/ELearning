<?php

namespace App\Http\Controllers\admin;
use App\Chapters;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ChaptersController extends Controller
{
    
    public function allChapters(){
    	$result = Chapters::join('subjects', 'subjects.id', '=', 'chapters.subject')
    			->join('courses', 'courses.id', '=', 'subjects.course')
    			->join('levels', 'courses.level', '=', 'levels.id')
    			->select(
    				'courses.course as course_name',
    				'levels.level as level_name',
    				'subjects.subject as subject_name',
    				'chapters.*'
    			)
    			->where('chapters.status', '1')
                ->get();

        if($result){
            return $this->responser('success', 'Chapters found', $result);
        }else{
            return $this->responser('failed', 'Chapters not found', '');
        }
    }


    public function addChapter(Request $request){

	         $validator = Validator::make($request->all(), [
	            'level' => 'required|integer',
	            'course' => 'required|integer',
	            'subject' => 'required|integer',
	            'chapter' => 'required|unique:chapters|max:20',
	            'description' => 'required|string|max:255',
	            'thumbnail' => 'required|mimes:jpeg,bmp,png'
	        ]);

	        if ($validator->fails()) {
	            return $this->responser('error', 'validation error', $validator->errors());
	        }


	        if($request->file('thumbnail')){
	            $file = $request->file('thumbnail');
	            $destinationPath = 'uploads/chapters/';
	            $fileName = $file->getClientOriginalName();

	            if(!$file->move($destinationPath,$file->getClientOriginalName())){
	                return $this->responser('error', 'failed to upload file', '');
	            }
	        }else{
	                $fileName = 'default.png';
	        }


	        $chapterData = array(
	            'level' => $request->input('level'),
	            'course' => $request->input('course'),
	            'subject' => $request->input('subject'),
	            'chapter' => $request->input('chapter'),
	            'description' => $request->input('description'),
	            'thumbnail' =>  $fileName,
	        );
	        
	        $result = Chapters::create($chapterData);

	        if($result){
	            return $this->responser('success', 'Chapter added', '');
	        }else{
	            return $this->responser('failed', 'Failed to add Chapter', '');
	        }
	    }

	    public function editChapter(Request $request, $id){
	        $validator = Validator::make($request->all(), [
	            'course' => 'required|integer',
	            'level' => 'required|integer',
	            'subject' => 'required|integer',
	            'chapter' => 'required|string|max:20',
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
	            $destinationPath = 'uploads/chapters/';

	            $fileData = Chapters::where('id', $id)->select('thumbnail')->first();
	            
	            $previousfileName = $fileData['thumbnail'];
	            
	            if(!$file->move($destinationPath, $file->getClientOriginalName())){
	                return $this->responser('error', 'Failed to move file', '');
	            }
	            
	            Storage::delete((public_path('uploads/chapters/'.$previousfileName.'')));
	            $filename = $file->getClientOriginalName();

	            $subjectData = array(
	                'chapter' => $request->input('chapter'),
	                'subject' => $request->input('subject'),
	                'description' => $request->input('description'),
	                'thumbnail' =>  $filename,
	            );
	        }else{
	            $subjectData = array(
	                'subject' => $request->input('subject'),
	                'chapter' => $request->input('chapter'),
	                'description' => $request->input('description'),
	            );
	        }

	        $result = Chapters::find($id)->update($subjectData);

	        if($result){
	            return $this->responser('success', 'Chapters updated', '');
	        }else{
	            return $this->responser('failed', 'Failed to update chapters', '');
	        }
	    }


	        public function getChapter($id){
		        $result = Chapters::join('subjects', 'subjects.id', '=', 'chapters.subject')
		     	   ->join('courses', 'courses.id', '=', 'chapters.course')
	    			->join('levels', 'levels.id', '=', 'chapters.level')
	    			->select(
	    				'courses.id as course_id',
	    				'levels.id as level_id',
	    				'subjects.id as subject_id',
	    				'levels.level as level_name',
	    				'courses.course as course_name',
	    				'subjects.subject as subject_name',
	    				'chapters.*')
	    			->where('chapters.id', $id)
	    			->where('chapters.status', '1')
	    			->first();

		        if($result){
		            return $this->responser('success', 'Chapters found', $result);
		        }else{
		            return $this->responser('failed', 'Chapters not found', '');
		        }
		    }

		    public function deleteChapter($id){
		        // $fileData = Chapters::where('id', $id)->select('thumbnail')->first();
		        // $fileName = $fileData['thumbnail'];

		        // if(file_exists(public_path('uploads/chapters/'.$fileName.''))){
		        //     Storage::delete((public_path('uploads/chapters/'.$fileName.'')));
		        // }
		        
		        $result = Chapters::find($id)->delete();
		        if($result){
		            return $this->responser('success', 'Chapter Deleted Successfully', '');
		        }else{
		            return $this->responser('failed', 'Failed to delete chapter', '');
		        }
		   }
}
