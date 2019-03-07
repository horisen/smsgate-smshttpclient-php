<?php

/**
 * SMSRequest class
 *
 * @author milan
 * @copyright (c) 2019
 */

namespace SMSGate;


class SMSRequest
{
    /**
     *
     * @var string
     */
    public $type;
    
    /**
     *
     * @var string
     */
    public $sender;
    
    /**
     *
     * @var string
     */
    public $receiver;
    
    /**
     *
     * @var int 
     */
    public $dlrMask;
    
    /**
     *
     * @var string
     */
    public $dlrUrl;
    
    /**
     *
     * @var bool 
     */
    public $flash;
    
    /**
     *
     * @var string
     */
    public $text;
    
    /**
     *
     * @var int
     */
    public $dcs;
    
    /**
     *
     * @var string
     */
    public $url;
    
    /**
     *
     * @var string
     */
    public $title;
    
    /**
     *
     * @var array
     */
    public $custom;
    
    /**
     *
     * @var string
     */
    public $authUsername;
    
    /**
     *
     * @var string
     */
    public $authPassword;
    
    /**
     * 
     * @return array
     */
    public function toArray()
    {
        $body = [
            'type'      => $this->type,
            'auth'      => [
                'username'  => $this->authUsername,
                'password'  => $this->authPassword,                
            ],
            'sender'    => $this->sender,
            'receiver'  => $this->receiver,
            'text'      => $this->text,
        ];
        

        if(isset($this->dcs)){
            $body['dcs'] = $this->dcs;
        }

        if(isset($this->dlrMask)){
            $body['dlrMask'] = $this->dlrMask;
        }
        if(isset($this->dlrUrl)){
            $body['dlrUrl'] = $this->dlrUrl;
        }
        if(isset($this->flash)){
            $body['flash'] = $this->flash;
        }
        
        if(isset($this->url)){
            $body['url'] = $this->url;
        }
        if(isset($this->title)){
            $body['title'] = $this->title;
        }
        if(isset($this->custom)){
            $body['custom'] = $this->custom;
        }        
        
        return $body;        
    }
    
    /**
     * Generate object from an array
     * 
     * @param array $request
     * @return \self
     */
    public static function fromArray(array $request)
    {
        $smsRequest = new self();

        if(isset($request['auth']['password'])){
            $smsRequest->authPassword = $request['auth']['password'];
        }
        if(isset($request['auth']['username'])){
            $smsRequest->authUsername = $request['auth']['username'];
        }
        if(isset($request['custom'])){
            $smsRequest->custom = $request['custom'];
        }
        if(isset($request['dcs'])){
            $smsRequest->dcs = $request['dcs'];
        }
        if(isset($request['dlrMask'])){
            $smsRequest->dlrMask = $request['dlrMask'];
        }
        if(isset($request['dlrUrl'])){
            $smsRequest->dlrUrl = $request['dlrUrl'];
        }
        if(isset($request['flash'])){
            $smsRequest->flash = $request['flash'];
        }
        if(isset($request['receiver'])){
            $smsRequest->receiver = $request['receiver'];
        }
        if(isset($request['sender'])){
            $smsRequest->sender = $request['sender'];
        }
        if(isset($request['text'])){
            $smsRequest->text = $request['text'];
        }
        if(isset($request['title'])){
            $smsRequest->title = $request['title'];
        }
        if(isset($request['type'])){
            $smsRequest->type = $request['type'];
        }
        if(isset($request['url'])){
            $smsRequest->url = $request['url'];
        }        
        return $smsRequest;
    } 

    public function getType()
    {
        return $this->type;
    }

    public function getSender()
    {
        return $this->sender;
    }

    public function getReceiver()
    {
        return $this->receiver;
    }

    public function getDlrMask()
    {
        return $this->dlrMask;
    }

    public function getDlrUrl()
    {
        return $this->dlrUrl;
    }

    public function getFlash()
    {
        return $this->flash;
    }

    public function getText()
    {
        return $this->text;
    }

    public function getDcs()
    {
        return $this->dcs;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getCustom()
    {
        return $this->custom;
    }

    public function getAuthUsername()
    {
        return $this->authUsername;
    }

    public function getAuthPassword()
    {
        return $this->authPassword;
    }

    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    public function setSender($sender)
    {
        $this->sender = $sender;
        return $this;
    }

    public function setReceiver($receiver)
    {
        $this->receiver = $receiver;
        return $this;
    }

    public function setDlrMask($dlrMask)
    {
        $this->dlrMask = $dlrMask;
        return $this;
    }

    public function setDlrUrl($dlrUrl)
    {
        $this->dlrUrl = $dlrUrl;
        return $this;
    }

    public function setFlash($flash)
    {
        $this->flash = $flash;
        return $this;
    }

    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    public function setDcs($dcs)
    {
        $this->dcs = $dcs;
        return $this;
    }

    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function setCustom($custom)
    {
        $this->custom = $custom;
        return $this;
    }

    public function setAuthUsername($authUsername)
    {
        $this->authUsername = $authUsername;
        return $this;
    }

    public function setAuthPassword($authPassword)
    {
        $this->authPassword = $authPassword;
        return $this;
    }
}
