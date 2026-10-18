<?php

use App\Http\Controllers\Admin\AdminAuditLogController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminPaymentController;
use App\Http\Controllers\Admin\AdminPlanController;
use App\Http\Controllers\Admin\AdminSubscriptionController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DueController;
use App\Http\Controllers\MessDepositController;
use App\Http\Controllers\MessExpenseController;
use App\Http\Controllers\MessMealController;
use App\Http\Controllers\MessMemberController;
use App\Http\Controllers\MessReportController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Webhook\PaymentWebhookController;
use App\Http\Controllers\WorkspaceController;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('subscription', [SubscriptionController::class, 'index'])->name('subscription.index');

    // Personal/Business accounting (read)
    Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::get('transactions/{transaction}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');

    // Personal/Business accounting (write, subscription required)
    Route::middleware('subscription.access')->group(function () {
        Route::post('transactions', [TransactionController::class, 'store'])->name('transactions.store');
        Route::put('transactions/{transaction}', [TransactionController::class, 'update'])->name('transactions.update');
        Route::delete('transactions/{transaction}', [TransactionController::class, 'destroy'])->name('transactions.destroy');

        Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

        Route::post('subscription/checkout', [SubscriptionController::class, 'checkout'])->name('subscription.checkout');

        // Dues (write)
        Route::post('contacts', [DueController::class, 'storeContact'])->name('contacts.store');
        Route::post('dues', [DueController::class, 'storeDue'])->name('dues.store');
        Route::post('dues/{due}/payments', [DueController::class, 'storePayment'])->name('dues.payments.store');

        // Mess workspaces (write)
        Route::post('workspaces', [WorkspaceController::class, 'store'])->name('workspaces.store');
        Route::post('workspaces/{workspace}/members', [MessMemberController::class, 'store'])->name('mess.members.store');
        Route::put('workspaces/{workspace}/members/{member}', [MessMemberController::class, 'update'])->name('mess.members.update');
        Route::post('workspaces/{workspace}/meals', [MessMealController::class, 'store'])->name('mess.meals.store');
        Route::post('workspaces/{workspace}/expenses', [MessExpenseController::class, 'store'])->name('mess.expenses.store');
        Route::delete('workspaces/{workspace}/expenses/{expense}', [MessExpenseController::class, 'destroy'])->name('mess.expenses.destroy');
        Route::post('workspaces/{workspace}/deposits', [MessDepositController::class, 'store'])->name('mess.deposits.store');
    });

    // Dues read
    Route::get('dues', [DueController::class, 'index'])->name('dues.index');

    // Mess read
    Route::get('workspaces', [WorkspaceController::class, 'index'])->name('workspaces.index');
    Route::get('workspaces/create', [WorkspaceController::class, 'create'])->name('workspaces.create');
    Route::get('workspaces/{workspace}', [WorkspaceController::class, 'show'])->name('workspaces.show');
    Route::get('workspaces/{workspace}/reports/monthly', [MessReportController::class, 'monthly'])->name('mess.reports.monthly');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

Route::post('webhooks/payments', PaymentWebhookController::class)
    ->withoutMiddleware([PreventRequestForgery::class])
    ->name('webhooks.payments');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('users/{user}', [AdminUserController::class, 'show'])->name('users.show');
    Route::post('users/{user}/suspend', [AdminUserController::class, 'suspend'])->name('users.suspend');
    Route::post('users/{user}/reactivate', [AdminUserController::class, 'reactivate'])->name('users.reactivate');

    Route::get('subscriptions', [AdminSubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::post('subscriptions/{subscription}/extend', [AdminSubscriptionController::class, 'extend'])->name('subscriptions.extend');

    Route::get('payments', [AdminPaymentController::class, 'index'])->name('payments.index');

    Route::get('plans', [AdminPlanController::class, 'index'])->name('plans.index');
    Route::post('plans', [AdminPlanController::class, 'store'])->name('plans.store');
    Route::put('plans/{plan}', [AdminPlanController::class, 'update'])->name('plans.update');

    Route::get('audit-logs', [AdminAuditLogController::class, 'index'])->name('audit-logs.index');
});
