<?php

namespace App\Http\Services;

use App\Config\Config;
use App\Models\CoreImage;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProjectService
{
    protected $imageService, $imgType, $folderName, $imgPath;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
        $this->imgType = "project_logo";
        $this->folderName = "project";
        $this->imgPath = '/public/img/project/';
    }

    public function getProjects($perPage = null){
        if (empty($perPage)){
            $projects = Project::with(['image'])->latest("id")->get();
        } else {
            $projects = Project::with(['image'])->latest("id")->paginate($perPage);
        }
        return $projects;
    }

    public function store($request){

        DB::beginTransaction();
        try {

            $project = new Project();
            $project->name = $request->name;
            $project->status = $request->status;
            $project->added_user_id = Auth::id();
            $project->save();

            $file = $request->file('coverImg');

            // save file in local
            $newFileName = saveImgInLocal($file, $this->folderName);

            // save file in db
            $this->imageService->store($project->id,$this->imgType, $newFileName, $file);
            DB::commit();
        }catch (\Throwable $e){
            $file = $request->file('coverImg');
            $newFileName = uniqid()."_project.".$file->getClientOriginalExtension();
            Storage::delete('public/img/project/'.$newFileName);
            DB::rollBack();
            return $e->getMessage();
        }


    }

    public function update($request, $project){

        DB::beginTransaction();
        try {

            $project->name = $request->name;
            $project->status = $request->status;
            $project->added_user_id = Auth::id();
            $project->update();

            if (!empty($request->coverImg)){
                // del old image
                delOldImage($project->id, $this->imgPath, $this->imgType);

                $file = $request->file('coverImg');

                // save file in local
                $newFileName = saveImgInLocal($file, $this->folderName);

                // get old image from db
                $image = $this->imageService->getOldImage($project->id, $this->imgType);

                // save file in db
                $this->imageService->update($image, $project->id, $this->imgType, $newFileName, $file);

            }

            DB::commit();
        }catch (\Throwable $e){
            $file = $request->file('coverImg');
//            Storage::delete('public/img/project/'.$newFileName);
            DB::rollBack();
            return $e->getMessage();
        }


    }

    public function getProject($project){
        $project = Project::where('id',$project->id)->with(['image'])->first();
        return $project;
    }

    public function delete($project){
        DB::beginTransaction();

        try {
            $project->delete();

            $image = $this->imageService->getOldImage($project->id, Config::projectImgType);

            delOldImage($project->id, Config::projectImgPath, Config::projectImgType);
            $image->delete();
            DB::commit();
        } catch (\Throwable $e){
            DB::rollBack();
            return $e->getMessage();
        }

    }
}
