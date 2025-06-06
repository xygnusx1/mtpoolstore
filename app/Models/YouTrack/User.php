<?php

namespace App\Models\YouTrack;

use Illuminate\Support\Facades\Log;

class User
{
    private $obj;
//    public function setUserProperties($json) {
//        $this->id = $json->id;
//        $this->type = $json->{'$type'};
//        $this->name = $json->name;
//        $this->fullName = $json->fullName;
//        $this->login = $json->login;
//        $this->email = $json->email ?? "";
//        $this->avatarUrl = $json->avatarUrl;
//        $this->online = $json->online;
//        $this->ringId = $json->ringId;
//        $this->banned = $json->banned;
//
//        Log::info(json_encode($json));
//    }

    public function setUser($obj):void {
        $this->obj = $obj;
    }

    public function getLogin(): string {
        return $this->obj->login;
    }

    public function getValue($key, $defVal = ""):string {
        return $this->obj->$key ?? $defVal;
    }
}
