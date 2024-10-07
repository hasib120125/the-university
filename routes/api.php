<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocaleController;

include 'api/front.php';

Route::prefix('import')->group(function () {
    include 'old-import.php';
});

Route::prefix('admin')->group(function () {
    include 'api/admin.php';
});

Route::prefix('professor')->group(function () {
    include 'api/professor.php';
});

Route::prefix('student')->group(function () {
    include 'api/student.php';
});

// Localization
Route::post('set-locale', [LocaleController::class, 'setLocale']);
Route::get('current/locale', [LocaleController::class, 'currentLocale']);
