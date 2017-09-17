<?php

/**
 * Created by IntelliJ IDEA.
 * User: serpico
 * Date: 8/27/17
 * Time: 11:54 AM
 */

namespace Papioniha\AuthorizationServerClient\Repositories;

use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use Papioniha\AuthorizationServerClient\Platform;

class RemoteAccessTokenRepository implements AccessTokenRepositoryInterface
{

    protected $platform;

    /**
     * RemoteAccessTokenRepository constructor.
     * @param string $base_url
     */
    function __construct($base_url)
    {
        $this->platform = new Platform($base_url);
    }

    /**
     * Create a new access token
     *
     * @param ClientEntityInterface $clientEntity
     * @param ScopeEntityInterface[] $scopes
     * @param mixed $userIdentifier
     *
     * @return AccessTokenEntityInterface
     */
    public function getNewToken(ClientEntityInterface $clientEntity, array $scopes, $userIdentifier = null)
    {
        // TODO: Implement getNewToken() method.
    }

    /**
     * Persists a new access token to permanent storage.
     *
     * @param AccessTokenEntityInterface $accessTokenEntity
     *
     * @throws UniqueTokenIdentifierConstraintViolationException
     */
    public function persistNewAccessToken(AccessTokenEntityInterface $accessTokenEntity)
    {
        // TODO: Implement persistNewAccessToken() method.
    }

    /**
     * Revoke an access token.
     *
     * @param string $tokenId
     */
    public function revokeAccessToken($tokenId)
    {
        // TODO: Implement revokeAccessToken() method.
    }

    /**
     * Check if the access token has been revoked.
     *
     * @param string $tokenId
     *
     * @return bool Return true if this token has been revoked
     */
    public function isAccessTokenRevoked($tokenId)
    {
        //TODO
        $headers = [
            'Authorization' => "",
            'Accept' => 'application/json'
        ];
        $response = $this->platform->get("/access_tokens/$tokenId/revoked", null, $headers);
        return (boolean)$response['response']['result']['revoked'];
    }
}