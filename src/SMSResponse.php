<?php

/**
 * SMSResponse class
 *
 * @author milan
 * @copyright (c) 2019
 */

namespace SMSGate;


class SMSResponse
{
    /**
     *
     * @var string
     */
    public $msgId;
    
    /**
     *
     * @var int
     */
    public $numParts;
    
    /**
     * Generate object from an array
     * 
     * @param array $response
     * @return \self
     */
    public static function fromArray(array $response)
    {
        $smsReponse = new self();
        if(isset($response['msgId'])){
            $smsReponse->msgId = $response['msgId'];
        }
        if(isset($response['numParts'])){
            $smsReponse->numParts = $response['numParts'];
        }        
        return $smsReponse;
    }
}
