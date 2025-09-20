<?php

namespace MyProject\Cli;

use MyProject\Exceptions\TelegramNotifierException;
use MyProject\Models\Articles\Article;
use MyProject\Services\Logger;
use MyProject\Services\TelegramNotifier;


class SendNewArticleNotification extends AbstractCommand
{
    public function execute(): void
    {
        $articles = Article::findAllByColumn('is_sent', 0);

        if (empty($articles)) {
            return;
        }

        $notifier = new TelegramNotifier($_ENV['TELEGRAM_BOT_TOKEN'], $_ENV['TELEGRAM_CHAT_ID']);

        $logger = new Logger(__DIR__ . '/../../../var/log/telegram.log');

        foreach ($articles as $article) {
            try {
                $notifier->sendMessage('Добавлена новая статья: ' . $article->getName() . '. Автор: ' . $article->getAuthor()->getNickname());

                $article->markAsSent();

                $logger->log("Уведомление отправлено в телеграм, Article ID {$article->getId()}");

            } catch (TelegramNotifierException $exception) {
                $logger->log("Ошибка при отправке сообщения в телеграм, Article ID {$article->getId()}"  . $exception->getMessage());
            }
        }
    }
}