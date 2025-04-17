<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Reunion\ReservationController;
use App\Http\Controllers\Reunion\SalleController;
use App\Models\Reunion\Reservation;
use App\Models\Reunion\Salle;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    //
    // Profil
    //
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //
    // salle
    //
    Route::get('/salle/corbeille', [SalleController::class, 'corbeille'])->name('salle.corbeille');

    Route::get('/salle/{salle_id}/undelete', [SalleController::class, 'undelete'])->name('salle.undelete');
    Route::bind('salle_id', function ($salle_id) {
        return salle::onlyTrashed()->find($salle_id);
    });
    Route::get('/salle/json', [salleController::class, 'json'])->name('salle.json');
    Route::resource('/salle', SalleController::class);

    //
    // reservation
    //
    Route::get('/reservation/{reservation_id}/undelete', [ReservationController::class, 'undelete'])->name('reservation.undelete');
    Route::bind('reservation_id', function ($reservation_id) {
        return reservation::onlyTrashed()->find($reservation_id);
    });
    Route::get('/reservation/json', [ReservationController::class, 'json'])->name('reservation.json');
    Route::resource('/reservation', ReservationController::class);
});

require __DIR__ . '/auth.php';
