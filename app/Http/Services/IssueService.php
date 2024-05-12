<?php

namespace App\Http\Services;

use App\Models\issue;

class IssueService
{
    public function getIssues($perPage = null, $params = null){
        if (empty($perPage)){
            $issues = issue::with(['user', 'team', 'project'])->latest("id")->get();
        } else {

            if (!empty($params->perPage)){
                $perPage = $params->perPage;
            }

            $issues = issue::with(['user', 'team', 'project'])

                ->when($params->searchKey, function ($q) use ($params){
                    $q->where('name','LIKE', "%$params->searchKey%");
                })
                ->when($params->field, function ($q) use ($params){
                    $q->orderBy("$params->field", "$params->direction");
                })

//                                ->when($params->status || $params->status == 0, function ($q) use ($params){
//                                    $q->where("status", "$params->status");
//                                })
                ->latest("id")
                ->paginate($perPage)
                ->withQueryString();
        }
        return $issues;
    }
}
