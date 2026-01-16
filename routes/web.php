<?php

use App\Http\Controllers\SubmissionController;
use Illuminate\Support\Facades\Route;

// Redirect home to form
Route::get('/', function () {
    return redirect()->route('submissions.create');
});

// Form để điền thông tin
Route::get('/form', [SubmissionController::class, 'create'])->name('submissions.create');
Route::post('/form', [SubmissionController::class, 'store'])->name('submissions.store');

// Trang cảm ơn sau khi submit
Route::get('/success', [SubmissionController::class, 'success'])->name('submissions.success');

// Photo Wall để trình chiếu
Route::get('/wall', [SubmissionController::class, 'wall'])->name('submissions.wall');

// API endpoint để lấy submissions mới (cho auto-refresh)
Route::get('/api/submissions', [SubmissionController::class, 'getSubmissions'])->name('api.submissions');
