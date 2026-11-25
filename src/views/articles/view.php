<h1><?= htmlspecialchars($article->getName()) ?></h1>

<?php if($article->getImg() !== null)  : ?>
    <img  class="img-fluid" src="<?= htmlspecialchars($article->getImg()) ?>" alt="">
<?php endif; ?>

<p><?= htmlspecialchars($article->getText()) ?></p>

<p>Автор: <?= htmlspecialchars($article->getAuthor()->getNickname()) ?></p>

<p>
    <a href="article/<?= htmlspecialchars($article->getId()) ?>/edit" class ="btn btn-primary">Редактировать</a>
    <a href="article/<?= htmlspecialchars($article->getId()) ?>/delete" class ="btn btn-primary">Удалить</a>
</p>