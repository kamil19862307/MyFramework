<?php include __DIR__ . '/../header.php' ?>

    <h1>Редактирование комментария</h1>
<?php if (!empty($error)): ?>
    <h2 style="color: red"><?= $error ?></h2>
<?php endif; ?>

    <form action="/comments/<?= $comment->getId() ?>/edit" method="post">
        <label for="text">Текст комментария</label>
        <br>
        <textarea name="text" id="text" rows="10" cols="80"><?= $_POST['text'] ?? $comment->getText() ?></textarea>
        <br>
        <br>
        <input type="submit" value="Сохранить">
        <input type="reset" value="Сбросить">
        <a href="/comments/<?= $comment->getId() ?>/delete"><button type="button">Удалить</button></a>
        <a href="/"><button type="button">Отмена</button></a>
    </form>

<?php include __DIR__ . '/../footer.php' ?>