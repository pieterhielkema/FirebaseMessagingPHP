<?php

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class FirebaseMessaging
{
    private string $baseUrl;
    private string $apiKey;
    private Client $client;

    public function __construct(string $projectId, string $apiKey, string $baseUrl = "https://fcm.googleapis.com") {
        $this->apiKey = $apiKey;
        $this->client = new Client();
        $this->baseUrl = $baseUrl . '/v1/projects/' . $projectId;
    }

    public function sendMessageToFcmToken(string|array $fcm_token, Message $message) {
        $url = $this->baseUrl . '/messages:send';
        $this->client->post($url, [
            RequestOptions::JSON => [
                'message' => [
                    'token' => is_array($fcm_token) ? implode(',', $fcm_token) : $fcm_token,
                    'notification' => [
                        'title' => $message->title,
                        'body' => $message->body
                    ]
                ]
            ]
        ]);
    }

    public function sendMessageToTopic(string|array $topic, Message $message) {
        $url = $this->baseUrl . '/messages:send';
        $this->client->post($url, [
            RequestOptions::JSON => [
                'message' => [
                    'topic' => is_array($topic) ? implode(' || ', $topic) : $topic,
                    'notification' => [
                        'title' => $message->title,
                        'body' => $message->body
                    ]
                ]
            ]
        ]);
    }
}