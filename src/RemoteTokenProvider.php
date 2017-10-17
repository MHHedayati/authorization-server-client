<?php

namespace Papioniha\AuthorizationServerClient;


use Papioniha\AuthorizationServerClient\Interfaces\TokenProviderInterface;

class RemoteTokenProvider implements TokenProviderInterface
{

    protected $token;
    protected $expiration;
    protected $tokenExchanged = false;
    protected $url, $client_id, $client_secret;

    function __construct($oauth_url, $client_id, $client_secret)
    {
        $this->url = $oauth_url;
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        $this->_load();
    }

    function __destruct(){
        if($this->tokenExchanged){
            $this->_save();
        }
    }

    /**
     * Get Current Token if Not Exchange New one
     *
     * @return string $access_token
     */
    public function getToken()
    {
        if(!$this->token || time() > $this->expiration){
            $this->exchangeToken();
        }
        return $this->token;
    }

    /**
     * Get New Token
     *
     * @return string $access_token
     */
    public function exchangeToken()
    {
        $platform = new Platform($this->url);
        $data = [
            'grant_type' => 'client_credentials',
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret
        ];
        $headers = [
            'Accept' => 'application/json'
        ];
        $response = $platform->post('/access_token', $data, $headers);
        if($response['exception']){
            throw $response['exception'];
        }
        $result = $response['response'];
        $this->expiration = time() + $result['expires_in'];
        $this->tokenExchanged = true;
        return $this->token = $result['access_token'];
    }

    private function _save(){
        $toStore = [
            'token' => $this->token,
            'expiration' => $this->expiration
        ];
        file_put_contents($this->_getTmpFilepath(), serialize($toStore));
    }

    private function _load(){

        if (! file_exists($this->_getTmpFilepath()) )
            return;
        $content = file_get_contents( $this->_getTmpFilepath() );
        $stored = unserialize($content);
        $this->token = $stored['token'];
        $this->expiration = $stored['expiration'];

    }

    private function _getTmpFilePath(){
        return sys_get_temp_dir() . '/_TOKEN.tmp';
    }

}