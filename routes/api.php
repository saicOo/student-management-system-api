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
#############################################################
    ###################### routes teachings ######################
    Route::get('/teachings', 'Api\TeachingController@index');
    Route::get('/teaching/show/{id}', 'Api\TeachingController@show');
    ##########################################################

Route::post('/register',"Api\Auth\AuthController@register" );
Route::post('/login',"Api\Auth\AuthController@login" );

Route::group(["middleware"=>['auth:sanctum']],function(){
    Route::post('/logout',"Api\Auth\AuthController@logout" );
    Route::get('/profile/{id}',"Api\Auth\AuthController@show" );
Route::namespace('Api')->group(function () {

    ##############################################################
    ###################### routes exams ##########################
    Route::post('/exam/{course_id}', 'ExamController@checkCodeExam');
    Route::get('/exam/{exam_id}', 'ExamController@viewExam');
    Route::post('/answer/{question_id}', 'ExamController@checkQoustion');
    #############################################################
    ###################### routes students ######################
    Route::get('/enroll/{coures_id}', 'EnrollController@enroll');
    Route::get('/getExam/{coures_id}', 'EnrollController@getExam');

});
});




