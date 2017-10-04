<?php
/**
 * Created by IntelliJ IDEA.
 * User: serpico
 * Date: 10/4/17
 * Time: 3:26 PM
 */

namespace Papioniha\AuthorizationServerClient;


use Papioniha\AuthorizationServerClient\Interfaces\TokenProviderInterface;

class RemoteTokenProvider implements TokenProviderInterface
{

    function __construct($oauth_url, $client_id, $client_secret)
    {
        $this->url = $oauth_url;
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
    }

    /**
     * Get Current Token if Not Exchange New one
     *
     * @return string $access_token
     */
    public function getToken()
    {
        // TODO: Implement getToken() method.
    }

    /**
     * Get New Token
     *
     * @return string $access_token
     */
    public function exchangeToken()
    {
        // TODO: Implement exchangeToken() method.
    }
}