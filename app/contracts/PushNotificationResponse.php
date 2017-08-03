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
     * @return string
     */
    public function getStatusCode(): string;

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage() : string;
}