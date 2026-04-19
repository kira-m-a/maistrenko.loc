 <section class="posts">
<div class="container">
<h1>Статьи</h1>
<?php foreach($articles as $article): ?>
    <h3><?php echo htmlspecialchars($article->name); ?></h3>
     <p><?php echo htmlspecialchars($article->text); ?></p>
     <hr>
<?php endforeach; ?>

            </div>
        </section>
        <div>

        </div>
