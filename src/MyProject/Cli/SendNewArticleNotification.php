<?php

namespace MyProject\Cli;

use MyProject\Models\Articles\Article;
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

        foreach ($articles as $article) {
            $notifier->sendMessage('Добавлена новая статья: ' . $article->getName() . '. Автор: ' . $article->getAuthor()->getNickname());
            $article->markAsSent();
        }
    }
}