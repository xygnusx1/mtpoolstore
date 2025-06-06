<?php

namespace App\Models\YouTrack;

class Projects
{
    private array $list = [];

    public function getProjects() : void {
        $ytclient = app("ytclient");

        $uri = '/admin/projects?fields=id,name,shortName,createdBy(login,name,id),leader(login,name,id),key';
        $apiResponse = $ytclient->request('GET', $uri);
        if ($apiResponse->isSuccess()) {
            $json = json_decode($apiResponse->body());
            foreach ($json as $ujson) {
                $p = new Project();
                $p->setJson($ujson);
                $this->list[] = $p;
            }
        }
    }

    public function getByName(string $name) : ?Project
    {
        foreach ($this->list as $p) {
            if ($p->getName() == $name) {
                return $p;
            }
        }
        return null;
    }

//    public function getValue($key, $defVal = ""):string {
//        return $this->json->$key ?? $defVal;
//    }
}
