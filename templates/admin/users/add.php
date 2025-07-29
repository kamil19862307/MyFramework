<?php include __DIR__ . '/../../header.php' ?>

    <h1>Добавление статьи</h1>
<?php if (!empty($error)): ?>
    <h2 style="color: red"><?= $error ?></h2>
<?php endif; ?>

    <form action="/admin/users/add" method="post">
        <label for="nickname">Никнейм пользователя</label><br>
        <input type="text" name="nickname" id="nickname" value="<?= $_POST['nickname'] ?? '' ?>" size="25"><br>
        <br>
        <label for="email">Email</label><br>
        <input type="text" name="email" id="email" value="<?= $_POST['email'] ?? '' ?>" size="25"><br>
        <br>
        <label for="password">Пароль</label><br>
        <input type="text" name="password" id="password" value="<?= $_POST['password'] ?? '' ?>" size="25"><br>
        <br>
        <input type="submit" value="Сохранить">
        <input type="reset" value="Сбросить">
        <a href="/"><button type="button">Отмена</button></a>
    </form>

<?php include __DIR__ . '/../../footer.php' ?>