<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function () {

    Route::post('login', 'AuthController@login');
    Route::get('logout', 'AuthController@logout');
    Route::get('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');

});


// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// }); 
Route::middleware('auth:api')->group(function () {


    //List students
    Route::get('students', 'Students\StudentListsController@index');
    //List single student
    Route::get('student/{id}', 'Students\StudentListsController@show');
    //Create new student
    Route::post('student', 'Students\StudentListsController@create');
    //Update student
    Route::put('student/{id}', 'Students\StudentListsController@update');
    //Delete student
    Route::put('student/delete/{id}', 'Students\StudentListsController@delete');
    //Check if students was used
    Route::get('studentcheck/{id}', 'Students\StudentListsController@checkIfUsed');
    // END students
    
    //List subjects
    Route::get('subjects', 'References\SubjectsController@index');
    //List single subject
    Route::get('subject/{id}', 'References\SubjectsController@show');
    //Create new subject
    Route::post('subject', 'References\SubjectsController@create');
    //Update subject
    Route::put('subject/{id}', 'References\SubjectsController@update');
    //Delete subject
    Route::put('subject/delete/{id}', 'References\SubjectsController@delete');
    //Check if subjects was used
    Route::get('subjectcheck/{id}', 'References\SubjectsController@checkIfUsed');
    // END subjects

    //List curryears
    Route::get('curr_years', 'Curriculums\CurriculumYearsController@index');
    //List single curriculum
    Route::get('curr/{id}', 'Curriculums\CurriculumYearsController@show');
    //Create new _
    Route::post('curr', 'Curriculums\CurriculumYearsController@create');
    //Update curriculum
    Route::put('curr/{id}', 'Curriculums\CurriculumYearsController@update');
    //Delete curriculum
    Route::put('curr/delete/{id}', 'Curriculums\CurriculumYearsController@delete');
    //Check if curriculum was used
    Route::get('currcheck/{id}', 'Curriculums\CurriculumYearsController@checkIfUsed');
    // END curriculums

    //List curriculums
    Route::get('curriculums', 'Curriculums\CurriculumListsController@index');
    //List single curriculum
    Route::get('curriculum/{id}', 'Curriculums\CurriculumListsController@show');
    //Create new _
    Route::post('curriculum', 'Curriculums\CurriculumListsController@create');
    //Update curriculum
    Route::put('curriculum/{id}', 'Curriculums\CurriculumListsController@update');
    //Delete curriculum
    Route::put('curriculum/delete/{id}', 'Curriculums\CurriculumListsController@delete');
    //Check if curriculum was used
    Route::get('curriculumcheck/{id}', 'Curriculums\CurriculumListsController@checkIfUsed');
    // END curriculums
    Route::get('getcyitems/{id}', 'Inventory\ReceivingListController@getCyItems');
});