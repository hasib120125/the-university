<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Student\AuthController;
use App\Http\Controllers\Student\SubjectAssignmentController;
use App\Http\Controllers\Student\LectureController;
use App\Http\Controllers\Student\SubjectController;
use App\Http\Controllers\Student\SubjectExamController;
use App\Http\Controllers\Student\PaymentController;
use App\Http\Controllers\Student\LectureManagementController;
use App\Http\Controllers\Student\SubjectMaterialController;
use App\Http\Controllers\Student\SubjectNoticeController;
use App\Http\Controllers\Student\ProfileController;
use App\Http\Controllers\Student\SubjectNoteController;
use App\Http\Controllers\LectureQAController;
use App\Http\Controllers\LectureQAReplyController;
use App\Http\Controllers\Student\ApplicationController;
use App\Http\Controllers\Student\FileUploadController;

// Auth
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:student')->group(function () {
    Route::get('user', [AuthController::class, 'user']);
    Route::post('logout', [AuthController::class, 'logout']);

    //profile
    Route::get('result', [ProfileController::class, 'result']);
    Route::get('profile', [ProfileController::class, 'index']);
    Route::post('profile/update', [ProfileController::class, 'update']);
    Route::get('all-subjects', [ProfileController::class, 'subjects']);
    Route::get('administration-notices', [ProfileController::class, 'administrationNotices']);
    Route::get('administration-notices/{notice}', [ProfileController::class, 'administrationNoticeShow']);
    Route::get('subject-notices', [ProfileController::class, 'subjectNotices']);
    Route::get('subject-notices/{notice}', [ProfileController::class, 'subjectNoticeShow']);

    Route::get('subjects/dashboard', [SubjectController::class, 'dashboard']);
    Route::apiResource('lectures', LectureController::class);
    Route::apiResource('subjects', SubjectController::class);
    Route::get('subjects-plan/{subject}', [SubjectController::class, 'subjectPlan']);
    Route::apiResource('subjects.notices', SubjectNoticeController::class);
    Route::post('subjects/notices/{notice}/comments', [SubjectNoticeController::class, 'addComment']);
    Route::apiResource('subjects.assignments', SubjectAssignmentController::class);
    Route::delete('delete-assignment-attacment/{attachment}', [SubjectAssignmentController::class, 'deleteFile']);
    Route::apiResource('subjects.exams', SubjectExamController::class);
    Route::get('subjects/{subject}/examList', [SubjectExamController::class,'examList']);

    //Route::get('lectures/notices/{notice}/comments', [LectureNoticeController::class, 'getComments']);
    Route::apiResource('lectures.managements', LectureManagementController::class);
    Route::post('save-progress', [LectureController::class, 'saveProgress']);
    Route::apiResource('subjects.materials', SubjectMaterialController::class);
    Route::post('subjects/materials/{material}/comments', [SubjectMaterialController::class, 'addComment']);
    Route::get('subjects/materials/{material}/comments', [SubjectMaterialController::class, 'getComments']);
    Route::post('lecture-qas/{qas}/likeOrDislike', [LectureQAController::class, 'likeOrDislike']);
    Route::apiResource('lecture-qas', LectureQAController::class);

    Route::post('lecture-qas/{qas}/reply/{reply}/likeOrDislike', [LectureQAReplyController::class, 'likeOrDislike']);
    Route::apiResource('lecture-qas.reply', LectureQAReplyController::class);

    Route::apiResource('subjects.notes', SubjectNoteController::class);

    Route::get('payments/creditCost', [PaymentController::class, 'creditCost']);
    Route::apiResource('payments', PaymentController::class);
    Route::apiResource('applications', ApplicationController::class);

    //Lecture Apply
    Route::post('subject/apply', [ProfileController::class, 'subjectApply']);

    Route::get('calendars', [ProfileController::class, 'calendars']);


    // file upload
    Route::post('upload/temp', [FileUploadController::class, 'tempFileUpload']);
    Route::post('application/attachment/upload', [FileUploadController::class, 'attachmentFileUpload']);
    Route::post('application/attachment/delete', [FileUploadController::class, 'attachmentDelete']);
    Route::post('upload/image', [FileUploadController::class, 'imageFileUpload']);
    Route::post('delete/image', [FileUploadController::class, 'imageFileDelete']);

});
// Route::get('print-certificate', [CertificateController::class, 'printCertificate']);
// Route::get('print-transcript', [CertificateController::class, 'printTranscript']);
