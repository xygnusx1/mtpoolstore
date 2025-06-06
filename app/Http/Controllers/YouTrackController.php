<?php

namespace App\Http\Controllers;

use App\Models\YouTrack\Projects;
use App\Models\YouTrack\Users;
use App\Models\YouTrack\Issue;

class YouTrackController extends Controller
{
    public function show($slug)
    {
        $projects = new Projects();
        $projects->getProjects();
        $proj = $projects->getByName("PAP 034");

        $users = new Users();
//        $apiResponse = $ytclient->get('admin/projects');

        $issue = new Issue();
        $issue->refreshIssue($slug);

        return view('youtrack/ytissue', [
            'project' => $proj,
            'ulist' => $users->getList(),
            'issue' => $issue
        ]);
    }
}
