<?php

namespace App\Http\Controllers\Issues;

use App\Http\Controllers\Controller;
use Cog\YouTrack\Rest\Client\YouTrackClient;
use Illuminate\Http\Request;
use App\Models\Cust\Issue;

class IssueController extends Controller
{
    function __construct() {}

    public function show($slug)
    {
        return view('issues/issue', [
            'issue' => Issue::where('slug', '=', $slug)->first()
        ]);
    }

    public function store(Request $request)
    {
        // initial code to see if the entire route works
        $issue = new Issue;

        $issue->title = $request->title;
        $issue->body = $request->body;
        $issue->slug = $request->slug;

        $issue->save();

        return response()->json(["result" => "ok"], 201);
    }
}
