<?php

use App\Http\Controllers\Import\CommonController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\StreamController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/setAssignment', [LocaleController::class, 'setAssignment']);
Route::get('/fix-attendance', [CommonController::class, 'fixAttendance']);
Route::get('/studentAttendanceCal', [CommonController::class, 'studentAttendanceCal']);

Route::get('/fixStudentAttachment', [LocaleController::class, 'fixStudentAttachment']);
Route::get('/ftp/convert', [LocaleController::class, 'ftpConvert']);
Route::get('/create/thumbs', [LocaleController::class, 'createThumbs']);
Route::get('/create/gallery/thumbs', [LocaleController::class, 'createGalleryThumbs']);
Route::get('/sample/lecture/thumbs', [LocaleController::class, 'sampleLectureThumbs']);
Route::get('/remove-unused', [LocaleController::class, 'removeUnused']);

// Localization
Route::get('/js/lang', [LocaleController::class, 'localization'])->middleware('locale')->name('locale');

// Stream
Route::get('stream', [StreamController::class, 'streamFile'])->name('stream');

Route::get('admin/{any?}', function () {
    return view('admin');
})->where('any', '^(?!api\/)[\/\w\.\,-]*');

Route::get('student/{any?}', function () {
    return view('student');
})->where('any', '^(?!api\/)[\/\w\.\,-]*');

Route::get('professor/{any?}', function () {
    return view('professor');
})->where('any', '^(?!api\/)[\/\w\.\,-]*');

Route::get('/{any?}', function () {
    return view('front');
})->where('any', '^(?!api\/)[\/\w\.\,-]*');

