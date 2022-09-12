<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\InvoicesArchiveController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ReportsController;


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
    return view('auth.login');
});
Route::get('/register', function () {
    return view('auth.register');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->middleware('user_activation')->name('home');
Route::get('/test_mail', [App\Http\Controllers\HomeController::class, 'sendEmailReminder']);

Route::resource('invoices','App\Http\Controllers\InvoiceController');
Route::resource('sections','App\Http\Controllers\SectionController');
Route::resource('products','App\Http\Controllers\ProductController');
Route::resource('InvoicesDetails','App\Http\Controllers\InvoicesDetailsController');
Route::resource('InvoicesArchive','App\Http\Controllers\InvoicesArchiveController');
Route::resource('users','App\Http\Controllers\UserController');
Route::resource('roles','App\Http\Controllers\RoleController');

Route::get('/section/{id}', 'App\Http\Controllers\InvoiceController@getProducts');
Route::get('/invoices/edit/{id}', 'App\Http\Controllers\InvoiceController@edit');
Route::get('/invoices/print_invoice/{id}', 'App\Http\Controllers\InvoiceController@print_invoice');
Route::get('/invoices/change_payment/{id}', 'App\Http\Controllers\InvoiceController@change_payment');
Route::post('/invoices/update_payment_status', 'App\Http\Controllers\InvoiceController@update_payment_status')->name('update_status');
Route::get('/paied_invoices', 'App\Http\Controllers\InvoiceController@paied_invoices');
Route::get('/partial_paied_invoices', 'App\Http\Controllers\InvoiceController@partial_paied_invoices');
Route::get('/unpaied_invoices', 'App\Http\Controllers\InvoiceController@unpaied_invoices');
Route::get('/read_all_notifications', 'App\Http\Controllers\InvoiceController@read_all');
Route::get('export_invoices', 'App\Http\Controllers\InvoiceController@export');


Route::get('/reports', 'App\Http\Controllers\ReportsController@index');
Route::post('/search_invoice', 'App\Http\Controllers\ReportsController@search_invoice');
Route::get('/users_reports', 'App\Http\Controllers\ReportsController@users_reports');
Route::post('/search_users_reports', 'App\Http\Controllers\ReportsController@search_users_reports');




Route::get('/invoiceDetails/{id}', 'App\Http\Controllers\InvoicesDetailsController@show');
Route::get('/view-Attachment/{invoice_number}/{file_name}', 'App\Http\Controllers\InvoicesDetailsController@open_file');
Route::post('/invoiceDetails/addAttachment', 'App\Http\Controllers\InvoicesDetailsController@addAttachment');
Route::get('/download-Attachment/{invoice_number}/{file_name}', 'App\Http\Controllers\InvoicesDetailsController@download_file');

Route::get('/{page}', 'App\Http\Controllers\AdminController@index');



Route::get('/send/email', [App\Http\Controllers\HomeController::class, 'sendEmailReminder']);
