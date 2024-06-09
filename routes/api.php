<?php

use App\Http\Controllers\Api\CoursesController;
use App\Http\Controllers\Api\PeopleController;
use App\Http\Controllers\Api\ProjectsController;
use App\Http\Controllers\Api\PublicationsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('courses', CoursesController::class);
Route::apiResource('people', PeopleController::class);
Route::apiResource('projects', ProjectsController::class);
Route::apiResource('publications', PublicationsController::class);
