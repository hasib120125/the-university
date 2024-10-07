<?php

use App\Http\Controllers\Admin\AcademicRegulatioController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\AdmissionCounsellingController;
use App\Http\Controllers\Admin\ApplicationController;
use App\Http\Controllers\Admin\ArticalesPublicationsController;
use App\Http\Controllers\Admin\OfflineSeminarController;
use App\Http\Controllers\Admin\DownloadController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BulkAudioController;
use App\Http\Controllers\Admin\BulkSubtitleController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\FacultyController;
use App\Http\Controllers\Admin\SemesterController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\ProfessorController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\LectureController;
use App\Http\Controllers\Admin\SubjectNoticeController;
use App\Http\Controllers\Admin\LectureManagementController;
use App\Http\Controllers\Admin\StudentTuitionFeeController;
use App\Http\Controllers\Admin\CurriculumFeeController;
use App\Http\Controllers\Admin\FileUploadController;
use App\Http\Controllers\Admin\SubjectAssignmentController;
use App\Http\Controllers\Admin\SubjectExamController;
use App\Http\Controllers\Admin\NoticeController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\SubMenuController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\StudentGradeController;
use App\Http\Controllers\Admin\SubjectMaterialController;
use App\Http\Controllers\Admin\LectureStudentController;
use App\Http\Controllers\Admin\OtherFeeController;
use App\Http\Controllers\Admin\SocialController;
use App\Http\Controllers\Admin\FeatureController;
use App\Http\Controllers\Admin\LectureMajorController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\RegistrationOpenController;
use App\Http\Controllers\Admin\StaticPageController;
use App\Http\Controllers\Admin\BulkVideoController;
use App\Http\Controllers\Admin\CalendarController;
use App\Http\Controllers\Admin\CertificateController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DepartmentOfMissiologyController;
use App\Http\Controllers\Admin\DepartmentOfPastoralMusicController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SubjectPlanController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\GalleryImageController;
use App\Http\Controllers\Admin\MinistryofMinistryController;
use App\Http\Controllers\Admin\PopUpController;
use App\Http\Controllers\Admin\GradeSystemController;
use App\Http\Controllers\Admin\SampleLectureController;

// Auth
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:admin')->group(function () {

    Route::get('user', [AuthController::class, 'user']);
    Route::post('logout', [AuthController::class, 'logout']);

    Route::patch('profile-update/{admin}', [AdminProfileController::class, 'update']);
    // Faculty
    Route::apiResource('faculties', FacultyController::class);

    // Curriculum
    Route::apiResource('departments', DepartmentController::class);

    // Semester
    Route::apiResource('semesters', SemesterController::class);


    // Professor
    Route::get('professors/customSubjects', [ProfessorController::class, 'customSubjects']);
    Route::post('professors/import', [ProfessorController::class, 'excelImport']);
    Route::apiResource('professors', ProfessorController::class);

    Route::apiResource('registration-open', RegistrationOpenController::class);

    // Student
    Route::get('student-attachment/{student}', [StudentController::class, 'attachments']);
    Route::delete('student-attachment/{attachment}', [StudentController::class, 'attachmentDestroy']);

    Route::get('students/export-grade', [StudentController::class, 'exportGrade']);
    Route::get('students/subject-attendance', [StudentController::class, 'subjectAttendance']);
    Route::get('students/export', [StudentController::class, 'export']);
    Route::get('students/{student}/subjects', [StudentController::class, 'subjects']);
    Route::post('students/subject-attendance', [StudentController::class, 'subjectAttendanceStore']);
    Route::post('students/remove-subject', [StudentController::class, 'removeSubject']);
    Route::post('students/{student}/give-credit', [StudentController::class, 'giveCredit']);
    Route::get('dept-subject-details/{student}', [StudentController::class, 'deptSubjectDetails']);
    Route::patch('activate-students/{student}', [StudentController::class, 'activate']);
    Route::post('students/import', [StudentController::class, 'excelImport']);
    Route::apiResource('students', StudentController::class);
    Route::get('active-students', [StudentController::class, 'active']);
    Route::get('in-active-students', [StudentController::class, 'inActive']);
    Route::get('all-students', [StudentController::class, 'allStudents']);
    Route::get('student-result/{student}', [StudentController::class, 'studentResult']);

    // subject
    Route::post('subjects/{subject}/clone', [SubjectController::class, 'clone']);
    Route::patch('subjects/{subject}/status-change', [SubjectController::class, 'changeStatus']);
    Route::post('subjects/add-student', [SubjectController::class, 'addStudent']);
    Route::get('subjects/{subject}/grade-input/{semester_id}', [SubjectController::class, 'gradeInput']);
    Route::post('change-pass-status', [SubjectController::class, 'changePassStatus']);
    Route::get('subjects/{subject}/all-except-current-students/{semester_id}', [SubjectController::class, 'allStudents']);
    Route::get('subjects/{subject}/students/{semester_id}', [SubjectController::class, 'students']);
    Route::get('subjects/{subject}/lectures/{semester_id}', [SubjectController::class, 'lectures']);
    Route::get('subjects/{subject}/professors/{semester_id}', [SubjectController::class, 'professors']);
    Route::post('subjects/{subject}/professors/{semester_id}', [SubjectController::class, 'professorsAdd']);
    Route::delete('subjects/{subject}/professors/{professor}/{semester_id}', [SubjectController::class, 'professorsRemove']);

    Route::apiResource('subjects', SubjectController::class);
    Route::apiResource('subjects.subject-plans', SubjectPlanController::class);
    Route::get('subjects/{subject}/plans/{semester}', [SubjectPlanController::class, 'subjectPlanBySemister']);
    Route::apiResource('subjects.notices', SubjectNoticeController::class);
    Route::apiResource('subjects.materials', SubjectMaterialController::class);
    Route::apiResource('subjects.assignments', SubjectAssignmentController::class);
    Route::get('subjects/assignments/{assignment}/students', [SubjectAssignmentController::class, 'students']);
    Route::post('subjects/assignments/{assignment}/students/{student}/approveOrReject', [SubjectAssignmentController::class, 'approveOrReject']);

    Route::apiResource('subjects.exams', SubjectExamController::class);
    Route::get('subjects/exams/{exam}/students', [SubjectExamController::class, 'students']);
    Route::get('subjects/exams/{exam}/students/{student}', [SubjectExamController::class, 'studentExam']);
    Route::patch('subjects/exams/{exam}/students/{student}', [SubjectExamController::class, 'examAnswerStore']);
    Route::post('subject-exams/{subjectExam}/semesters/{semester}', [SubjectExamController::class, 'clone']);

    // Lectures
    Route::post('lectures/{lecture}/clone', [LectureController::class, 'clone']);
    Route::apiResource('lectures', LectureController::class);
    Route::apiResource('lectures.managements', LectureManagementController::class);
    Route::apiResource('other-fees', OtherFeeController::class);
    Route::apiResource('lectures.majors', LectureMajorController::class);

    Route::get('lectures/{lecture}/pending-students', [LectureStudentController::class, 'pendingStudents']);
    Route::post('lectures/{lecture}/pending-students/{student}/approve', [LectureStudentController::class, 'pendingStudentsApprove']);
    Route::post('lectures/{lecture}/pending-students/{student}/reject', [LectureStudentController::class, 'pendingStudentsReject']);
    Route::get('lectures/{lecture}/active-students', [LectureStudentController::class, 'activeStudents']);
    Route::post('lectures/{lecture}/active-students/{student}/delete', [LectureStudentController::class, 'activeStudentsDelete']);
    Route::apiResource('grades', StudentGradeController::class);
    Route::post('calculate-attendance', [StudentGradeController::class, 'getAttendanceData']);

    Route::apiResource('footer-top', \App\Http\Controllers\Admin\FooterTopController::class);
    // Lectures
    Route::apiResource('student-tuition-fees', StudentTuitionFeeController::class);

    // Curriculum Fees
    Route::apiResource('curriculum-fees', CurriculumFeeController::class);

    // Notice
    Route::apiResource('notices', NoticeController::class);

    // news
    Route::apiResource('news', NewsController::class);

    // admission-counselling
    Route::apiResource('admission-counselling', AdmissionCounsellingController::class);
    Route::apiResource('academic-regulation', AcademicRegulatioController::class);
    Route::apiResource('ministry-of-ministry', MinistryofMinistryController::class);
    Route::apiResource('department-of-missiology', DepartmentOfMissiologyController::class);
    Route::apiResource('department-of-pastoral-music', DepartmentOfPastoralMusicController::class);

    //Ics Articles and Publications
    Route::apiResource('articles-publications', ArticalesPublicationsController::class);

    //Offline Seminar
    Route::apiResource('offline-seminars', OfflineSeminarController::class);

    //Download
    Route::apiResource('downloads', DownloadController::class);

    //Menu
    Route::apiResource('menus', MenuController::class);
    Route::post('menus/sort', [MenuController::class, 'sortMenu']);
    Route::apiResource('menus.sub-menus', SubMenuController::class);

    //Menu
    Route::apiResource('galleries', GalleryController::class);
    Route::apiResource('galleries.images', GalleryImageController::class);

    //  slider
    Route::apiResource('sliders', SliderController::class);

    // file upload
    Route::post('upload/temp', [FileUploadController::class, 'tempFileUpload']);
    Route::post('upload/video/temp', [FileUploadController::class, 'tempVideoFileUpload']);
    Route::post('delete/temp', [FileUploadController::class, 'deleteTempFile']);
    Route::post('upload/image', [FileUploadController::class, 'imageFileUpload']);
    Route::post('upload/video', [FileUploadController::class, 'videoFileUpload']);
    Route::post('delete/image', [FileUploadController::class, 'imageFileDelete']);
    Route::post('check/ftp', [FileUploadController::class, 'checkFtp']);


    // setting
    Route::get('setting', [SettingController::class, 'index']);
    Route::patch('setting/{setting}', [SettingController::class, 'update']);

    //Bulk Upload
    Route::post('bulk/video-file/upload', [FileUploadController::class, 'bulkVideoFileUpload']);
    Route::post('bulk/video-file/delete', [FileUploadController::class, 'bulkVideoFileDelete']);
    Route::post('bulk/video-file/retry/{bulkVideo}', [BulkVideoController::class, 'retry']);
    Route::post('bulk/video-file/convert-again/{bulkVideo}', [BulkVideoController::class, 'convertAgain']);
    Route::post('bulk-video/{bulkVideo}/assign-video-to-lecture', [BulkVideoController::class, 'assignVideoToLecture']);
    Route::get('bulk-video/forLecture', [BulkVideoController::class, 'forLecture']);
    Route::apiResource('bulk-video', BulkVideoController::class);
    Route::get('load-lectures', [BulkVideoController::class, 'loadLecture']);

    Route::post('bulk/audio-file/upload', [FileUploadController::class, 'bulkAudioFileUpload']);
    Route::post('bulk/audio-file/delete', [FileUploadController::class, 'bulkAudioFileDelete']);
    Route::post('bulk-audio/{bulkAudio}/assign-audio-to-lecture', [BulkAudioController::class, 'assignAudioToLecture']);
    Route::apiResource('bulk-audio', BulkAudioController::class);

    Route::post('bulk/subtitle-file/upload', [FileUploadController::class, 'bulkSubtitleFileUpload']);
    Route::post('bulk/subtitle-file/delete', [FileUploadController::class, 'bulkSubtitleFileDelete']);
    Route::post('bulk-subtitle/{bulkSubtitle}/assign-subtitle-to-lecture', [BulkSubtitleController::class, 'assignSubtitleToLecture']);
    Route::apiResource('bulk-subtitle', BulkSubtitleController::class);

    Route::get('applications/pending', [ApplicationController::class, 'pendingApplication']);
    Route::get('applications/{student}', [ApplicationController::class, 'studentApplications']);
    Route::post('applications/{application}/toggle-status', [ApplicationController::class, 'approveOrReject']);

    //  Pages
    Route::apiResource('pages', PageController::class);

    //  Faq Pages
    Route::apiResource('faqs', FaqController::class);

    Route::apiResource('sample-lectures', SampleLectureController::class);

    //  Social Links
    Route::apiResource('socials', SocialController::class);

    //  Features Links
    Route::apiResource('features', FeatureController::class);

    //  Static Page
    Route::apiResource('static-pages', StaticPageController::class);

    // Dashboard
    Route::get('recent-view', [DashboardController::class, 'recentView']);
    Route::get('total-students-count', [DashboardController::class, 'totalStudentsCount']);
    Route::get('active-students-count', [DashboardController::class, 'activeStudentsCount']);
    Route::get('subjects-count', [DashboardController::class, 'subjectsCount']);
    Route::get('departments-count', [DashboardController::class, 'departmentsCount']);
    Route::get('upcoming-lectures', [DashboardController::class, 'upcomingLectures']);
    Route::get('upcoming-exams', [DashboardController::class, 'upcomingExams']);
    Route::get('upcoming-semesters', [DashboardController::class, 'upcomingSemesters']);
    Route::get('student-by-semester', [DashboardController::class, 'studentBySemester']);
    Route::get('top-subjects', [DashboardController::class, 'topSubjects']);
    Route::get('top-departments', [DashboardController::class, 'topDepartments']);
    Route::apiResource('calendars', CalendarController::class);

    // Payments
    Route::get('payments/pending', [PaymentController::class, 'pending']);
    Route::get('payments/approved', [PaymentController::class, 'approved']);
    Route::post('payments/approve/{payment}', [PaymentController::class, 'approve']);

    //  PopUp
    Route::apiResource('popup', PopUpController::class);

    Route::get('generate-certificate/{student}', [CertificateController::class, 'generateCertificate']);
    Route::get('generate-transcript/{student}', [CertificateController::class, 'generateTranscript']);

    //Grade System
    Route::apiResource('grade-systems', GradeSystemController::class);
    Route::get('current-semester', [SettingController::class, 'currentSemester']);
});
