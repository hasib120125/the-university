<?php

use App\Http\Controllers\Admin\NewsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\AuthController;
use App\Http\Controllers\Front\FixedPageController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\PageController;
use App\Http\Controllers\Front\MenuController;
use App\Http\Controllers\Front\StudentRegistrationController;
use App\Http\Controllers\Front\GalleryController;

// Auth
Route::post('login', [AuthController::class, 'login']);

//  Home Page routes
Route::get('sliders',   [HomeController::class, 'sliders']);
Route::get('settings',   [HomeController::class, 'settings']);
Route::get('statistics',   [HomeController::class, 'statistics']);
Route::get('socials',   [HomeController::class, 'socialsLinks']);
Route::get('features',  [HomeController::class, 'getFeatures']);
Route::get('recent-galleries',  [HomeController::class, 'recentGalleries']);
Route::get('popups',  [HomeController::class, 'popups']);
Route::get('sample-lectures', [HomeController::class, 'sampleLecture']);
Route::get('home-offline-seminars', [HomeController::class, 'offlineSeminars']);
Route::get('static-page/{page:slug}',  [HomeController::class, 'staticPage']);
// Route::get('news',      [HomeController::class, 'getNews']);
Route::get('footer-top',   [HomeController::class, 'footerTop']);

Route::get('admission-counselling', [FixedPageController::class, 'admissionCounselling']);
Route::get('academic-regulation', [FixedPageController::class, 'academicRegulation']);
Route::get('ministry-of-ministry', [FixedPageController::class, 'ministryOfMinistry']);
Route::get('department-of-missiology', [FixedPageController::class, 'departmentOfMissiology']);
Route::get('department-of-pastoral-music', [FixedPageController::class, 'departmentOfPastoralMusic']);
Route::get('professors', [FixedPageController::class, 'professors']);

Route::get('article-publications', [FixedPageController::class, 'articlePublications']);
Route::get('offline-seminars', [FixedPageController::class, 'offlineSeminars']);
Route::get('downloads', [FixedPageController::class, 'downloads']);

// Gallery
Route::get('galleries', [GalleryController::class, 'index']);
Route::get('galleries/{gallery}', [GalleryController::class, 'show']);

//  Faq Pages routes
Route::get('faqs', [PageController::class, 'faqPage']);
Route::get('parent-menu/{slug}', [PageController::class, 'parentMenu']);
Route::get('custom-pages/{id}', [PageController::class, 'getCustomPageContent']);
Route::get('pages/{menu:slug}/{subMenu:slug}', [PageController::class, 'show']);

//Menus
Route::get('menus', [MenuController::class, 'getMenus']);
Route::get('news', [NewsController::class, 'index']);
Route::get('news/{news:slug}',[NewsController::class, 'show']);

//Contact Us
Route::post('contact/us', [PageController::class, 'contactUsMail']);

Route::get('departments', [StudentRegistrationController::class, 'departments']);
Route::get('registrationOpen', [StudentRegistrationController::class, 'registrationOpen']);
Route::post('register', [StudentRegistrationController::class, 'register']);



