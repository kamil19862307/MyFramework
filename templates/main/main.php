<?php include __DIR__ . '/../header.php' ?>

<?php foreach ($articles as $article): ?>
    <h2><a href="/articles/<?= $article->getId() ?>"> <?= $article->getName() ?></a></h2>
    <p><?= $article->getText() ?></p>
    <h5>Дата: <?= $article->getCreatedAt() ?></h5>
    <h5>ID: <?= $article->getid() ?></h5>
    <h5>Автор: <a href="#"><?= $article->getAuthor()->getNickname() ?></a></h5>

    <hr>
<?php endforeach; ?>

<?php include __DIR__ . '/../footer.php' ?>
