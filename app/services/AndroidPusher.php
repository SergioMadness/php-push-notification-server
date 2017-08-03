<?php namespace professionalweb\services;

use professionalweb\contracts\PushNotification;
use professionalweb\contracts\PushNotificationResponse;

class AndroidPusher implements PushNotification
{

    /**
     * Send message to devises by $tokens
     *
     * @param array $tokenList
     * @param string $bundleId
     * @param string $message
     * @param string $title
     * @param string $sound
     * @param array $extraParams
     * @return PushNotificationResponse[]
     */
    public function push(array $tokenList, string $bundleId, string $message, string $title = '', string $sound = '', array $extraParams = []): array
    {
        // TODO: Implement push() method.
    }
}