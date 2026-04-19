<h1>Статьи</h1>
<?php if($user): ?>
    <p><a href="articles/add">Добавить статью</a></p>
<?php endif ?>
<?php foreach($articles as $article):  ?>
    <h2><?= htmlspecialchars($article->getName()) ?></h2>

    <?php if($article->getImg() !== null)  : ?>
        <img  class="img-fluid" width="100px" src="<?= $article->getImg() ?>" alt="">
    <?php endif; ?>

    <p><?= htmlspecialchars($article->getText()) ?></p>
    <p>Автор: <?= $article->getAuthor()->getNickname() ?></p>
    <a href="article/<?= $article->getId() ?>">Подробнее</a>
    <hr>
<?php endforeach; ?>