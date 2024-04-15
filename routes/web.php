<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
//use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/login',[AdminController::class,'login'])->name('login');;
//Route::post('/login',[AdminController::class,'login']);

Route::get('/', function(){
return view('welcome');
});

//Auth::routes();

Route::prefix('user')->name('user.')->group(function(){
           
    Route::middleware(['guest:web', 'PreventBackHistory'])->group(function(){
        Route::view('/login','dashboard.user.login')->name('login');
        Route::view('/register','dashboard.user.register')->name('register');
        Route::post('/create',[UserController::class,'create'])->name('create');
        Route::post('/check',[UserController::class,'check'])->name('check');
        Route::get('/verify',[UserController::class,'verify'])->name('verify'); 

        Route::get('/password/forgot', [UserController::class,'showForgotForm'])->name('forgot.password.form');
        Route::post('/password/forgot',[UserController::class,'sendResetLink'])->name('forgot.password.link');
        Route::get('/password/reset/{token}',[UserController::class, 'showResetForm'])->name('reset.password.form');
        Route::post('/password/reset',[UserController::class,'resetPassword'])->name('reset.password');

    });
    
    Route::middleware(['auth:web', 'is_user_verify_email', 'PreventBackHistory'])->group(function(){
        Route::view('/home','dashboard.user.home')->name('home');
        Route::post('/logout',[UserController::class,'logout'])->name('logout');
    });

});

Route::prefix('admin')->name('admin.')->group(function(){
    Route::middleware(['guest:admin','PreventBackHistory'])->group(function(){
        Route::view('/login','dashboard.admin.login')->name('login');
        Route::post('/check',[AdminController::class,'check'])->name('check');
    });

    Route::middleware(['auth:admin','PreventBackHistory'])->group(function(){
        Route::view('/home','dashboard.admin.home')->name('home');
        Route::post('/logout',[AdminController::class,'logout'])->name('logout');
    });
});
// Route::get('login', [LoginController::class, 'login'])->name('login');
// Route::post('login', [LoginController::class, 'login']);

// Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
// Route::post('register', [RegisterController::class, 'register']);

// Route::group(['middleware' => 'auth'], function () {
//     Route::get('/logout', [LoginController::class, 'logout']);
// });
