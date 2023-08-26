<?php

// testing

// display all php errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Ay4t\Helper\HP;

require_once './vendor/autoload.php';

/* $helper = HP::Formatter('Phone');
$helper->set('085791555506', 'ID');

// jika Anda ingin mengambil hanya integer saja, maka gunakan method onlyInteger()
$helper->onlyInteger(true);

// untuk mendapatkan hasil format, gunakan method getResult()
$result = $helper->getResult();
var_dump( $result );


$helper = HP::Formatter('Currency');
$helper->set('3123123', 'IDR', 2);

// jika anda ingin mengubah menjadi fungsi terbilang
$helper->counted();

$result = $helper->getResult();
var_dump( $result ); */


// semua contoh dan cara penggunaan mengikuti :
// https://carbon.nesbot.com/docs/
/* $helper = HP::Formatter('Datetime');
$result     = $helper::now()->toDateTimeString();
var_dump( $result ); */


// $helper = HP::Formatter('Datetime');
// $helper::now();
// $helper->add(1, 'day');

// /* $result     = $helper->toDateTimeString();
// // atau
// $result     = $helper->format('Y-m-d H:i:s'); */
// // atau
// $result     = $helper->isoFormat('dddd D');
// var_dump( $result );

$no     = [
    '085791555506',
    '6285791555506',
    '+6285791555506',
    '85791555506',
    '085 791 555 506',
];

foreach ($no as $key => $value) {
    $helper = HP::Formatter('Phone');
    $helper->set($value, 'ID');
    $helper->onlyInteger(true);
    $result = $helper->getResult();
    var_dump( $result );
}