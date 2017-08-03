<?php namespace professionalweb\services;

use Pushok\Client;
use Pushok\Payload;
use Rhumsaa\Uuid\Uuid;
use Pushok\Notification;
use Pushok\Payload\Alert;
use professionalweb\Config;
use Pushok\AuthProvider\Token;
use Pushok\ApnsResponseInterface;
use professionalweb\models\PushResponse;
use professionalweb\contracts\PushNotification;

/**
 * Push notification service
 * @package professionalweb\services
 */
class IOSPusher implements PushNotification
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
     * @return array
     */
    public function push(array $tokenList, string $bundleId, string $message, string $title = '', string $sound = '', array $extraParams = []) : array
    {
        $result = [];

        $apnsConfig = Config::get('apns');
        $authProvider = Token::create([
            'key_id' => $apnsConfig['keyId'],
            'team_id' => $apnsConfig['teamId'],
            'app_bundle_id' => $bundleId,
            'private_key_path' => $apnsConfig['key'],
            'private_key_secret' => empty($apnsConfig['keyPassword']) ? null : $apnsConfig['keyPassword'],
        ]);

        $alert = Alert::create();
        if (!empty($title)) {
            $alert->setTitle($title);
        }
        $alert = $alert->setBody($message);

        $payload = Payload::create()->setAlert($alert);

        if (!empty($sound)) {
            $payload->setSound($sound);
        }
        foreach ($extraParams as $key => $val) {
            $payload->setCustomValue($key, $val);
        }

        $notifications = [];
        $tokenUIDMap = [];
        foreach ($tokenList as $deviceToken) {
            $id = Uuid::uuid4()->toString();
            $tokenUIDMap[$id] = $deviceToken;
            $notifications[] = (new Notification($payload, $deviceToken))->setId($id);
        }

        $client = new Client($authProvider, $apnsConfig['production']);
        $client->addNotifications($notifications);

        foreach ($client->push() as $response) {
            print_r($response);
            /** @var ApnsResponseInterface $response */
            $result[] = (new PushResponse())
                ->setToken($tokenUIDMap[trim($response->getApnsId())])
                ->setStatusCode($response->getStatusCode())
                ->setMessage($response->getStatusCode() === 0 ? $response->getReasonPhrase() : $response->getErrorReason() . PHP_EOL . $response->getErrorDescription());
        }

        return $result;
    }
}