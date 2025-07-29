<?php include __DIR__ . '/../../header.php' ?>

    <h1>Редактирование статьи</h1>
<?php if (!empty($error)): ?>
    <h2 style="color: red"><?= $error ?></h2>
<?php endif; ?>

    <form action="/admin/users/<?= $user->getId() ?>/edit" method="post">
        <label for="name">Никнейм пользователя</label><br>
        <input type="text" name="name" id="name" value="<?= $_POST['name'] ?? $user->getNickname() ?>" size="50"><br>
        <br>
        <label for="role">Роль</label><br>
        <input type="text" name="role" id="role" value="<?= $_POST['role'] ?? $user->getRole() ?>" size="25"><br>
        <br>
        <input type="submit" value="Сохранить">
        <input type="reset" value="Сбросить">
        <a href="/admin/users/<?= $user->getId() ?>/delete"><button type="button">Удалить</button></a>
        <a href="/admin/users"><button type="button">Отмена</button></a>
    </form>

<?php include __DIR__ . '/../../footer.php' ?>