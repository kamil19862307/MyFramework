<?php

namespace MyProject\Cli;

use MyProject\Models\Articles\Article;

class SendNewArticleNotification extends AbstractCommand
{
    public function execute(): void
    {
        $articles = Article::findAllByColumn('is_sent', 0);

        if (empty($articles)) {
            return;
        }

        foreach ($articles as $article) {

            $article->markAsSent();
        }
    }
}