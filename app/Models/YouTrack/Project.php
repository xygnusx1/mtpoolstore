<?php

namespace App\Models\YouTrack;
//    {
//        "shortName": "PAP034",
//        "createdBy": null,
//        "leader": {
//            "login": "root",
//            "name": "Root",
//            "id": "1-1",
//            "$type": "User"
//        },
//        "name": "PAP 034",
//        "id": "0-1",
//        "$type": "Project"
//    }
class Project
{
    private $json;

    public function setJson($json):void {
        $this->json = (object) $json;
    }

    public function getName():string {
        return $this->json->name;
    }

    public function getValue($key, $defVal = ""):string {
        return $this->json->$key ?? $defVal;
    }
}
