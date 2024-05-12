<?php

namespace App\Http\Controllers;

use App\Models\issue;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request){
        $filteredYear = $request->year;
        $currentMonth = Carbon::now()->timezone("Asia/Yangon")->format("m");
        $currentYear = Carbon::now()->timezone("Asia/Yangon")->format("Y");

        $filteredMonthInMonthObj = $request->month ? $request->month['month'] + 1 : $currentMonth;
        $filteredYearInMonthObj = $request->month ? $request->month['year'] : $currentYear;


        if ($filteredYear){
            $year = $filteredYear;
        } else {
            $year = $currentYear;
        }

        $monthsPerYearIssueData = [];
        $months = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        foreach ($months as $month){
            $issues = issue::whereMonth('created_at', $month)->whereYear('created_at', $year)->get()->count();
            array_push($monthsPerYearIssueData, $issues);
        }
        $projects = Project::withCount(['issues' => function($q) use ($filteredMonthInMonthObj, $filteredYearInMonthObj){
                        $q->whereMonth("created_at", $filteredMonthInMonthObj)->whereYear("created_at", $filteredYearInMonthObj);
                    }])
                    ->latest("id")->get();
        $issueDoughnutChartLabel = $projects->pluck("name");
        $issueDoughnutChartData = $projects->pluck("issues_count");


//        return $monthsPerYearIssueData;

        $dataArr = [
            "issueDoughnutChartLabel" => $issueDoughnutChartLabel,
            "issueDoughnutChartData" => $issueDoughnutChartData,
            "monthsPerYearIssueData" => $monthsPerYearIssueData,
            "selectedYear" => $year,
            "monthFromMonthObj" => $filteredMonthInMonthObj - 1,
            "yearFromMonthObj" => $filteredYearInMonthObj
        ];

        return renderView('Dashboard', $dataArr);
    }

    public function test(){
        return renderView('Test');
    }
}
