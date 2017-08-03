<?php namespace professionalweb\contracts;

/**
 * Interface for push "notificators"
 * @package professionalweb\contracts
 */
interface PusherFactory
{
    /**
     * Android
     */
    const PLATFORN_ANDROID = 'android';

    /**
     * iOS
     */
    const PLATFORM_IOS = 'iOS';

    /**
     * @param string $name
     * @return PushNotification
     */
    public function create(string $name) : PushNotification;
}