<?php

use Illuminate\Support\Facades\Route ;
use App\Http\Controllers\{
    UserController,
    WorkshopController,
    ChapterController,
    SubchapterController,
    EnrollmentController
};


//Public routes

Route::post('/send-code', [UserController::class, 'sendVerificationCode']);
Route::post('/verify-code', [UserController::class, 'verifyCode']);

//lists:
Route::get('/workshops', [WorkshopController::class, 'index']);
Route::get('/workshops/{id}', [WorkshopController::class, 'show']);
Route::get('/chapters', [ChapterController::class, 'index']);
Route::get('/chapters/{id}', [ChapterController::class, 'show']);
Route::get('/subchapters/{chapter_id}', [SubchapterController::class, 'index']);
Route::get('/subchapter/{id}', [SubchapterController::class, 'show']);


//Authenticated routes
Route::middleware('auth:api')->group(function () {


    //users:
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::get('/users/{id}/teacher-workshops', [UserController::class, 'getTeacherWorkshops']);
    Route::get('/users/{id}/student-workshops', [UserController::class, 'getStudentWorkshops']);


    //enrollments:
    Route::apiResource('/enrollments', EnrollmentController::class);


    //admin routes:
    Route::middleware(['check.admin'])->group(function () {

        //workshops:
        Route::post('/workshops', [WorkshopController::class, 'store']);
        Route::put('/workshops/{id}', [WorkshopController::class, 'update']);
        Route::delete('/workshops/{id}', [WorkshopController::class, 'destroy']);
        Route::post('/workshops/{id}/add-teacher', [WorkshopController::class, 'addTeacher']);

        //chapters:
        Route::post('/chapters',[ChapterController::class, 'store']);
        Route::put('/chapters/{id}', [ChapterController::class, 'update']);
        Route::delete('/chapters/{id}', [ChapterController::class, 'destroy']);

        //subchapters:
        Route::post('/subchapters',[SubchapterController::class, 'store']);
        Route::put('/subchapters/{id}', [SubchapterController::class, 'update']);
        Route::delete('/subchapters/{id}', [SubchapterController::class, 'destroy']);
    });

});


