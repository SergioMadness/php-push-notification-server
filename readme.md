# Push sender

#Connection through sockets

## config.json
```javascript
{
  "ip": "",
  "port": 10000,
  "jwtToken": "some token",
  "apns": {
    "key": "app/certificates/AuthKey_jf774hh.p8",
    "keyPassword": "",
    "keyId": "jf774hh",
    "teamId": "TEAMID",
    "production": false
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

##response
```javascript
[
   {
      "token":"dasasd8962ghgre",
      "statusCode":400,
      "message":"DeviceTokenNotForTopic\nThe device token does not match the specified topic"
   }
]
```