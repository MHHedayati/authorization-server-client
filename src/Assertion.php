<?php

/**
 * Created by IntelliJ IDEA.
 * User: serpico
 * Date: 8/27/17
 * Time: 12:01 PM
 */

namespace Papion\AuthorizationServerClient;

use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use League\OAuth2\Server\ResourceServer;
use Psr\Http\Message\ServerRequestInterface;

class Assertion
{
    protected $resourceServer;

    function __construct(AccessTokenRepositoryInterface $accessTokenRepository, $publicKeyPath)
    {
        $this->resourceServer = new ResourceServer(
            $accessTokenRepository, $publicKeyPath
        );
    }

    /**
     * returns an instance of ServerRequestInterface with the following parameters added
     * - string     oauth_access_token_id
     * - string     oauth_client_id
     * - string     oauth_user_id
     * - string[]   oauth_scopes
     *
     * @param ServerRequestInterface $request
     * @return ServerRequestInterface
     */
    public function assertRequest(ServerRequestInterface $request){
        return $this->resourceServer->validateAuthenticatedRequest($request);
    }
}