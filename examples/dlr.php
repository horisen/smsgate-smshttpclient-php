<?php

require '../vendor/autoload.php';


$gate = new SMSGate\Client('');

$dlr = $gate->parseDeliveryReport();
if(!isset($dlr)){
    error_log("Cannot parse DLR from the request");
    exit;
}

error_log("Received DLR: " . json_encode($dlr));

