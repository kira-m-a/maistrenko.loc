<h1>Вход</h1>

<?php if (!empty($error)) : ?>
    <p style="background-color: red"><?= htmlspecialchars($error) ?></p>
<?php endif ?>
<div class="m-3 col-md-6">
    <form action="" method="POST">
        <input type="hidden" name="csrf-token" value="CIwNZNlR4XbisJF39I8yWnWX9wX4WFoz" />
        <div class="mb-3">
            <label class="form-label" for="inputName">Логин </label>
            <input type="text" id="inputName"  class="form-control" name="nickname" value="<?= htmlspecialchars($_POST['nickname'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label" for="inputPassword">Пароль </label>
            <input type="password" id="inputPassword" class="form-control" name="password">
        </div>
        <input type="submit" value="Войти">
    </form>
</div>