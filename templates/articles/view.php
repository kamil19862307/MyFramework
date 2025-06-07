<?php include __DIR__ . '/../header.php' ?>

    <h2><?= $article->getName() ?></h2>
    <p><?= $article->getText() ?></p>
    <h5>Автор: <a href="#"><?= $author->getNickname() ?></a></h5>
    <hr>

<?php include __DIR__ . '/../footer.php' ?>