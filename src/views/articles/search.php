<?php if(empty($_GET['q'])): ?>
    <h1>Поиск по сайту</h1>
    <form action="">
        <input type="hidden" name="csrf-token" value="CIwNZNlR4XbisJF39I8yWnWX9wX4WFoz" />
        <label for="search">Введите запрос</label>
        <input class="form-control" type="text" name="q" id="search">
        <input type="submit">
    </form>

<?php else: ?>
    <h1>Результаты поиска</h1>
    <p>По запросу: <?= htmlspecialchars($_GET['q']) ?></p>
    <?php if(empty($articles)): ?>
            <p>Ничего не найдено</p>
    <?php else: ?>
        <?php foreach($articles as $article):  ?>
            <h2><?= htmlspecialchars($article->getName()) ?></h2>

            <?php if($article->getImg() !== null)  : ?>
                <img  class="img-fluid" width="100px" src="<?= htmlspecialchars($article->getImg()) ?>" alt="">
            <?php endif; ?>

            <p><?= htmlspecialchars($article->getText()) ?></p>
            <p>Автор: <?= htmlspecialchars($article->getAuthor()->getNickname()) ?></p>
            <a href="article/<?= htmlspecialchars($article->getId()) ?>">Подробнее</a>
            <hr>
        <?php endforeach; ?>
    <?php endif ?>
<?php endif ?>