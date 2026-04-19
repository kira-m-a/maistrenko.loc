<h1><?= htmlspecialchars($article->getName()) ?></h1>

<?php if($article->getImg() !== null)  : ?>
    <img  class="img-fluid" src="<?= $article->getImg() ?>" alt="">
<?php endif; ?>

<p><?= htmlspecialchars($article->getText()) ?></p>

<p>Автор: <?= $article->getAuthor()->getNickname() ?></p>
<a href="article/<?= $article->getId() ?>/edit" class="bth bth-primary">редактировать</a>
<a href="article/<?= $article->getId() ?>/delete" class="bth bth-primary">удалить</a>