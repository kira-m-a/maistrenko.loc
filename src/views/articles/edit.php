<h1>Редактирование статьи: <?= htmlspecialchars($article->getName()) ?></h1>

<?php if (!empty($error)) : ?>
    <p style="background-color: red"><?= htmlspecialchars($error) ?></p>
<?php endif ?>
<div class="m-3 col-md-6">
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="csrf-token" value="CIwNZNlR4XbisJF39I8yWnWX9wX4WFoz" />
        <div class="mb-3">
            <label for="inputName" class="form-label">Название статьи</label>
            <input type="text" id="inputName" name="name" class="form-control" value="<?= htmlspecialchars($_POST['name'] ?? $article->getName() )?>">
        </div>
        <div class="mb-3">
            <label for="inputText" class="form-label">Текст статьи</label>
            <textarea id="inputText" name="text" class="form-control"><?= htmlentities($_POST['text'] ?? $article->getText()) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="inputImg" class="form-label">Изображение</label>
            <input type="file" id="inputImg" class="form-control" name="img">
        </div>
        <input type="submit" class="btn btn-primary" value="Отправить">
        <a href="<?= htmlspecialchars($_SERVER['HTTP_REFERER'] ?? "article/{$article->getId()}") ?>" class="btn btn-primary">Отменить</a>
    </form>
</div>
