<?php

// display all php errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Ay4t\Helper\HP;

require_once './vendor/autoload.php';

$a= HP::terbilang( 1000, 'id_ID' );
var_dump($a);

// contoh untuk format phone number
/* echo HP::phoneNumber( '085791555506', 'ID' ); */

/* $helper     = new HP();
$helper->setOnlyInteger(true);
echo $helper->phoneNumber( '085791555506', 'ID' ); */


// echo HP::currency( 1000000, 'USD', 2 );

/* $helper     = new HP();
$helper->setUseSpaceSymbol(true);
echo $helper->currency( 1000000, 'IDR', 2 ); */