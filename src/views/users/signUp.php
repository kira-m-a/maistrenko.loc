
    <style>
        .container1{
            display: flex;
            justify-content: center
}
        form {
            background-color: #fff;
            padding: 20px;
            margin:50px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 300px;
        }
        h1 form{
            text-align: center;
            color: #333;
            font-size: 24px;
        }
        label {
            display: block;
            margin-bottom: 10px;
            color: #666;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box; 
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #28a745;
            color: white;
            font-size: 16px;
            cursor: pointer;
            margin-top: 15px;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #f5c6cb;
            margin-bottom: 15px;
            font-size: 14px;
        }
    </style>
    <div class="container1">
<form action="" method="POST">
    <h1>Регистрация</h1>
    
    <?php if(!empty($error)): ?>
        <p class="error"><?=$error?></p>
    <?php endif ?>

    <label>Логин
        <input type="text" name="nickname" value ="<?=$_POST['nickname'] ?? ''?>" required>
    </label>
    
    <label>Email
        <input type="email" name="email" value ="<?=$_POST['email'] ?? ''?>" required>
    </label>
    
    <label>Пароль
        <input type="password" name="password" required>
    </label>
    
    <input type="submit" value="Зарегистрироваться">
</form>

</div>
