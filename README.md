# PHP library for SMS Gate

*This library requires a minimum PHP version of 5.6*


## Installation

To install the PHP client library to your project, we recommend using [Composer](https://getcomposer.org/).

```bash
composer require smsgate/client
```

If you're new to Composer, here are some resources that you may find useful:

* [Composer's Getting Started page](https://getcomposer.org/doc/00-intro.md) from Composer project's documentation.
* [A Beginner's Guide to Composer](https://scotch.io/tutorials/a-beginners-guide-to-composer) from the good people at ScotchBox.

## Send SMS

```php
//use composer's autoload
require 'vendor/autoload.php';

//make sure to set the real URL for bulk gate
$gate = new SMSGate\Client('http://localhost:9000/bulk_server');

$sms = new SMSGate\SMSRequest;
$sms    ->setType(SMSGate\Client::TYPE_TEXT)
        ->setAuthUsername('test')
        ->setAuthPassword('test')
        ->setSender('Test Sender')
        ->setReceiver('41587000201')
        ->setText('Hello there!')
        ////make sure to set the real URL for your webhook handler
        ->setDlrUrl('http://localhost:8000/dlr.php')
        ->setDlrMask(SMSGate\Client::DLR_MASK_STANDARD);
try {
    $response = $gate->send($sms);
} catch (\Exception $exc) {
    echo "Error sending SMS with code: " . $exc->getCode() . " and message: " . $exc->getMessage();
    exit;
}

echo "SMS sent with ID: " . $response->msgId . " and num of parts: " . $response->numParts;
```

## Receive DLRs

```php
//use composer's autoload
require 'vendor/autoload.php';

$gate = new SMSGate\Client('');

$dlr = $gate->parseDeliveryReport();
if(!isset($dlr)){
    error_log("Cannot parse DLR from the request");
    exit;
}

error_log("Received DLR: " . json_encode($dlr));
```

Check `examples` directory for more details.
To run examples locally run from the command line

```bash
cd examples
./run_srv.sh
```

and then open `http://localhost:8000/`
