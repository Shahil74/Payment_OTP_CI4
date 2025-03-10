<?php
use Twilio\Rest\Client;
function sendSms($to, $message) {
    $sid = 'ACaca3ecbb34ae3a51b57500c45867483b';
    $token ='785da5d26d40238d83f241f9c5beb04e';
    $from = '+19803936836';
    try {
        $client = new Client($sid, $token);
        $client->messages->create($to, [
            'from' => $from,
            'body' => $message
        ]);
        return true;
    } catch (Exception $e) {
        log_message('error', 'Twilio Error: ' . $e->getMessage());
        return false;
    }
}
