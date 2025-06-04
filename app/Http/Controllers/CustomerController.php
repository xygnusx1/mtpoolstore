<?php

namespace App\Http\Controllers;

use DirectoryIterator;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CustomerController extends Controller
{

    public function __construct() {
        $this->custdbBaseDir = config('app.custdbBaseDir');
        $this->custdb_active = config('app.custdb_active');
        $this->custdb_done = config('app.custdb_done');
    }

    /**
     * Show the profile for a given user.
     */
    public function getAllCustomers(): View
    {
        return view('cust/cust-home', [
            'navtree' => $this->makeNavMenu()->tree(),
//            'custdbBaseDir' => $this->custdbBaseDir,
            'custdb_active' => $this->custdb_active,
            'custdb_done' => $this->custdb_done
        ]);
    }

    /**
     * @param $id Customer name ("Last, First")
     * @return \Illuminate\Http\JsonResponse of all customer info available
     */
    public function getCustomer($id) {
        $baseDir = $this->custdbBaseDir;
        $cust = array();
        if (file_exists($baseDir . $id)) {
            $cust = $this->recurseDirs($baseDir . $id);
        } if (file_exists($baseDir . "_DONE/" . $id)) {
            $cust = $this->recurseDirs($baseDir . "_DONE/" . $id);
        }
        return response()->json($cust, 200);
    }

    private function recurseDirs($custBaseDir) : array {
        $cust = array();
        foreach (new DirectoryIterator($custBaseDir) as $file) {
            if ($file->isDot()) continue;
            $fn = strtoupper($file->getFilename());
            if ($fn[0] == ".") continue;
            if ($fn[0] == "_") continue;
            if ($file->isFile()) {
                if (str_contains($fn, '.NUMBERS') || str_contains($fn, '.PAGES')) continue;
                $cust[] = $fn;
            }
            if ($file->isDir()) {
                $subdir = $this->recurseDirs("{$custBaseDir}/{$fn}");
                if (count($subdir) > 0) {
                    $cust[$fn] = $subdir;
                }
            }
        }
        return $cust;
    }

//    function getMedia($id) {
//        info("id=" . $id);
//        return Storage::download('cust/Donnahoe, Prince/Photos/20250220/IMG_7037.JPG');
//    }
}
