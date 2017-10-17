<?php

/**
 * Created by IntelliJ IDEA.
 * User: serpico
 * Date: 8/27/17
 * Time: 11:53 AM
 */

namespace Papioniha\AuthorizationServerClient;

use Papioniha\AuthorizationServerClient\Interfaces\TokenProviderInterface;

class Client
{
    protected $tokenProvider;
    protected $url;

    function __construct($tokenProvider, $url){
        $this->url  = rtrim( (string) $url, '/' );
        if(isInstanceOf($tokenProvider, TokenProviderInterface::class)){
            $this->tokenProvider = $tokenProvider;
        }else{
            throw new \InvalidArgumentException();
        }
    }

}