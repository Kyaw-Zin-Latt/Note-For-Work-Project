<?php

namespace App\Imports;


use App\Models\CoreImage;
use App\Models\Project;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProjectsImport implements ToCollection, WithHeadingRow, WithValidation, SkipsOnFailure
{

    use Importable, SkipsFailures;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $projects)
    {
        foreach ($projects  as $row){
            $project = new Project();
            $project->name = $row['project_name'];
            $project->status = $row['project_status'] == 'publish' ? 1 : 0;
            $project->added_user_id = Auth::id();
            $project->save();

            $projectLogo = $row['project_logo_name'];
            if (!empty($projectLogo)){
                $file = public_path()."/storage/img/project/".$projectLogo;
                if(File::exists($file)){
                    // save original image to uploads
                    $org_img = Image::make($file);
                    $width = $org_img->width();
                    $height = $org_img->height();
                    $org_img->save(public_path().'/storage/img/project/'.$projectLogo,50);


                    // save image to core_images table
                    $cover = new CoreImage();
                    $cover->img_parent_id = $project->id;
                    $cover->img_type = 'project_logo';
                    $cover->img_path = $projectLogo;
                    $cover->img_width = $width;
                    $cover->img_height = $height;
                    $cover->added_user_id = Auth::id();
                    $cover->save();
                }
            }

        }
    }

    public function rules(): array
    {
        return [
            'project_name' => 'required|unique:projects,name',
        ];
    }

    /**
     * @return array
     */
    public function customValidationAttributes()
    {
        return [
            'project_name' => 'Project Name',
        ];
    }

}
