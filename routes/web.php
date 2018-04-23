<?php

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

$this->get('/', ['as' => 'index', 'uses' => 'HomeController@index']);
$this->get('/country-list',
    ['as' => 'country-list', 'uses' => 'HomeController@countryList']);
$this->get('/download-csv',
    ['as' => 'download-csv', 'uses' => 'HomeController@downloadCsv']);
