<?php namespace professionalweb\contracts;

/**
 * Interface for response signing
 * @package professionalweb\contracts
 */
interface ResponseSigner
{
    /**
     * Sing response
     *
     * @param mixed $input
     * @return string
     */
    public function sign($input) : string;
}