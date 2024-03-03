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
    return view('auth.login');
});


Auth::routes();
//Auth::routes(['register' => false]);


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('invoices',InvoicesController::class);
Route::resource('sections',SectionsController::class);
Route::resource('products',ProductsController::class);
Route::resource('InvoiceAttachments',InvoiceAttachmentsController::class);
Route::resource('Achive',InvoiceAchiveController::class);

Route::get('/section/{id}','InvoicesController@getproducts');
Route::get('/InvoicesDetails/{id}','InvoicesDetailsController@edit');
Route::get('View_file/{invoice_number}/{file_name}','InvoicesDetailsController@open_file');
Route::get('download/{invoice_number}/{file_name}','InvoicesDetailsController@get_file');
Route::post('delete_file', 'InvoicesDetailsController@destroy')->name('delete_file');
Route::get('/edit_invoice/{id}','InvoicesController@edit');
Route::get('/Status_show/{id}','InvoicesController@show')->name('Status_show');
Route::post('/Status_update/{id}','InvoicesController@Status_update')->name('Status_update');
Route::get('invoices_paid','InvoicesController@invoices_paid');
Route::get('invoices_partial','InvoicesController@invoices_partial');
Route::get('invoices_unpaid','InvoicesController@invoices_unpaid');
Route::post('archive','InvoicesController@archive');
Route::get('print_invoice/{id}','InvoicesController@print_invoice');
Route::get('reports','Invoices_Report@index');
Route::post('searsh_invoices', 'Invoices_Report@searsh_invoices');
Route::get('Customers_Report', 'Customers_Report@index');
Route::post('searsh_customers', 'Customers_Report@searsh_customers');
Route::get('markasRead_All','InvoicesController@markasRead_All');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    });


Route::get('/{page}', 'AdminController@index');



