<?php namespace professionalweb\contracts;

/**
 * Interface for request validation
 * @package professionalweb\contracts
 */
interface RequestValidator
{
    /**
     * validate request
     *
     * @param mixed $request
     * @return bool
     */
    public function validate($request) : bool;
}