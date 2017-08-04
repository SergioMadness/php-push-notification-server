<?php namespace professionalweb\contracts;

/**
 * Interface for push "notificators"
 * @package professionalweb\contracts
 */
interface PusherFactory
{

    /**
     * @param string $name
     * @return PushNotification
     */
    public function create(string $name) : PushNotification;
}