<?php

use App\Http\Controllers\SchoolController;
use App\Http\Controllers\ScheduleController;

Route::get('preSchedule/{inviteId}', [SchoolController::class, 'preSchedule'])->name('schools.form.preSchedule');
Route::post('preSchedule', [SchoolController::class, 'storePreSchedule'])->name('schools.store.preSchedule');
Route::get('preSchedule/invite/success', [SchoolController::class, 'successPreSchedule'])->name('schools.success.preSchedule');
Route::get('schedule/teacher/registration/{scheduleId}', [ScheduleController::class, 'teacherRegistration'])->name('schedule.teacher.registration');
Route::post('schedule/student/store', [ScheduleController::class, 'storeStudentInfo'])->name('schedule.student.store');
Route::get('schedule/teacher/success/registration', [ScheduleController::class, 'teacherRegistrationSuccess'])->name('schedule.teacher.registration.success');
Route::get('schedule/meal/registration/{scheduleId}', [ScheduleController::class, 'mealRegistration'])->name('schedule.meal.registration');
Route::post('schedule/meal/store', [ScheduleController::class, 'storeMealInfo'])->name('schedule.meal.store');
Route::get('schedule/meal/success', [ScheduleController::class, 'mealRegistrationSuccess'])->name('schedule.meal.success');