<?php include __DIR__ . '/../header.php' ?>

<div style="text-align: center;">
    <h1>Регистрация</h1>
    <?php if (!empty($error)): ?>
        <h2 style="color: red"><?= $error ?></h2>
    <?php endif; ?>
    <form action="/users/login" method="post">
        <label>Email <input type="text" name="email" value="<?= $_POST['email'] ?? '' ?>"></label>
        <br><br>
        <label>Пароль <input type="password" name="password" value="<?= $_POST['password'] ?? '' ?>"></label>
        <br><br>
        <input type="submit" value="Войти">
        <a href="http://localhost:8000/users/register"><button type="button">Зарегистрироваться</button></a>
    </form>
</div>

<?php include __DIR__ . '/../footer.php' ?>
