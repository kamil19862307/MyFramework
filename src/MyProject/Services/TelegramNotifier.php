<?php

namespace MyProject\Services;

use MyProject\Exceptions\TelegramNotifierException;

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

        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true, // ответ вернется строкой
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_TIMEOUT => 10, // таймаут 10 секунд
        ]);

        $response = curl_exec($ch);

        if ($response === false) {

            $error = curl_error($ch);

            curl_close($ch);

            throw new TelegramNotifierException('Ошибка cUrl: ' . $error);
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        $decodedResponse = json_decode($response, true);

        if ($httpCode !== 200 || empty($decodedResponse['ok'])) {

            $description = $decodedResponse['description'] ?? 'Неизвестная ошибка';

            throw new TelegramNotifierException("Ошибка Телеграм API ({$httpCode}): " . $description);
        }
    }
}