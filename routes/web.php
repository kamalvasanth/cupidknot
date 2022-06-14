<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Auth\LoginController;

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

Route::get('/', function () {
    return redirect()->route('home');
});
Route::get('/auth/google/redirect',[LoginController::class,'googleRedirect']);
// Route::get('/auth/google/redirect',function(){
//     return Socialite::driver('google')->stateless()->redirect();
// });
Route::get('/auth/google/callback',[LoginController::class,'handleGoogleCallback']);



// Route::get('auth/google/callback',function(){
//     try {
//         $user     = Socialite::driver('google')->stateless()->user();
//         $finduser = User::where('google_id', $user->id)->first();
//         if ($finduser) {
//             Auth::login($finduser);
//             return  redirect('/home');
//         } else {
//             $newUser = User::create([
//             'first_name' => $user->name,
//             'email' => $user->email,
//             'google_id'=> $user->id
//         ]);
//             Auth::login($newUser);
//             return redirect('/home');
//         }
//     }
//         catch (Exception $e) {      
//         return redirect('/home');
//     }
    
// });


Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/users/{user_id}/edit', [UserController::class, 'edit'])->name('user.edit');
Route::post('/users/{user_id}/update', [UserController::class, 'update'])->name('user.update');
Route::get('/report/users', [UserController::class, 'report'])->name('users.report');
