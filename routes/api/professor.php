<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Professor\ProfileController;
use App\Http\Controllers\Professor\AuthController;
use App\Http\Controllers\Professor\FileUploadController;
use App\Http\Controllers\Professor\SubjectAssignmentController;
use App\Http\Controllers\Professor\SubjectController;
use App\Http\Controllers\Professor\SubjectExamController;
use App\Http\Controllers\Professor\SubjectMaterialController;
use App\Http\Controllers\Professor\SubjectNoticeController;
use App\Http\Controllers\Professor\SubjectPlanController;
use App\Http\Controllers\Professor\LectureController;
use App\Http\Controllers\Professor\StudentGradeController;

// Auth
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:professor')->group(function () {
    Route::get('user', [AuthController::class, 'user']);
    Route::post('logout', [AuthController::class, 'logout']);

    // Profile
    Route::get('profile', [ProfileController::class, 'index']);
    Route::patch('profile/update', [ProfileController::class, 'update']);
    Route::post('profile/career/save', [ProfileController::class, 'saveCareer']);
    Route::get('profile/careers', [ProfileController::class, 'careers']);
    Route::get('profile/educations', [ProfileController::class, 'educations']);
    Route::delete('profile/career/delete/{id}', [ProfileController::class, 'deleteCareer']);
    Route::post('profile/education/save', [ProfileController::class, 'saveEducation']);
    Route::delete('profile/education/delete/{id}', [ProfileController::class, 'deleteEducation']);
    Route::get('lectures', [ProfileController::class, 'lectures']);

    Route::get('departments', [ProfileController::class, 'departments']);
    Route::get('calendars', [ProfileController::class, 'calendars']);
    Route::get('administration-notices', [ProfileController::class, 'administrationNotices']);
    Route::get('administration-notices/{notice}', [ProfileController::class, 'administrationNoticeShow']);
    Route::get('subject-notices', [ProfileController::class, 'subjectNotices']);
    Route::get('subject-notices/{notice}', [ProfileController::class, 'subjectNoticeShow']);

     // subject
     Route::get('subjects/{subject}/lectures/{semester_id}', [SubjectController::class, 'lectures']);
     Route::get('subjects/{subject}/professors/{semester_id}', [SubjectController::class, 'professors']);
     Route::post('subjects/{subject}/professors/{semester_id}', [SubjectController::class, 'professorsAdd']);
     Route::delete('subjects/{subject}/professors/{professor}/{semester_id}', [SubjectController::class, 'professorsRemove']);

     Route::get('semesters', [SubjectController::class, 'semesters']);
     Route::apiResource('subjects', SubjectController::class);
     Route::apiResource('subjects.subject-plans', SubjectPlanController::class);
     Route::get('subjects/{subject}/plans/{semester}', [SubjectPlanController::class, 'subjectPlanBySemister']);
     Route::apiResource('subjects.notices', SubjectNoticeController::class);
     Route::apiResource('subjects.materials', SubjectMaterialController::class);
     Route::apiResource('subjects.assignments', SubjectAssignmentController::class);
     Route::get('subjects/assignments/{assignment}/students', [SubjectAssignmentController::class,'students']);
     Route::post('subjects/assignments/{assignment}/students/{student}/approveOrReject', [SubjectAssignmentController::class,'approveOrReject']);

     Route::apiResource('subjects.exams', SubjectExamController::class);
     Route::get('subjects/exams/{exam}/students', [SubjectExamController::class,'students']);
     Route::get('subjects/exams/{exam}/students/{student}', [SubjectExamController::class,'studentExam']);
     Route::patch('subjects/exams/{exam}/students/{student}', [SubjectExamController::class,'examAnswerStore']);

    Route::apiResource('lectures', LectureController::class);
    Route::apiResource('grades', StudentGradeController::class);

     // file upload
    Route::post('upload/temp', [FileUploadController::class, 'tempFileUpload']);
    Route::post('upload/video/temp', [FileUploadController::class, 'tempVideoFileUpload']);
    Route::post('upload/image', [FileUploadController::class, 'imageFileUpload']);
    Route::post('delete/image', [FileUploadController::class, 'imageFileDelete']);
});
