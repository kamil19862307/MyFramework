<?php

namespace MyProject\Services;

class TelegramNotifier
{
    public function __construct(private string $token, private string $chatId)
    {
    }

    public function sendMessage(string $text): void
    {
        $url = "https://api.telegram.org/bot{$this->token}/sendMessage";

        $data = [
            'chat_id' => $this->chatId,
            'text' => $text,
            'parse_mode' => 'html'
        ];

        file_get_contents($url . '?' . http_build_query($data));
    }
}