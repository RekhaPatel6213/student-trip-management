<?php
	use App\Http\Controllers\TripController;
	use App\Http\Controllers\ScheduleController;

	//Route::get('trips/days', [TripController::class, 'dayTripList'])->name('trips.list.day');
	Route::get('trips/{type?}/{village?}', [TripController::class, 'index'])->name('trips.index');//->whereAlpha('type');
	//Route::resource('trips', TripController::class);
	//Route::get('daytrips', [TripController::class, 'dayTripList'])->name('trips.list.day');
	//Route::delete('trips/delete/bulk', [TripController::class, 'bulkDelete'])->name('trips.delete.bulk');

	Route::prefix('schedule')->name('schedule.')->group(function () {
		Route::get('{schedule}', [ScheduleController::class, 'show'])->name('trip.show');
		Route::post('update', [ScheduleController::class, 'update'])->name('trip.update');
		Route::post('status/update', [ScheduleController::class, 'statusUpdate'])->name('trip.status.update');
		Route::delete('{schedule}', [ScheduleController::class, 'destroy'])->name('trip.destroy');
		Route::post('confirm', [ScheduleController::class, 'confirm'])->name('trip.confirm');
		Route::get('confirm/success', [ScheduleController::class, 'confirmSuccess'])->name('trip.confirm.success');
		Route::get('bill/{scheduleId}', [ScheduleController::class, 'billInfo'])->name('trip.bill');
		Route::get('bill/PDF/{scheduleId}', [ScheduleController::class, 'billPDF'])->name('trip.billPDF');
		Route::post('mail/send', [ScheduleController::class, 'sendMail'])->name('trip.mail.send');
		Route::post('bill/updateStatus', [ScheduleController::class, 'updateBillStatus'])->name('bill.update.status');
		Route::get('calendar/trip', [ScheduleController::class, 'calendarView'])->name('calendar.view');
		Route::get('trip/list/{type?}/{village?}', [ScheduleController::class, 'tripList'])->name('trip.list');
		Route::get('list/{date}', [ScheduleController::class, 'tripDateList'])->name('trip.list.date');
		Route::get('schedule/trip/class/info/{scheduleId}', [ScheduleController::class, 'tripClassInfo'])->name('trip.class.info');
		Route::delete('schedule/student/delete', [ScheduleController::class, 'studentDelete'])->name('student.delete');
	});
?>