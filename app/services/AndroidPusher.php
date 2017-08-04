<?php namespace professionalweb\services;

use PHP_GCM\Result;
use PHP_GCM\Sender;
use PHP_GCM\Message;
use professionalweb\Config;
use professionalweb\contracts\Platform;
use professionalweb\models\PushResponse;
use professionalweb\contracts\PushNotification;
use professionalweb\contracts\PushNotificationResponse;

/**
 * Android pusher
 * @package professionalweb\services
 */
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
        $result = [];

        $gcmConfig = Config::getConfigByBundleId(Platform::ANDROID, $bundleId);

        $payload = array_merge($extraParams, [
            'title' => $title,
            'body' => $message
        ]);

        $sender = new Sender($gcmConfig['apiKey']);
        $message = new Message('', $payload);

        try {
            $sendResults = $sender->sendMulti($message, $tokenList, $gcmConfig['retries']??0)->getResults();
        } catch (\Exception $ex) {
            return $this->prepareAllTokenError($tokenList, (string)$ex->getCode(), $ex->getMessage());
        }

        /** @var Result $pushResult */
        foreach ($sendResults as $index => $pushResult) {
            $result[] = (new PushResponse())
                ->setToken($tokenList[$index])
                ->setStatusCode((string)$pushResult->getErrorCode());
        }

        return $result;
    }

    /**
     * Get result list with tokens and error message
     *
     * @param array $tokenList
     * @param string $code
     * @param string $errorMessage
     * @return array
     */
    protected function prepareAllTokenError(array $tokenList, string $code, string $errorMessage) : array
    {
        $result = [];

        foreach ($tokenList as $token) {
            $result[] = (new PushResponse())
                ->setToken($token)
                ->setStatusCode($code)
                ->setMessage($errorMessage);
        }

        return $result;
    }
}