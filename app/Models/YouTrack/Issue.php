<?php

namespace App\Models\YouTrack;

use Illuminate\Support\Facades\Log;

class Issue
{
    private $json;

    public function refreshIssue($num) : void {
        $ytclient = app("ytclient");

        $uri = 'issues/PAP034-' . $num . '?fields=id,summary,description,commentsCount,comments(id,author,created,comment,text),created,attachments(id,name,created,size,extension,metaData,url,thumbnailURL),numberInProject,resolved,tags';
        $apiResponse = $ytclient->request('GET', $uri);
        if ($apiResponse->isSuccess()) {
            $json = json_decode($apiResponse->body());
            $this->json = $json;
            Log::info(json_encode($json));
        }
    }

    public function getValue($key, $defVal = ""):string {
        return $this->json->$key ?? $defVal;
    }
}
