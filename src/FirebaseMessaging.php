<?php

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class FirebaseMessaging
{
    private string $pushBaseUrl;
    private string $topicBaseUrl;
    private string $apiKey;
    private Client $client;

    public function __construct(string $projectId, string $apiKey) {
        $this->apiKey = $apiKey;
        $this->client = new Client();
        $this->pushBaseUrl = 'https://fcm.googleapis.com/v1/projects/' . $projectId;
        $this->topicBaseUrl = 'https://iid.googleapis.com';
    }

    public function sendMessageToFcmToken(string|array $fcm_token, Message $message) {
        $url = $this->pushBaseUrl . '/messages:send';
        $this->client->post($url, [
            RequestOptions::HEADERS => [
                'Authorization' => 'Bearer ' . $this->apiKey
            ],
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
        $url = $this->pushBaseUrl . '/messages:send';
        $this->client->post($url, [
            RequestOptions::HEADERS => [
                'Authorization' => 'Bearer ' . $this->apiKey
            ],
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
    
    public function subscribeToTopic(string|array $fcm_token, string $topic) {
        $url = $this->topicBaseUrl . '/iid/v1:batchAdd';
        $this->client->post($url, [
            RequestOptions::HEADERS => [
                'Authorization' => 'Bearer ' . $this->apiKey
            ],
            RequestOptions::JSON => [
                'to' => $topic,
                'registration_tokens' => is_array($fcm_token) ? $fcm_token : [$fcm_token]
            ]
        ]);
    }

    public function unsubscribeFromTopic(string|array $fcm_token, string $topic) {
        $url = $this->topicBaseUrl . '/iid/v1:batchAdd';
        $this->client->post($url, [
            RequestOptions::HEADERS => [
                'Authorization' => 'Bearer ' . $this->apiKey
            ],
            RequestOptions::JSON => [
                'to' => $topic,
                'registration_tokens' => is_array($fcm_token) ? $fcm_token : [$fcm_token]
            ]
        ]);
    }
}