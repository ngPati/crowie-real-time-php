<?php
require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload
use Crowie\Realtime;

Realtime::init('crw_test_4bcc8ec0-dd72-499f-b6f6-464ba89ddb94');


//echo '
//';
//echo Realtime::generateJwt(1);
//
echo Realtime::send(1, 'message', 'sss');
//echo Realtime::joinRoom('1', 'dsadasdas');

//echo Realtime::sendToRoom('dsadasdas', 'message', 'kjfhaksufhaksfh');
//
//echo Realtime::joinRoom('1', 'test-room');
//echo '
//';
//echo Realtime::online('test-room');


//echo Realtime::sendToRoom('test-room', 'message', 'room works');
//
//

//echo Crw::send();
