<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Issues\IssueController;

Route::resource('issues', IssueController::class)->only([
'destroy', 'show', 'store', 'update'
]);
