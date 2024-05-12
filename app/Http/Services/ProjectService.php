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

    public function getProjects($perPage = null, $params = null){
        if (empty($perPage)){
            $projects = Project::with(['image','user'])->latest("id")->get();
        } else {

            if (!empty($params->perPage)){
                $perPage = $params->perPage;
            }

            $projects = Project::with(['image','user'])

                                ->when($params->searchKey, function ($q) use ($params){
                                    $q->where('name','LIKE', "%$params->searchKey%");
                                })
                                ->when($params->field, function ($q) use ($params){
                                    $q->orderBy("$params->field", "$params->direction");
                                })
                                ->when($params->status || $params->status == 0, function ($q) use ($params){
                                    if ($params->status !== null){
                                        $q->where("status", "$params->status");
                                    }
                                })
//                                ->when($params->status || $params->status == 0, function ($q) use ($params){
//                                    $q->where("status", "$params->status");
//                                })
                                ->latest("id")
                                ->paginate($perPage)
                                ->withQueryString();
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
            if (!empty($image)){
                delOldImage($project->id, Config::projectImgPath, Config::projectImgType);
                $image->delete();
            }
            DB::commit();
        } catch (\Throwable $e){
            DB::rollBack();
            return $e->getMessage();
        }

    }
}
