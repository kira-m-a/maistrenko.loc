<h1>Регистрация</h1>

<?php if (!empty($error)) : ?>
    <p style="background-color: red"><?= htmlspecialchars($error) ?></p>
<?php endif ?>

<form action="" method="POST">
    <input type="hidden" name="csrf-token" value="CIwNZNlR4XbisJF39I8yWnWX9wX4WFoz" />
    <label>Логин <input type="text" name="nickname" value="<?= htmlspecialchars($_POST['nickname'] ?? '') ?>"></label><br>
    <label>Email <input type="text" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"></label><br>
    <label>Пароль <input type="password" name="password"></label><br>
    <input type="submit" value="Зарегистрироваться">
</form>