<?php include __DIR__ . '/../header.php' ?>

    <h1>Добавление новой статьи</h1>
<?php if (!empty($error)): ?>
    <h2 style="color: red"><?= $error ?></h2>
<?php endif; ?>

    <form action="/articles/add" method="post">
        <label for="name">Название статьи</label><br>
        <input type="text" name="name" id="name" value="<?= $_POST['name'] ?? '' ?>" size="50"><br>
        <br>
        <label for="text">Текст статьи</label><br>
        <textarea name="text" id="text" rows="10" cols="80"><?= $_POST['text'] ?? '' ?></textarea><br>
        <br>
        <input type="submit" value="Создать">
        <input type="reset" value="Сбросить">
        <a href="/"><button type="button">Отмена</button></a>
    </form>

<?php include __DIR__ . '/../footer.php' ?>