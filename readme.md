# Push sender

# Connection through sockets

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