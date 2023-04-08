<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\CabinController;
use App\Http\Controllers\CabinAssignmentController;
use App\Http\Controllers\StaffAssignmentController;

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

// Route::get('/', function () {
//     return view('welcome');
// });
//Route::redirect('/', url('/login'));
Route::get('/', [CustomAuthController::class, 'index'])->name('login');
Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom'); 
Route::get('registration', [CustomAuthController::class, 'registration'])->name('register-user');
Route::post('custom-registration', [CustomAuthController::class, 'customRegistration'])->name('register.custom'); 
Route::post('signout', [CustomAuthController::class, 'signOut'])->name('signout');

// password reset
Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

Route::group(['middleware' => ['auth']], function () {
	Route::get('dashboard', [CustomAuthController::class, 'dashboard'])->name('dashboard'); 

	Route::resource('districts', DistrictController::class);
	Route::delete('districts/delete/bulk', [DistrictController::class, 'bulkDelete'])->name('districts.delete.bulk');

	Route::resource('schools', SchoolController::class);
	Route::delete('schools/delete/bulk', [SchoolController::class, 'bulkDelete'])->name('schools.delete.bulk');
	Route::post('schools/send/preSchedule', [SchoolController::class, 'sendScheduleInvite'])->name('schools.send.preSchedule');
	Route::post('schools/resend/preSchedule', [SchoolController::class, 'resendScheduleInvite'])->name('schools.resend.preSchedule');

	Route::resource('administrators', AdministratorController::class);
	Route::delete('administrators/delete/bulk', [AdministratorController::class, 'bulkDelete'])->name('administrators.delete.bulk');

	Route::resource('roles', RoleController::class);
	Route::delete('roles/delete/bulk', [RoleController::class, 'bulkDelete'])->name('roles.delete.bulk');

	Route::resource('users', UserController::class);
	Route::delete('users/delete/bulk', [UserController::class, 'bulkDelete'])->name('users.delete.bulk');

	//Route::get('emailTemplates/{name}', [EmailTemplateController::class, 'show'])->name('emailTemplates.show');
	Route::resource('emailTemplates', EmailTemplateController::class);

	Route::resource('cabins', CabinController::class);
	Route::delete('cabins/delete/bulk', [CabinController::class, 'bulkDelete'])->name('cabins.delete.bulk');

	Route::get('assignment/cabins/{week?}', [CabinAssignmentController::class, 'index'])->name('assignment.cabins');
	Route::post('assignment/cabin/block', [CabinAssignmentController::class, 'blockCabin'])->name('assignment.cabin.block');
	Route::post('assignment/cabin/autosort', [CabinAssignmentController::class, 'autoSortCabin'])->name('assignment.cabin.autosort');
	Route::get('cabin/student/{studentId}', [CabinAssignmentController::class, 'studentDetail'])->name('cabin.student.detail');
	Route::post('cabin/student/{studentId}', [CabinAssignmentController::class, 'studentUpdate'])->name('cabin.student.store');

	Route::post('assignment/cabin/update', [CabinAssignmentController::class, 'updateCabin'])->name('assignment.cabin.update');

	Route::post('staffAssignments/schedule/check', [StaffAssignmentController::class, 'checkSchedule'])->name('staffAssignments.schedule.check');
	Route::get('staffAssignments/download/PDF/{type}/{date}', [StaffAssignmentController::class, 'downloadStaffAssignmentPDF'])->name('staffAssignments.download.PDF');
	Route::get('bulletin/download/PDF/{date}', [StaffAssignmentController::class, 'downloadBulletinPDF'])->name('bulletin.download.PDF');
	Route::resource('staffAssignments', StaffAssignmentController::class);

	include(base_path('routes/scheduleRoutes.php'));
});

include(base_path('routes/preScheduleRoutes.php'));

Route::fallback( function() {
	return view('errors.404');
});

//Download File
Route::get('download/{filename}', function ($filename) {
    if(\Storage::has($filename)) {
       return \Storage::download($filename);
    } else {
        return ['status' => 404, "message" => "File Not Found"];
    }
})->where('filename', '.*')->name('download');
