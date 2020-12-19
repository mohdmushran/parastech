<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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
use App\Http\Controllers\UsersController;

Route::get('/', function () {
    return redirect('login');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', [UsersController::class, 'dashboard'])->name('dashboard');
    Route::get('/user/subscribe/{id}', [UsersController::class, 'subscribe'])->name('subscribe');

//    Route::get('/billing-portal', function (Request $request) {
//        $url = $request->user()->billingPortalUrl(route('billing'));
//        dd($url);
//        return $request->user()->redirectToBillingPortal();
//    });
});
