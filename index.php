<?php

use Ay4t\Helper\HP;

require_once './vendor/autoload.php';

// contoh untuk format phone number
echo HP::phoneNumber( '085791555506', 'ID' );

$helper     = new HP();
$helper->setOnlyInteger(true);
echo $helper->phoneNumber( '085791555506', 'ID' );


// echo HP::currency( 1000000, 'USD', 2 );

/* $helper     = new HP();
$helper->setUseSpaceSymbol(true);
echo $helper->currency( 1000000, 'IDR', 2 ); */