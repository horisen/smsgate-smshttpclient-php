<?php

/**
 * SMSGate main class
 *
 * @author milan
 * @copyright (c) 2019
 */

namespace SMSGate;

use Http\Client\HttpClient;
use Zend\Diactoros\Request;
use Zend\Diactoros\ServerRequestFactory;
use Psr\Http\Message\ServerRequestInterface;

class Client
{

    // TypeText is SMS type for sending text SMS
    const TYPE_TEXT = 'text';
    // TypeWSI is SMS type for sending Binary WAP Service Indication SMS
    const TYPE_WSI = 'wsi';
    // DCSGSM is data coding scheme - GSM
    const DCS_GSM = 'gsm';
    // DCSUCS is data coding scheme - UCS2
    const DCS_UCS = 'ucs';
    const DLR_MASK_DELIVERED = 1;
    const DLR_MASK_UNDELIVERED = 2;
    const DLR_MASK_BUFFERED = 4;
    const DLR_MASK_SENTTOSMSC = 8;
    const DLR_MASK_REJECTED = 16;
    const DLR_MASK_NONE = 0;
    const DLR_MASK_STANDARD = (self::DLR_MASK_DELIVERED | self::DLR_MASK_UNDELIVERED | self::DLR_MASK_REJECTED);
    // DLREventDelivered is DLR event when SMS is delivered
    const DLR_EVENT_DELIVERED = 'DELIVERED';
    // DLREventUndelivered is DLR event when SMS is udelivered
    const DLR_EVENT_UNDELIVERED = 'UNDELIVERED';
    // DLREventBuffered  is DLR event when SMS is buffered
    const DLR_EVENT_BUFFERED = 'BUFFERED';
    // DLREventSentToSMSC  is DLR event when SMS is sent to SMSC
    const DLR_EVENT_SENTTOSMSC = 'SENT_TO_SMSC';
    // DLREventRejected  is DLR event when SMS is rejected
    const DLR_EVENT_REJECTED = 'REJECTED';
    // DLREventExpired  is DLR event when SMS is expired
    const DLR_EVENT_EXPIRED = 'EXPIRED';
    // DLREventUnknown  is DLR event when SMS is unknown
    const DLR_EVENT_UNKNOWN = 'UNKNOWN';

    /**
     * HTTP Client
     * @var HttpClient
     */
    protected $httpClient;

    /**
     *
     * @var string
     */
    protected $submitURL;
    
    /**
     * Provide real smsgate URL, if $httpClient not provided, the lib will use
     * Guzzle6 as default HttpClient PSR-18 implementation
     * 
     * @param string $submitURL
     * @param HttpClient $httpClient
     */
    public function __construct($submitURL, HttpClient $httpClient = null)
    {
        if (is_null($httpClient)) {
            $httpClient = new \Http\Adapter\Guzzle6\Client();
        }
        $this->setHTTPClient($httpClient);
        $this->setSubmitURL($submitURL);
    }

    /**
     * 
     * @return HttpClient
     */
    public function getHTTPClient()
    {
        return $this->httpClient;
    }
    
    /**
     * Set HttpClient PSR-18
     * 
     * @param HttpClient $httpClient
     * @return $this
     */
    public function setHTTPClient(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
        return $this;
    }

    public function getSubmitURL()
    {
        return $this->submitURL;
    }

    public function setSubmitURL($submitURL)
    {
        $this->submitURL = $submitURL;
        return $this;
    }

    /**
     * Send SMS message
     * 
     * @param SMSRequest|array $message
     * @throws Exception\Request
     * 
     * @return SMSResponse
     */
    public function send($message)
    {
        if (!$message instanceof SMSRequest) {
            $message = SMSRequest::fromArray($message);
        }
        $params = $message->toArray();

        $request = new Request($this->getSubmitURL(), 'POST', 'php://temp', ['content-type' => 'application/json']);
        $request->getBody()->write(json_encode($params));

        $response = $this->httpClient->sendRequest($request);
        $response->getBody()->rewind();
        $data = json_decode($response->getBody()->getContents(), true);

        //has error
        if (isset($data['error'])) {
            $errCode = isset($data['error']['code']) ? $data['error']['code'] : 0;
            $errMessage = isset($data['error']['message']) ? $data['error']['message'] : "Unknown error";
            throw new ApiException($errMessage, $errCode);
        }

        if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 300) {
            throw new ApiException("Invalid HTTP Code", $response->getStatusCode());
        }

        return SMSResponse::fromArray($data);
    }

    /**
     * Parse delivery report object from the request
     * If $request is null, it will be obtained from the globals
     * 
     * @param ServerRequestInterface $request
     * @return DeliveryReport|null
     */
    public function parseDeliveryReport(ServerRequestInterface $request = null)
    {
        if (!isset($request)) {
            $request = ServerRequestFactory::fromGlobals();
        }
        if (is_null($request)) {
            return null;
        }
        $params = json_decode((string) $request->getBody(), true);
        if(!is_array($params)){
            return null;
        }
        $dlr = DeliveryReport::fromArray($params);
        return $dlr;
    }

}
