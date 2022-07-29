<?php

use Illuminate\Http\Request;
use App\Http\Controller\Api\CourseController;
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
Route::post('login',"Api\Auth\AuthController@login" );

// Test register  Route::post('register',"Api\Auth\AuthController@register" );

Route::group(["middleware"=>['auth:sanctum']],function(){
    // middleware super admin role 1
    Route::group(["middleware"=>'CheckAdmin'],function(){
        Route::post('register',"Api\Auth\AuthController@register");
        Route::get('/destroy/{id}',"Api\Auth\AuthController@destroy");
    });

    Route::get('/profile/{id}',"Api\Auth\AuthController@show");
    Route::post('/logout',"Api\Auth\AuthController@logout" );
    Route::namespace('Api')->group(function () {
        ///////// sub admin
        Route::get('exams', 'ExamController@index');
        Route::get('students', 'StudentController@index');
        Route::get('student/senCode/{id}', 'StudentController@sendCode');
        ////////////////////////////////
        Route::group(["middleware"=>'CheckAdmin'],function(){
            ###################### routes courses ###################
            #########################################################
        Route::get('courses', 'CourseController@index');
        Route::post('course', 'CourseController@store');
        Route::put('course/update/{id}', 'CourseController@update');
        Route::delete('course/destroy/{id}', 'CourseController@destroy');
        Route::get('course/show/{id}', 'CourseController@show');
        ##############################################################
        ###################### routes exams ##########################

        Route::post('exam', 'ExamController@store');
        Route::put('exam/update/{id}', 'ExamController@update');
        Route::delete('exam/destroy/{id}', 'ExamController@destroy');
        Route::get('exam/show/{id}', 'ExamController@show');
        #############################################################
        ###################### routes question ######################
        Route::get('questions', 'QuestionController@index');
        Route::post('question', 'QuestionController@store');
        Route::put('question/update/{id}', 'QuestionController@update');
        Route::delete('question/destroy/{id}', 'QuestionController@destroy');
        Route::get('question/show/{id}', 'QuestionController@show');
        #############################################################
        ###################### routes trainers ######################
        Route::get('trainers', 'TrainerController@index');
        Route::post('trainer', 'TrainerController@store');
        Route::put('trainer/update/{id}', 'TrainerController@update');
        Route::delete('trainer/destroy/{id}', 'TrainerController@destroy');
        Route::get('trainer/show/{id}', 'TrainerController@show');
        #############################################################
        ###################### routes teachings ######################
        Route::get('teachings', 'TeachingController@index');
        Route::post('teaching', 'TeachingController@store');
        Route::put('teaching/update/{id}', 'TeachingController@update');
        Route::get('teaching/destroy/{id}', 'TeachingController@destroy');
        Route::get('teaching/show/{id}', 'TeachingController@show');
        #############################################################
        ###################### routes students ######################

        Route::get('students', 'StudentController@index');
        Route::put('student/update/{id}', 'StudentController@update');
        Route::delete('student/destroy/{id}', 'StudentController@destroy');
        Route::get('student/show/{id}', 'StudentController@show');

        #############################################################
        ###################### routes enroll ######################
        Route::get('enroll', 'EnrollController@index');
    });
});

});
