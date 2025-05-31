<?php

namespace App\Models\Cust;

//use Illuminate\Database\Eloquent\Model;
use MongoDB\Laravel\Eloquent\Model;

class Issue extends Model
{
    protected $connection = 'mongodb';
}
