<?php

use App\Http\Controllers\Reunion\ReservationController;
use App\Http\Controllers\Reunion\SalleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use App\Models\User;
use App\Models\Reunion\Reservation;
use App\Models\Reunion\Salle;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', [WelcomeController::class, 'index'])->name('home');

    //
    // Profil
    //
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route::resource('/planning', PlanningController::class);
    // Route::resource('/absence', AbsenceController::class);

    //
    // Salle
    //
    Route::get('/Salle/{Salle_id}/undelete', [SalleController::class, 'undelete'])->name('Salle.undelete');
    Route::bind('Salle_id', function ($Salle_id) {
        return Salle::onlyTrashed()->find($Salle_id);
    });
    Route::get('/Salle/json', [SalleController::class, 'json'])->name('Salle.json');
    Route::resource('/Salle', SalleController::class);

    //
    // Reservation
    //
    Route::get('/Reservation/{Reservation_id}/undelete', [ReservationController::class, 'undelete'])->name('Reservation.undelete');
    Route::bind('Reservation_id', function ($Reservation_id) {
        return Reservation::onlyTrashed()->find($Reservation_id);
    });
    Route::get('/Reservation/json', [ReservationController::class, 'json'])->name('Reservation.json');
    Route::resource('/Reservation', ReservationController::class);
});

require __DIR__ . '/auth.php';
