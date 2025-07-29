<?php include __DIR__ . '/../header.php' ?>

<?php if (!$user->isAdmin()):?>
    <h1>У вас нет прав для доступа к этой странице</h1>
<?php exit(); endif; ?>


<div>
    <a href="/admin/articles/"><button type="button">К списку всех статей</button></a>
</div>
<br>
<div>
    <a href="/admin/comments/"><button type="button">К списку всех комментариев</button></a>
</div>
<br>
<div>
    <a href="/admin/users"><button type="button">К списку всех пользователей</button></a>
</div>
<hr>



<?php foreach ($articles as $article): ?>
    <h2><a href="/articles/<?= $article->getId() ?>"> <?= $article->getName() ?></a></h2>
    <p><?= $article->getText() ?></p>
    <h5>Дата: <?= $article->getCreatedAt() ?></h5>
    <h5>ID: <?= $article->getid() ?></h5>
    <h5>Автор: <a href="#"><?= $article->getAuthor()->getNickname() ?></a></h5>

    <hr>
<?php endforeach; ?>

<?php include __DIR__ . '/../footer.php' ?>
