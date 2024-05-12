<?php

namespace App\Http\Controllers;

use App\Config\Config;
use App\Exports\ProjectsExport;
use App\Exports\UsersExport;
use App\Http\Services\ImageService;
use App\Http\Services\ProjectService;
use App\Imports\ProjectsImport;
use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use Nette\Utils\Image;

class ProjectController extends Controller
{
    protected $projectService, $imageService;
    public function __construct(ProjectService $projectService, ImageService $imageService)
    {
        $this->projectService = $projectService;
        $this->imageService = $imageService;
        $this->perPage = Config::perPage;
    }

    public function index(Request $request)
    {

        $projects = $this->projectService->getProjects($this->perPage, $request);

//        return $projects;

        if (!empty($request->params)){

            $filteredValue = '';
        } else {
            $filteredValue = $request;
        }

        return renderView("Entry/Project/Index", ["projects" => $projects, "filteredValue" => $filteredValue]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return renderView("Entry/Project/Create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        $project = $this->projectService->store($request);
        if ($project){
            return redirect()->back()->with("status",["flag" => "error", "msg" => $project]);
        }
        return redirect()->back()->with("status",["flag" => "success", "msg" => "Project have been created successfully."]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $project = $this->projectService->getProject($project);
        return renderView("Entry/Project/Edit", ["project" => $project]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProjectRequest  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $project = $this->projectService->update($request, $project);
        if ($project){
            return redirect()->back()->with("status",["flag" => "error", "msg" => $project]);
        }
        return redirect()->back()->with("status",["flag" => "success", "msg" => "Project have been updated successfully."]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {

        $project = $this->projectService->delete($project);
        if ($project){
            return redirect()->back()->with("status",["flag" => "error", "msg" => $project]);
        }
        return redirect()->back()->with("status",["flag" => "success", "msg" => "Project have been deleted successfully."]);

    }

    public function status(Project $project){
        $status = changeStatus($project);
        return redirect()->back()->with("status",["flag" => "success", "msg" => "Project Status have been updated successfully."]);
    }

    public function projectPdf(){
        $projects = Project::all();

        $pdf = Pdf::loadView('pdf.project',compact('projects'))->setPaper('a4');
        return $pdf->stream();
    }

    public function CSVExport(Request $request){
        $extension = $request->extension;
        $extensionUpperCase = strtoupper($extension);
//        return (new UsersExport)->download("user.xlsx", \Maatwebsite\Excel\Excel::XLSX);
//        return (new UsersExport)->download("user.csv", \Maatwebsite\Excel\Excel::CSV,[
//            'Content-Type' => 'text/csv',
//        ]);
//        return (new UsersExport())->download('users.tsv', \Maatwebsite\Excel\Excel::TSV);
//        return (new UsersExport())->download('users.ods', \Maatwebsite\Excel\Excel::ODS);
        return Excel::download(new ProjectsExport(), 'projects.'.$extension);

    }

    public function CSVImport(Request $request){
        $importFile = $request->file('csvImportFile');
        $projectImport = new ProjectsImport();
        $projectImport->import($importFile);

        if ($projectImport->failures()){
            return redirect()->back()->with("status",["flag" => "danger", "msg" => $projectImport->failures()]);
        } else {
            return redirect()->back()->with("status",["flag" => "success", "msg" => "Project CSV have been imported successfully."]);
        }

//        foreach ($projectImport->failures() as $failure) {
//            return $failure;
//            $failure->row(); // row that went wrong
//            $failure->attribute(); // either heading key (if using heading row concern) or column index
//            $failure->errors(); // Actual error messages from Laravel validator
//            $failure->values(); // The values of the row that has failed.
//        }
    }

}
