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

Route::get('google-sheet','GoogleSheetController@index');
Route::get('google-sheet/form','GoogleSheetController@create');
Route::post('google-sheet/store','GoogleSheetController@store');


Route::get('dropboxFileUpload', 'DropboxController@dropboxFileUpload');



Route::get('imap','IMAPController@index');
Route::get('imap/view','IMAPController@view');
Route::get('imap/read','IMAPController@read');