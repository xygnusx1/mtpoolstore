<?php

namespace App\Http\Controllers\Issues;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cust\Issue;

class IssueController extends Controller
{
    public function show($slug)
    {
        return view('issue', [
            'issue' => Issue::where('slug', '=', $slug)->first()
        ]);
    }

    public function store(Request $request)
    {
        $issue = new Issue;

        $issue->title = $request->title;
        $issue->body = $request->body;
        $issue->slug = $request->slug;

        $issue->save();

        return response()->json(["result" => "ok"], 201);
    }
}
