<?php

namespace App\Http\Controllers;

use App\Models\issue;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;

class SearchController extends Controller
{
    public function index(Request $request){
        $searchValue = $request->searchValue;
        $results = Search::addMany([
                    [Project::class, "name"],
                    [issue::class, ["team.name","name"]]
                ])
                ->beginWithWildcard()
                ->paginate()
                ->search($searchValue);
        dd($results);
    }
}
