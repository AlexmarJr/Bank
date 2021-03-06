<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/deposit_boleto', 'DepositTicketController@index')->name('boleto_index');
Route::post('/save_boleto', 'DepositTicketController@deposit')->name('post.boleto');

Route::get('/payment', 'PaymentController@index')->name('payment_index');
Route::get('/payment_post/{id?}', 'PaymentController@payment')->name('payment_post');
Route::get('/payment_get/{id?}', 'PaymentController@get_boleto')->name('get_boleto');

Route::get('/profile', 'ProfileController@index')->name('profile_index');
Route::get('/get_pix', 'ProfileController@get_pix')->name('get_pix');
Route::get('/delete_pix/{id?}', 'ProfileController@delete_pix')->name('delete_pix');
Route::get('/change_principal/{key?}', 'ProfileController@change_principal')->name('change_principal');
Route::post('/save_pix', 'ProfileController@save_pix')->name('post.pix');


Route::get('/add_founds', 'PaymentController@add_founds')->name('add_founds');
Route::get('/transfer', 'TransferController@index')->name('index_transfer');
Route::get('/pix_get/{type?}/{key?}', 'TransferController@pix_get')->name('pix_get');
Route::post('/post_pix', 'TransferController@post_pix')->name('post_pix');


Route::get('/withdraw', 'WithdrawController@index_withdraw')->name('index_withdraw');
Route::get('/withdraw/{id?}', 'WithdrawController@withdraw')->name('withdraw');


Route::get('/investments', 'InvestmentsController@investments_Index')->name('investments');
Route::get('/withdraw_founds', 'InvestmentsController@withdraw_founds')->name('withdraw_founds');
Route::get('/investments/{id?}', 'InvestmentsController@investments_post')->name('investments_post');
