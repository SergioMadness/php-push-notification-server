<?php namespace professionalweb\contracts;

/**
 * Interface for request decoding
 * @package professionalweb\contracts
 */
interface RequestDecoder
{
    /**
     * Decode request and return params
     *
     * @param mixed $request
     * @return array
     */
    public function decode($request) : array;
}