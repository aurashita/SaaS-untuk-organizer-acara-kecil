<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ScannerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $events = auth()->user()->events()->withCount('registrations')->latest()->get();

    return view('dashboard', [
        'totalEvents' => $events->count(),
        'totalPeserta' => $events->sum('registrations_count'),
        'totalHadir' => auth()->user()->events()
            ->withCount(['registrations' => fn ($q) => $q->where('attendance_status', 'hadir')])
            ->get()->sum('registrations_count'),
        'eventTerbaru' => $events->take(5),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('events', EventController::class);

    Route::post('/attendance/scan', [AttendanceController::class, 'scan'])->name('attendance.scan');
    Route::get('/scanner', [ScannerController::class, 'index'])->name('scanner.index');
});

Route::get('/daftar/{event}', [RegistrationController::class, 'show'])->name('registration.show');
Route::post('/daftar/{event}', [RegistrationController::class, 'store'])->name('registration.store');
Route::get('/tiket/{registration:qr_code_hash}', [RegistrationController::class, 'success'])->name('registration.success');

require __DIR__.'/auth.php';