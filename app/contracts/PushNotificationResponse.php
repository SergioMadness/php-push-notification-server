<?php namespace professionalweb\contracts;

/**
 * Interface for push notification response
 * @package professionalweb\contracts
 */
interface PushNotificationResponse
{
    /**
     * Get token
     *
     * @return string
     */
    public function getToken() : string;

    /**
     * Get status code.
     *
     * @return int
     */
    public function getStatusCode(): int;

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage() : string;
}