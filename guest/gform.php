<?php

// Логин
if ($_POST['login_f']) {

    captcha_valid();
    message('OK');


    // Регистрация
} elseif ($_POST['register_f']) {

    email_valid();
    password_valid();

    // Проверяем существует ли в базе такой же пользователь (проверка по мылу)
    if (mysqli_num_rows(mysqli_query($connect, "SELECT `id` FROM `users` WHERE `email` = '$_POST[email]'"))){
        message('Такой пользователь уже есть');
    }

    // Генерация кода
    $code = random_str(26);
    // Вносим инфу в сессию
    $_SESSION['confirm'] = array(
        'type' => 'register',
        'email' => $_POST['email'],
        'password' => $_POST['password'],
        'code' => $code,
    );

    // Отправляем письмо с кодом подтверждения
    mail($_POST['email'], 'Активация аккаунта', "Код подтверждения регистрации: <b>$code</b>");
    captcha_valid();

    // Редирект на страницу подтверждения
    go('confirm');


    // Восстановление пароля
} elseif ($_POST['recovery_f']) {

    captcha_valid();
    email_valid();

    // Проверяем существует ли в базе такой же пользователь (проверка по мылу)
    if (!mysqli_num_rows(mysqli_query($connect, "SELECT `id` FROM `users` WHERE `email` = '$_POST[email]'"))){
        message('Такого пользователя не существует!');
    }

    // Генерация случайного кода
    $code = random_str(26);

    // Вносим инфу в сессию
    $_SESSION['confirm'] = array(
        'type' => 'recovery',
        'email' => $_POST['email'],
        'code' => $code,
    );

    // Отправка письма с кодом
    mail($_POST['email'], 'Восстановление пароля', "Код для восстановления пароля: <b>$code</b>", 'От: bot@cms.local');

    // Редирект на страницу подтверждения
    go('confirm');


    // Подтверждение регистрации
} elseif ($_POST['confirm_f']) {

    if ($_SESSION['confirm']['type'] == 'register') {
        // Проверка кода подтверждения
        if ($_SESSION['confirm']['code'] != $_POST['code']) message('Код подтверждения не верный!');
        mysqli_query($connect, 'INSERT INTO `users` VALUES ("", "'.$_SESSION['confirm']['email'].'", "'.$_SESSION['confirm']['password'].'")');
        // Удаляем сессию (пока это не правильный вариант)
        unset($_SESSION['confirm']);

        // Редирект на страницу логина
        go('login');

    } elseif ($_SESSION['confirm']['type'] == 'recovery') {
        // Проверка кода подтверждения
        if ($_SESSION['confirm']['code'] != $_POST['code']) message('Код подтверждения не верный!');

        // Генерация нового пароля через функцию random_str
        $pass = random_str(10);

        // MySQL запрос на резет пароля
        mysqli_query($connect, 'UPDATE `users` SET `password` = "'.md5($pass).'" WHERE `email` = "'.$_SESSION['confirm']['email'].'"');

        // Отправка письма с новым паролем
        mail($_SESSION['confirm']['email'], 'Новый пароль', "Ваш новый пароль: <b>$pass</b>", 'От: bot@cms.local');

        // Удаляем сессию (пока это не правильный вариант)
        unset($_SESSION['confirm']);

        // Редирект на страницу логина
        go('login');

    } else {
        not_found();
    }

}


?>