<?php

require '../vendor/autoload.php';


$gate = new SMSGate\Client('http://localhost:9000/bulk_server');

$sms = new SMSGate\SMSRequest;
$sms    ->setType(SMSGate\Client::TYPE_TEXT)
        ->setAuthUsername('test')
        ->setAuthPassword('test')
        ->setSender('Test Sender')
        ->setReceiver('41587000201')
        ->setText('Hello there!');
try {
    $response = $gate->send($sms);
} catch (\Exception $exc) {
    echo "Error sending SMS with code: " . $exc->getCode() . " and message: " . $exc->getMessage();
    exit;
}

echo "SMS sent with ID: " . $response->msgId . " and num of parts: " . $response->numParts;





