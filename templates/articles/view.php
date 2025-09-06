<?php include __DIR__ . '/../header.php' ?>

    <h2><?= $article->getName() ?></h2>
    <p><?= $article->getParsedText() ?></p>
    <h5>Дата: <?= $article->getCreatedAt() ?></h5>
    <h5>Автор: <a href="#"><?= $article->getAuthor()->getNickname() ?></a></h5>

    <hr>

<?php if ($isAdmin === true): ?>
    <a href="/articles/<?= $article->getId(); ?>/edit">
        <button type="button">Редактировать статью</button>
    </a>
<?php endif; ?>

    <h2>Комментарии</h2>

<?php if(is_string($comments)): ?>
    <?php echo $comments ?>

<?php else: ?>

<?php foreach ($comments as $comment): ?>

    <br>
    <div class="comment" id="comment<?= $comment->getId()?>">
        <p><?= $comment->getText() ?></p>

<?php if ($user->getId() === $comment->getAuthorId() or $user->isAdmin()): ?>

        <a href="/comments/<?= $comment->getId(); ?>/edit">
            <button type="button">Редактировать комментарий</button>
        </a>

<?php endif; ?>

    </div>
    <br>

<?php endforeach; ?>

<?php endif; ?>
    <hr>

    <h2>Добавить комментарий</h2>

<?php if (!empty($user)): ?>

    <div class="form" id="form">
        <form action="/articles/<?= $article->getId() ?>/comments" method="post">
            <input type="hidden" name="author_id" value="<?= $article->getAuthorId() ?>">
            <input type="hidden" name="article_id" value="<?= $article->getId() ?>">
            <label for="text">Текст комментария</label>
            <br>
            <textarea name="text" id="text" rows="10" cols="80">Текст комментария</textarea>
            <br>
            <br>
            <input type="submit" value="Сохранить">
            <input type="reset" value="Сбросить">
            <a href="/"><button type="button">Отмена</button></a>
        </form>
    </div>

<?php else: ?>
    <h3>Добавлять комментарии могут только зарегистрированные пользователи</h3>

    <a href="/users/login">Войти</a> | <a href="/users/register">Зарегистрироваться</a>
<?php endif;?>

    <hr>




<?php include __DIR__ . '/../footer.php' ?>