<?php

namespace App\Http\Controllers;

use App\Config\Config;
use App\Http\Services\ImageService;
use App\Http\Services\IssueService;
use App\Models\issue;
use App\Http\Requests\StoreissueRequest;
use App\Http\Requests\UpdateissueRequest;
use App\Models\Project;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IssueController extends Controller
{

    protected $issueService, $imageService;
    public function __construct(IssueService $issueService, ImageService $imageService)
    {
        $this->issueService = $issueService;
        $this->imageService = $imageService;
        $this->perPage = Config::perPage;
    }

    public function index(Request $request)
    {

        $issues = $this->issueService->getIssues($this->perPage, $request);

        if (!empty($request->params)){
            $filteredValue = '';
        } else {
            $filteredValue = $request;
        }

        return renderView("Entry/Issue/Index", ["issues" => $issues, "filteredValue" => $filteredValue]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projects = Project::where('status',1)->get();
        $teams = Team::where('status', 1)->get();
        $dataArr = [
            'projects' => $projects,
            'teams' => $teams,
        ];
        return renderView("Entry/Issue/Create", $dataArr);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreissueRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreissueRequest $request)
    {
        try {
            $issue = new issue();
            $issue->name = $request->name;
            $issue->description = $request->description;
            $issue->project_id = $request->project_id;
            $issue->come_from_id = $request->team_id;
            $issue->added_user_id = Auth::id();
            $issue->save();
        } catch (\Throwable $e){
            return redirect()->back()->with("status",["flag" => "error", "msg" => $e->getMessage()]);
        }
        return redirect()->back()->with("status",["flag" => "success", "msg" => "Issue have been created successfully."]);



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $issue = issue::where('id', $id)->with('team:id,name','project:id,name','user:id,name')->first();
        $dataArr = [
            "issue" => $issue
        ];
        return renderView("Entry/Issue/Show", $dataArr);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function edit(issue $issue)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateissueRequest  $request
     * @param  \App\Models\issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateissueRequest $request, issue $issue)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function destroy(issue $issue)
    {
        //
    }
}
