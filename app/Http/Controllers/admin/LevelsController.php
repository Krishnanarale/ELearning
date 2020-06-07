<?php

namespace App\Http\Controllers\admin;

use App\Levels;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LevelsController extends Controller
{
    public function addLevel(Request $request){

         $validator = Validator::make($request->all(), [
            'level' => 'required|unique:levels|max:20',
            'description' => 'required|string|max:255',
            'thumbnail' => 'required|mimes:jpeg,bmp,png'
        ]);

        if ($validator->fails()) {
            return $this->responser('error', 'validation error', $validator->errors());
        }


        if($request->file('thumbnail')){
            $file = $request->file('thumbnail');
            $destinationPath = 'uploads/levels/';
            $fileName = $file->getClientOriginalName();

            if(!$file->move($destinationPath,$file->getClientOriginalName())){
                return $this->responser('error', 'failed to upload file', '');
            }
        }else{
                $fileName = 'default.png';
        }


        $levelData = array(
            'level' => $request->input('level'),
            'description' => $request->input('description'),
            'thumbnail' =>  $fileName,
        );
        
        $result = Levels::create($levelData);

        if($result){
            return $this->responser('success', 'Level added', '');
        }else{
            return $this->responser('failed', 'Failed to add level', '');
        }
   }

   public function editLevel(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'level' => 'string|max:20',
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
            $destinationPath = 'uploads/levels/';

            $fileData = Levels::where('id', $id)
                ->where('levels.status', '1')
                ->select('thumbnail')
                ->first();

            if(!$fileData){
                return $this->responser('error', 'File not found', '');
            }
            
            $previousfileName = $fileData['thumbnail'];
            
            if(!$file->move($destinationPath, $file->getClientOriginalName())){
                return $this->responser('error', 'Failed to move file', '');
            }
            
            if(Storage::delete((public_path('uploads/levels/'.$previousfileName.'')))) {
                $filename = $file->getClientOriginalName();
            }else{
                $filename = $file->getClientOriginalName();
            }


            $levelData = array(
                'level' => $request->input('level'),
                'description' => $request->input('description'),
                'thumbnail' =>  $filename,
            );
        }else{
            $levelData = array(
                'level' => $request->input('level'),
                'description' => $request->input('description'),
            );
        }
        
        
        $result = Levels::where('id', $id)
                ->where('status', '1')
                ->update($levelData);
        if($result){
            return $this->responser('success', 'Level updated', '');
        }else{
            return $this->responser('failed', 'Failed to update level', '');
        }

   }

   public function getLevel($id){
        $result = Levels::where('id', $id)
                ->where('status', '1')
                ->first();

        if($result){
            return $this->responser('success', 'Level found', $result);
        }else{
            return $this->responser('failed', 'Level not found', '');
        }
   }

   public function allLevel(Request $request){
        $result = Levels::all();

        if($result){
            return $this->responser('success', 'levels found', $result);
        }else{
            return $this->responser('failed', 'levels not found', '');
        }
   }

   public function deleteLevel($id){
        // $fileData = Levels::where('id', $id)->select('thumbnail')->first();
        // $fileName = $fileData['thumbnail'];

        // if(file_exists(public_path('uploads/levels/'.$fileName.''))){
        //     Storage::delete((public_path('uploads/levels/'.$fileName.'')));
        // }

        $result = Levels::find($id)->delete();
        if($result){
            return $this->responser('success', 'level Deleted Successfully', '');
        }else{
            return $this->responser('failed', 'Failed to delete level', '');
        }
        
   }
}
