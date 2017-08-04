# Push sender

# Connection through TCP/IP sockets

## config.json
```javascript
{
  "ip": "",
  "port": 10000,
  "jwtToken": "kjdsfhjk849678946",
  "apns": {
    "all": {
      "key": "certificates/AuthKey_FHH747JJD.p8",
      "keyPassword": "",
      "keyId": "FHH747JJD",
      "teamId": "SERTYUJJ",
      "production": false
    }
  },
  "gcm": {
    "all": {
      "apiKey": "AIzJdurHh377f7O95u-OAS_KKdfhh57878L4QcQ",
      "retries": 0
    }
  },
  "map": {
    "apns": {
      "*": "corp"
    },
    "gcm": {
      "*": "all"
    }
  }
}
```

## message
```php
\JWT::encode([
    'tokens'      => [
	    'dasasd8962ghgre'
    ],
    'bundleId'    => 'ru.test.baundle',
    'message'     => 'Service is ready',
    'title'       => 'Hello, guys!',
    'sound'       => null,
    'extraParams' => [
	    'acme' => ''
    ],
], $this->getJwtKey());
```

## response
```javascript
[
   {
      "token":"dasasd8962ghgre",
      "statusCode":400,
      "message":"DeviceTokenNotForTopic\nThe device token does not match the specified topic"
   }
]
```

## Example
```bash
sudo docker run -d -i --name pusher -p 10000:10000 -v /home/www-docker/builds/build-pusher-1/certificates:/usr/src/pusher/certificates -v /home/www-docker/builds/build-pusher-1/config.json:/usr/src/pusher/config.json professionalweb/push-notification-server
```

```php
/* Create  TCP/IP socket. */
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
if ($socket === false) {
    $m = "Can't create socket through socket_create(): couse: " . socket_strerror(socket_last_error());
    \Log::error($m);
    throw new \Exception($m);
}

$result = socket_connect($socket, $this->getPushServiceIp(), $this->getPushServicePort());
if ($result === false) {
    $m = "Can't execute socket_connect().\nCause: ($result) " . socket_strerror(socket_last_error($socket)) . "\n";
    \Log::error($m);
    throw new \Exception($m);
}

$message = \JWT::encode([
           'platform'    => 'android',
           'tokens'      => ['dasdw534535'],
           'bundleId'    => 'ru.bundle.name',
           'message'     => 'Have a nice day!',
           'title'       => 'Hello',
           'sound'       => '',
           'extraParams' => [
                'acme' => 'Some param'
           ],
       ], '<JWT-KEY>')
socket_write($socket, $message, strlen($message));
$message = "\n";
socket_write($socket, $message, strlen($message));

$response = socket_read($socket, 2048);

socket_close($socket);
```