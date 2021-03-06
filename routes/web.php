<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () {
    return view("list-nasabah");
});

$router->get('customer', function () {
    return view("list-nasabah");
});

$router->get('transaction', function () {
    return view("list-transaksi");
});

$router->get('tabungan', function () {
    return view("report-buku-tabungan");
});

$router->get('poin', function () {
    return view("show-point");
});

$router->get("nasabah", "NasabahController@showAllNasabah");
$router->get("select-nasabah", "NasabahController@nasabahForSelect2");
$router->post("nasabah", "NasabahController@insertNasabah");

$router->get("transaksi", "TransaksiController@index");
$router->post("transaksi", "TransaksiController@store");

$router->get("cek-poin", "TransaksiController@show_point");

$router->post("cetak-tabungan", "TransaksiController@print_tabungan");