<?php
require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload
use Crowie\Realtime;
echo 'sadas';
Realtime::init('crw_live_c381cb57-c819-48ff-9b11-236406fa173a');


//echo '
//';
//echo Realtime::generateJwt(1);
//
echo Realtime::send(1, 'message', 'ahojky');
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
