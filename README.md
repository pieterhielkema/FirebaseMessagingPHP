# FirebaseMessagingPHP
Firebase Cloud Messaging PHP Client

## Installation
```bash
composer require ...
```

## Usage
Create client
```php
$firebase = new FirebaseMessaging('PROJECT_ID', 'YOUR_SERVER_KEY', 'OPTIONAL_API_URL');
```

Send message to fcm token
```php
$firebase->sendMessageToFcmToken('FCM_TOKEN', 'TITLE', 'BODY');
```
_Can also be array of tokens_

Send message to topic
```php
$firebase->sendMessageToTopic('TOPIC', 'TITLE', 'BODY');
```
_Can also be array of topics_