<?php

namespace App\Models\YouTrack;

use Illuminate\Support\Facades\Log;

class Users
{
    private array $list = [];

    function __construct() {
        $ytclient = app("ytclient");

        $apiResponse = $ytclient->request('GET', '/users?fields=id,login,fullName,name,email,online,ringId,avatarUrl,banned');
        if ($apiResponse->isSuccess()) {
            $json = json_decode($apiResponse->body());
            foreach ($json as $ujson) {
                $u = new User();
                $u->setUser($ujson);
                $this->list[] = $u;
//                Log::info($u->getValue("email", "defaultValue"));
            }
        }
    }

    public function getList() {
        return $this->list;
    }

    public function getByLogin(string $login) :? User {
        foreach ($this->list as $p) {
            if ($p->getLogin() == $login) {
                return $p;
            }
        }
        return null;
    }
}
