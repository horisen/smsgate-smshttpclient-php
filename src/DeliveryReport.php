<?php

/**
 * DeliveryReport class
 *
 * @author milan
 * @copyright (c) 2019
 */

namespace SMSGate;


class DeliveryReport
{
    /**
     *
     * @var string
     */
    public $msgId;
    /**
     *
     * @var string
     */
    public $event;
    /**
     *
     * @var int
     */
    public $errorCode;
    /**
     *
     * @var string
     */
    public $errorMessage;
    /**
     *
     * @var int 
     */
    public $partNum;
    /**
     *
     * @var int 
     */    
    public $numParts;
    /**
     *
     * @var string
     */
    public $accountName;
    /**
     *
     * @var int 
     */    
    public $sendTime;
    /**
     *
     * @var int 
     */    
    public $dlrTime;
    /**
     *
     * @var array
     */
    public $custom;
    
    /**
     * Generate object from an array
     * 
     * @param array $response
     * @return \self
     */
    public static function fromArray(array $response)
    {
        $dlrReport = new self();

        if(isset($response['accountName'])){
            $dlrReport->accountName = $response['accountName'];
        }
        if(isset($response['custom'])){
            $dlrReport->custom = $response['custom'];
        } 
        if(isset($response['dlrTime'])){
            $dlrReport->dlrTime = $response['dlrTime'];
        } 
        if(isset($response['errorCode'])){
            $dlrReport->errorCode = $response['errorCode'];
        } 
        if(isset($response['errorMessage'])){
            $dlrReport->errorMessage = $response['errorMessage'];
        } 
        if(isset($response['event'])){
            $dlrReport->event = $response['event'];
        } 
        if(isset($response['msgId'])){
            $dlrReport->msgId = $response['msgId'];
        }
        if(isset($response['numParts'])){
            $dlrReport->numParts = $response['numParts'];
        }        
        if(isset($response['partNum'])){
            $dlrReport->partNum = $response['partNum'];
        } 
        if(isset($response['sendTime'])){
            $dlrReport->sendTime = $response['sendTime'];
        }          
        return $dlrReport;
    }    
}
