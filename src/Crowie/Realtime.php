<?php

namespace Crowie;
//require "vendor/autoload.php";

use \Firebase\JWT\JWT;

class Realtime
{
    static $privateApiKey;
    static $serverUrl;

    // prevent creating multiple instances due to "private" constructor
    private function __construct()
    {
    }

    public static function init($privateApiKey)
    {
        self::$privateApiKey = $privateApiKey;
        $result = self::get('http://ngcrow.io:8080/register-server');
        if ($result !== FALSE) {
            self::$serverUrl = base64_decode($result);
            return true;
        } else {
            echo 'Error while initialising library.';
            return false;
        }
    }

    public static function send($id, $channel, $message)
    {
        $result = self::post(self::$serverUrl . '/send', array('user_id' => $id, 'channel' => $channel, 'message' => $message));
        if ($result !== FALSE) {
            return $result;
        } else {
            echo 'Error while sending data.';
            return false;
        }
    }

    public static function joinRoom($id, $roomName)
    {
        $result = self::post(self::$serverUrl . '/room/join', array('user_id' => $id, 'roomName' => $roomName));
        if ($result !== FALSE) {
            return $result;
        } else {
            echo 'Error while joining room.';
            return false;
        }
    }

    public static function leaveRoom($id, $roomName)
    {
        $result = self::post(self::$serverUrl . '/room/leave', array('user_id' => $id, 'roomName' => $roomName));
        if ($result !== FALSE) {
            return $result;
        } else {
            echo 'Error while leaving room.';
            return false;
        }
    }

    public static function sendToRoom($roomName, $channel, $message)
    {
        $result = self::post(self::$serverUrl . '/room/send', array('roomName' => $roomName, 'channel' => $channel, 'message' => $message));
        if ($result !== FALSE) {
            return $result;
        } else {
            echo 'Error while sending message to room.';
            return false;
        }
    }

    public static function online($room = null)
    {
        $result = $room ? self::post('http://ngcrow.io:8080/online' . '/' . $room, array()) : self::post('http://ngcrow.io:8080/online', array());
        if ($result !== FALSE) {
            return $result;
        } else {
            echo 'Error while getting online count.';
            return false;
        }
    }

    public static function onlineByUserIds($userIdsList)
    {
        $result = self::post('http://ngcrow.io:8080/online', array('idList' => $userIdsList));
        if ($result !== FALSE) {
            return $result;
        } else {
            echo 'Error while getting online count.';
            return false;
        }
    }


    public static function generateJwt($userId, $additionalData = null, $expirationInSeconds = 86400)
    {
        if (!self::$privateApiKey) {
            echo "You need to initialise the library. Please call the Realtime::init('privateApiKey') function first.";
            return false;
        }
        $secret_key = self::$privateApiKey;
        $issuer_claim = "THE_ISSUER"; // this can be the servername
        $audience_claim = "THE_AUDIENCE";
        $issuedat_claim = time(); // issued at
        $notbefore_claim = $issuedat_claim + 10; //not before in seconds
        $expire_claim = $issuedat_claim + $expirationInSeconds; // expire time in seconds
        $token = array(
            "iss" => $issuer_claim,
            "aud" => $audience_claim,
            "iat" => $issuedat_claim,
            "nbf" => $notbefore_claim,
            "exp" => $expire_claim,
            "data" => array(
                "user_id" => $userId
            ));
        if ($additionalData) {
            $token['data']['data'] = $additionalData;
        }
        // Return JWT
        return JWT::encode($token, $secret_key);
    }

    private static function get($url)
    {
        $options = array(
            'http' => array(
                'header' => "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n" .
                    'Authorization: ' . self::$privateApiKey,
                'method' => 'GET'
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === FALSE) {
            /* Handle error */
            echo 'Error while making GET.';
            return false;
        } else {
            return $result;
        }
    }

    private static function post($url, $json)
    {
        $opts = array('http' =>
            array(
                'method' => 'POST',
                'header' => "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n" .
                    'Authorization: ' . self::$privateApiKey,
                'content' => json_encode($json)
            )
        );
        $result = file_get_contents($url, false, stream_context_create($opts));
        if ($result === FALSE) { /* Handle error */
            echo 'Error while making POST.';
            return false;
        } else {
            return $result;
        }
    }
}
