<?php

namespace Papioniha\AuthorizationServerClient\Interfaces;

interface TokenProviderInterface
{
    /**
     * Get Current Token if Not Exchange New one
     *
     * @return string $access_token
     */
    public function getToken();

    /**
     * Get New Token
     *
     * @return string $access_token
     */
    public function exchangeToken();

}