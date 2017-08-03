<?php namespace professionalweb\services;

use professionalweb\Config;
use professionalweb\contracts\ResponseSigner;

/**
 * Response
 * @package professionalweb\services
 */
class JWTResponseSigner implements ResponseSigner
{

    /**
     * Sing response
     *
     * @param mixed $input
     * @return string
     */
    public function sign($input) : string
    {
        return \JWT::encode($input, Config::get('jwtToken'));
    }
}