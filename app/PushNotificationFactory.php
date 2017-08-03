<?php namespace professionalweb;

use professionalweb\services\IOSPusher;
use professionalweb\contracts\PusherFactory;
use professionalweb\contracts\PushNotification;

/**
 * Factory, that creates pushers by platform name
 * @package professionalweb
 */
class PushNotificationFactory implements PusherFactory
{

    /**
     * Create pusher by platform
     *
     * @param string $name
     * @return PushNotification
     * @throws \Exception
     */
    public function create(string $name) : PushNotification
    {
        switch ($name) {
            case PusherFactory::PLATFORN_ANDROID: {
//                $pusher = new
                break;
            }
            case PusherFactory::PLATFORM_IOS: {
                $pusher = new IOSPusher();
                return $pusher;
            }
        }
        throw new \Exception('Wrong platform');
    }
}