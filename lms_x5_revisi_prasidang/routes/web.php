<?php

use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ILSKuesionerController;
use App\Http\Controllers\LearningContentController;
use App\Http\Controllers\MDLActiveController;
use App\Http\Controllers\MDLAssignController;
use App\Http\Controllers\MDLAssignSubmissionController;
use App\Http\Controllers\MDLAssignGradesController;
use App\Http\Controllers\MDLCourseController;
use App\Http\Controllers\MDLFolderController;
use App\Http\Controllers\MDLForumController;
use App\Http\Controllers\MDLForumPostController;
use App\Http\Controllers\MDLGlobalController;
use App\Http\Controllers\MDLIntuitiveController;
use App\Http\Controllers\MDLLearningStylesController;
use App\Http\Controllers\MDLQuizController;
use App\Http\Controllers\MDLQuizQuestionController;
use App\Http\Controllers\MDLReflectiveController;
use App\Http\Controllers\MDLSensingController;
use App\Http\Controllers\MDLSequentialController;
use App\Http\Controllers\MDLSectionController;
use App\Http\Controllers\MDLVerbalController;
use App\Http\Controllers\MDLVisualController;
use App\Http\Controllers\MDLFileController;
use App\Http\Controllers\MDLInfografisController;
use App\Http\Controllers\MDLPageController;
use App\Http\Controllers\MDLLabelController;
use App\Http\Controllers\MDLUrlController;
use App\Http\Controllers\MDLLessonController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TopikController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ParticipantController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

// Redirect root to Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication Routes
Auth::routes();
Route::get('/register', fn() => view('auth.register'))->name('register');
Route::get('/register/success', function () {
    if (!session()->has('just_registered')) {
        return redirect('/login');
    }
    session()->forget('just_registered');
    return view('auth.register-success');
})->name('register.success');

Route::get('password/confirm', [ConfirmPasswordController::class, 'showConfirmForm'])->name('password.confirm');
Route::post('password/confirm', [ConfirmPasswordController::class, 'confirm']);
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// General Authenticated Routes (accessible to both Admin and Student)
Route::middleware(['auth'])->group(function () {
    // Profile Management (accessible to both Admin and Student)
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/upload', [ProfileController::class, 'upload'])->name('profile.upload');
    Route::delete('/profile/remove', [ProfileController::class, 'remove'])->name('profile.remove');
    Route::get('/pages/{id}', [MDLPageController::class, 'show'])->name('pages.show');
    Route::get('/folders/{id}', [MDLFolderController::class, 'show'])->name('folders.show');

});
Route::middleware(['auth', 'role:3'])->group(function () {
    // ILS Questionnaire Routes
    Route::get('/kuesioner-ils/processing', [ILSKuesionerController::class, 'showProcessing'])->name('ils.ils_kuesioner_processing');
    Route::post('/kuesioner-ils/processing', [ILSKuesionerController::class, 'storeProcessing'])->name('ils.submit_processing');
    Route::get('/kuesioner-ils/perception', [ILSKuesionerController::class, 'showPerception'])->name('ils.ils_kuesioner_perception');
    Route::post('/kuesioner-ils/perception', [ILSKuesionerController::class, 'storePerception'])->name('ils.submit_perception');
    Route::get('/kuesioner-ils/input', [ILSKuesionerController::class, 'showInput'])->name('ils.ils_kuesioner_input');
    Route::post('/kuesioner-ils/input', [ILSKuesionerController::class, 'storeInput'])->name('ils.submit_input');
    Route::get('/kuesioner-ils/understanding', [ILSKuesionerController::class, 'showUnderstanding'])->name('ils.ils_kuesioner_understanding');
    Route::post('/kuesioner-ils/understanding', [\App\Http\Controllers\ILSKuesionerController::class, 'storeUnderstanding'])->name('ils.submit_understanding');
    Route::get('/kuesioner-ils/score', [ILSKuesionerController::class, 'showScore'])->name('ils.ils_score');

    // Learning Content
    Route::get('/learning-content', [LearningContentController::class, 'index'])->name('learning.content');
});

// Admin Routes (role:1, no ensure.ils)
Route::middleware(['auth', 'role:1,2'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index_admin'])->name('dashboard');

    // User Management
    Route::get('/users/search', [UsersController::class, 'search'])->name('users.search');
    Route::put('/users/approve/{id}', [UsersController::class, 'approveUser'])->name('users.approve');
    Route::resource('users', UsersController::class);
    Route::get('users/{user}', [UsersController::class, 'show'])->name('users.show');

    // Course Management
    Route::get('/courses-all', [CourseController::class, 'index'])->name('coursesadmin.index');
    Route::get('courses/management', [CourseController::class, 'management'])->name('courses.management');
    Route::get('/courses/create', [CourseController::class, 'create'])->name('course.create');
    Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
    Route::get('/courses/{id}/edit', [CourseController::class, 'edit'])->name('courses.edit');

    Route::put('/courses/{id}', [CourseController::class, 'update'])->name('courses.update');
    Route::delete('/courses/{id}', [CourseController::class, 'destroy'])->name('courses.destroy');

    Route::get('/courses/{id}/topics', [CourseController::class, 'show'])->name('courses.topics');

    //Participant Management
    //Route::post('/participants', [ParticipantController::class, 'index'])->name('participants.store');
    //Route::get('/participants/by-course/{courseId}', [ParticipantController::class, 'getParticipantsByCourse'])->name('participants.by-course');
    Route::post('/participants', [ParticipantController::class, 'store'])->name('participants.store');
    Route::get('/courses/{courseId}/participants', [ParticipantController::class, 'index'])->name('participants.index');
    Route::get('/courses/{courseId}/participants/create', [ParticipantController::class, 'create'])->name('participants.create');
    Route::put('participants/{id}', [ParticipantController::class, 'update'])->name('participants.update');
    Route::delete('/participants/{id}', [ParticipantController::class, 'destroy'])->name('participants.destroy');

    //Route::post('/participants', [ParticipantController::class, 'index'])->name('participants.store');
    // Section Management
    Route::prefix('courses/{course}')->group(function () {
        Route::get('/sections', [MDLSectionController::class, 'index'])->name('sections.index');
        Route::get('/sections/create', [MDLSectionController::class, 'create'])->name('sections.create');
        Route::post('/topics', [MDLSectionController::class, 'store'])->name('sections.store');
        Route::get('/sections/{section}', [MDLSectionController::class, 'show'])->name('sections.show');
        Route::get('/sections/{section}/edit', [MDLSectionController::class, 'edit'])->name('sections.edit');
        Route::patch('/sections/{section}', [MDLSectionController::class, 'update'])->name('sections.update');
        Route::delete('/sections/{section}', [MDLSectionController::class, 'destroy'])->name('sections.destroy');

        Route::prefix('sections/{section_id}')->group(function () {
            Route::post('/subtopics', [MDLSectionController::class, 'storeSubTopic'])->name('sections.subtopics.store');
            Route::delete('/subtopics/{subtopic_id}', [MDLSectionController::class, 'destroySubTopic'])->name('sections.subtopics.destroy');
            Route::post('/referensi', [MDLSectionController::class, 'storeReferensi'])->name('sections.referensi.store');
            Route::delete('/referensi/{referensi_id}', [MDLSectionController::class, 'destroyReferensi'])->name('sections.referensi.destroy');
        });
    });
});

// Student Routes (auth, ensure.ils)
Route::middleware(['auth','ensure.ils'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Course Management
    Route::prefix('courses')->group(function () {
        Route::get('/', [MDLCourseController::class, 'index'])->name('course.index');
        Route::get('/{course}', [MDLCourseController::class, 'show'])->name('courses.show');
        Route::get('/{course}/sections', [MDLSectionController::class, 'index'])->name('courses.sections');
        Route::get('/{course}/forum', [MDLForumController::class, 'index'])->name('courses.forum');
    });

    Route::get('/courses/{course}/participants', [MDLSectionController::class, 'participants'])
        ->name('course.participants');
    Route::post('/courses/{course}/participants', [ParticipantController::class, 'storeParticipant'])->name('participantku.store');

    Route::get('/my-courses', [MDLCourseController::class, 'index'])->name('courses.my-courses');
    Route::get('/course/{course_id}/sections', [MDLSectionController::class, 'index'])->name('course.topikmatkul');
    Route::get('/discussion-forum/{course_id}', [MDLForumController::class, 'index'])->name('courses.diskusi');

    // Learning Style Content
    Route::get('/course/{course}/sections/{section}', [TopikController::class, 'showtopikmahasiswa'])->name('topik.showtopicmahasiswa');
    Route::get('/course/{course_id}/topik/{topik}/section/{section_id}', [MDLLearningStylesController::class, 'index'])->name('learning-styles.index');

    // Individual Learning Style Routes
    Route::get('/active/{course_id}', [MDLActiveController::class, 'index'])->name('active.index');
    Route::get('/{topik}/active/{section_id}', [MDLActiveController::class, 'show'])->name('active_reflective.active');
    Route::get('/{topik}/reflective/{section_id}', [MDLReflectiveController::class, 'show'])->name('active_reflective.reflective');
    Route::get('/{topik}/sensing/{section_id}', [MDLSensingController::class, 'show'])->name('sensing_intuitive.sensing');
    Route::get('/{topik}/intuitive/{section_id}', [MDLIntuitiveController::class, 'show'])->name('sensing_intuitive.intuitive');
    Route::get('/{topik}/visual/{section_id}', [MDLVisualController::class, 'show'])->name('visual_verbal.visual');
    Route::get('/{topik}/verbal/{section_id}', [MDLVerbalController::class, 'show'])->name('visual_verbal.verbal');
    Route::get('/{topik}/sequential/{section_id}', [MDLSequentialController::class, 'show'])->name('sequential_global.sequential');
    Route::get('/{topik}/global/{section_id}', [MDLGlobalController::class, 'show'])->name('sequential_global.global');

    // Forum Routes
    Route::get('/forum/{course_id}', [MDLForumController::class, 'index'])->name('forum.show');
    Route::post('/forum/post', [MDLForumPostController::class, 'store'])->name('forum.post.store');
    Route::get('/forum-posts/{id}/edit', [MDLForumPostController::class, 'edit'])->name('forum-posts.edit');
    Route::put('/forum-posts/{id}', [MDLForumPostController::class, 'update'])->name('forum-posts.update');
    Route::delete('/forum-posts/{id}', [MDLForumPostController::class, 'destroy'])->name('forum-posts.destroy');

    // Quiz Routes
    Route::get('/quiz/{quiz_id}', [MDLQuizController::class, 'showQuiz'])->name('quiz.show');
    Route::get('/quiz/sequential/{quiz_id}', [MDLQuizController::class, 'showSequentialQuiz'])->name('quiz.sequential');
    Route::get('/quiz/global/{quiz_id}', [MDLQuizController::class, 'showGlobalQuiz'])->name('quiz.global');
    Route::post('/quiz/submit/{quiz_id}', [MDLQuizController::class, 'submitQuiz'])->name('quiz.submit');
    Route::get('/quiz/{quiz_id}/results', [MDLQuizController::class, 'showResults'])->name('quiz.results');
    Route::get('/quiz/{quiz_id}/attempt/{attempt_id}', [MDLQuizController::class, 'showAttemptDetails'])->name('quiz.attempt.details');

    // Assignment Routes
    Route::post('/assignment/submit', [MDLAssignController::class, 'submit'])->name('assignment.submit');
    Route::get('/assignments/{id}', [MDLAssignController::class, 'show'])->name('assignments.showAssignment');
    Route::post('/assignment/cancel', [MDLAssignSubmissionController::class, 'cancel'])->name('assignment.cancel');
//    Route::get('/assignment-submission/{id}', [MDLAssignSubmissionController::class, 'show'])->name('assignments.showAssignmentDosen');
});

// Public Routes
Route::resource('users', UsersController::class);
Route::get('/user', [UsersController::class, 'index'])->name('user.index');

Route::middleware(['auth', 'role:2'])->group(function () {
    // Dashboard
    Route::get('/dashboarddosen', [DashboardController::class, 'index_dosen'])->name('dashboard2');

    Route::get('/', [MDLCourseController::class, 'index'])->name('course.index');

    Route::get('/assignment/create', [MDLAssignController::class, 'create'])->name('assignments.create');
    Route::post('/assignment/store', [MDLAssignController::class, 'store'])->name('assignments.store');
    Route::get('/assignment-submission/{id}', [MDLAssignSubmissionController::class, 'show'])->name('assignments.showAssignmentDosen');
    Route::get('/assignment/{assignment}/grade/{submission}', [MDLAssignGradesController::class, 'create'])->name('assignment.grade');
    Route::post('/assignment/{assignment}/grade/{submission}', [MDLAssignGradesController::class, 'store'])->name('assignment.grade.store');

    Route::get('/forums/create', [MDLForumController::class, 'create'])->name('forums.create');
    Route::post('/forums/store', [MDLForumController::class, 'store'])->name('forums.store');

    Route::get('/files/create', [MDLFileController::class, 'create'])->name('files.create');
    Route::post('/files/store', [MDLFileController::class, 'store'])->name('files.store');

    Route::get('/folder/create', [MDLFolderController::class, 'create'])->name('folders.create');
    Route::post('/folders/store', [MDLFolderController::class, 'store'])->name('folders.store');

    Route::get('/infografis/create', [MDLInfografisController::class, 'create'])->name('infografis.create');
    Route::post('/infografis/store', [MDLInfografisController::class, 'store'])->name('infografis.store');

    Route::get('/page/create', [MDLPageController::class, 'create'])->name('pages.create');
    Route::post('/pages/store', [MDLPageController::class, 'store'])->name('pages.store');

    Route::get('/pages/{id}/edit', [MDLPageController::class, 'edit'])->name('pages.edit');
    Route::put('/pages/{id}', [MDLPageController::class, 'update'])->name('pages.update');

    Route::get('/labels/create', [MDLLabelController::class, 'create'])->name('labels.create');
    Route::post('/labels/store', [MDLLabelController::class, 'store'])->name('labels.store');

    Route::get('/url/create', [MDLUrlController::class, 'create'])->name('url.create');
    Route::post('/url/store', [MDLUrlController::class, 'store'])->name('url.store');

    Route::get('/lessons/create', [MDLLessonController::class, 'create'])->name('lessons.create');
    Route::post('/lessons/store', [MDLLessonController::class, 'store'])->name('lessons.store');

    Route::get('/quizs/create', [MDLQuizController::class, 'create'])->name('quizs.create');

    Route::post('/quiz/store', [MDLQuizController::class, 'store'])->name('quiz.store');

    Route::get('/quizs/{id}', [MDLQuizController::class, 'show'])->name('quizs.show');

    Route::get('/quiz/{quiz}/questions/create', [MDLQuizQuestionController::class, 'create'])->name('questions.create');
    Route::post('/quizes/{quiz}/questions/store', [MDLQuizQuestionController::class, 'store'])->name('questions.store');
});
Route::get('/quizsmahasiswa/{id}', [MDLQuizController::class, 'showMahasiswa'])->name('quiz.showMahasiswa');
Route::post('quiz/{id}/submit', [MDLQuizController::class, 'submit'])->name('quiz.submit');
Route::get('quiz/{quizId}/result/{attemptId}', [MDLQuizController::class, 'result'])->name('quiz.result');





