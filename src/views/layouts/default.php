<?php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="/maistrenko.loc/">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="main1.css">
</head>

<body>
    <header class="header">
        <div class="container">
            <div class="logo">
                <a href="/maistrenko.loc/articles">Cтатьи</a>
            </div>
     <nav class="nav"> 
    <ul>
        <li><a href="/maistrenko.loc/articles">Статьи</a></li>
        
        <?php if ($user): ?>
            <li><?= htmlspecialchars($user->getNickname()) ?></li>
            <li><a href="/maistrenko.loc/users/logout">Выход</a></li>
        <?php else: ?>
            
            <li><a href="/maistrenko.loc/users/signUp">Регистрация</a></li>
            <li><a href="/maistrenko.loc/users/login">Вход</a></li>
        <?php endif; ?>
    </ul>
</nav>
        </div>
    </header>
    <main>
        <?= $content ?? 'Контент не загружен' ?>
    </main> 
    <footer class="footer">
        <div class="fcontainer">
            <div class="footer-section">
                <h3>Контакты</h3>
                <p>Телефон : +7(911)567-89-81</p>
                <p>Email : stat@gmail.com</p>
            </div>
        </div>

    </footer>
</body>

</html>