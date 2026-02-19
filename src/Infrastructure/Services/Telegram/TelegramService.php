<?php

namespace DevFighters\Utils\Infrastructure\Services\Telegram;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class TelegramService
{
    private HttpClientInterface $httpClient;
    private bool $isInitialized;

    public function __construct(
        private string $botToken,
        private string $defaultChatId,
    ) {
        $this->httpClient = HttpClient::create();
        $this->isInitialized = ('' !== $botToken && '' !== $defaultChatId);
    }

    /**
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function sendMessageToDefaultChat(string $message): void
    {
        $this->sendMessageToGroup($this->defaultChatId, $message);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function sendMessageToGroup(string $chatId, string $message): void
    {
        $url = sprintf('https://api.telegram.org/bot%s/sendMessage', $this->botToken);

        $response = $this->httpClient->request('POST', $url, [
            'json' => [
                'chat_id' => $chatId,
                'text' => $message,
            ],
        ]);

        if (200 !== $response->getStatusCode()) {
            throw new \RuntimeException('Failed to send message: '.$response->getContent(false));
        }
    }

    public function isInitialized(): bool
    {
        return $this->isInitialized;
    }
}
