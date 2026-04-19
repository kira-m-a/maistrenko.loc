  <style>
    .mmm{
        margin-left: 100px;
    }
      </style>
<h1>Список всех пользователей:</h1>
<?php foreach($users as $user):?>
    <div class="mmm">
    <h2>Id: <?= $user->getId() ?></h2>
    <h2>Пользователь: <?= $user->getNickname() ?></h2>
    <h2>Почта: <?= $user->getEmail() ?></h2>
    <h2>Роль: user <h2>
    <br>
    </div>
<?php endforeach; ?>