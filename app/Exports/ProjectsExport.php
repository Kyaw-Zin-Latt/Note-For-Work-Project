<?php

namespace App\Exports;

use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProjectsExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize
{
    use Exportable;


    public function collection()
    {
        return Project::where('added_user_id', Auth::id())->with(['image', 'user'])->latest()->get();
    }

    public function map($project): array
    {
        return [
            $project->id,
            $project->name,
            $project->status ? 'Publish' : 'UnPublish',
            $project->image->img_path,
            $project->user->name,
            $project->created_at->format("d M Y , h : i a"),
            $project->updated_at->format("d M Y , h : i a"),
        ];
    }

    public function headings(): array
    {
        return [
            "id", "Project Name", "Project Status", "Project Logo Name", "Created User Name" , "Created Date", "Updated Date"
        ];
    }


}
