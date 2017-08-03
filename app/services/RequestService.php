<?php namespace professionalweb\services;

use professionalweb\Config;
use professionalweb\contracts\RequestDecoder;
use professionalweb\contracts\RequestValidator;

/**
 * Request validator
 * @package professionalweb\services
 */
class RequestService implements RequestValidator, RequestDecoder
{

    /**
     * validate request
     *
     * @param mixed $request
     * @return bool
     */
    public function validate($request) : bool
    {
        try {
            $message = $this->decode($request);
            if (!isset($message['message']) || empty($message['message']) || !isset($message['tokens']) || empty($message['tokens'])) {
                return false;
            }
            return true;
        } catch (\Exception $ex) {
            return false;
        }
    }

    /**
     * Decode request and return params
     *
     * @param mixed $request
     * @return array
     */
    public function decode($request) : array
    {
        try {
            return (array)\JWT::decode($request, Config::get('jwtToken'), ['HS256']);
        } catch (\Exception $ex) {
            echo $ex->getMessage();
            return null;
        }
    }
}