<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\ChargeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserApproveController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::resource('budgets', BudgetController::class);
    Route::resource('charges', ChargeController::class);

    Route::get('/budgets/{budget}/pdf', [PDFController::class, 'downloadPDF'])->name('budgets.pdf');


    // Route::get('/status', [UserApproveController::class, 'index'])->name('status.index');
    // Route::get('/status/edit/{id}', [UserApproveController::class, 'edit'])->name('status.edit');
    // Route::post('/status/update', [UserApproveController::class, 'update'])->name('status.update');

    Route::middleware('admin')->group(function () {
        Route::get('/status', [UserApproveController::class, 'index'])->name('status.index');
        Route::get('/status/edit/{id}', [UserApproveController::class, 'edit'])->name('status.edit');
        Route::post('/status/update', [UserApproveController::class, 'update'])->name('status.update');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::middleware(['auth', 'admin'])->group(function () {
//     Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users.index');
//     Route::patch('/admin/users/{user}/approve', [AdminController::class, 'approve'])->name('admin.users.approve');
// });

require __DIR__ . '/auth.php';
