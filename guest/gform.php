<?php

if ($_POST['login_f']) {

    captcha_valid();
    message('OK');

} elseif ($_POST['register_f']) {

    email_valid();
    password_valid();

    if (mysqli_num_rows(mysqli_query($connect, "SELECT `id` FROM `users` WHERE `email` = '$_POST[email]'"))){
        message('Такой пользователь уже есть');
    }

    $code = random_str(26);
    $_SESSION['confirm'] = array(
        'type' => 'register',
        'email' => $_POST['email'],
        'password' => $_POST['password'],
        'code' => $code,
    );

    mail($_POST['email'], 'Активация аккаунта', "Код подтверждения регистрации: <b>$code</b>");
    captcha_valid();
    go('confirm');

} elseif ($_POST['recovery_f']) {

    message('Восстановление пароля');

} elseif ($_POST['confirm_f']) {

    if ($_SESSION['confirm']['type'] == 'register') {
        if ($_SESSION['confirm']['code'] != $_POST['code']) message('Код подтверждения не верный!');
        mysqli_query($connect, 'INSERT INTO `users` VALUES ("", "'.$_SESSION['confirm']['email'].'", "'.$_SESSION['confirm']['password'].'")');
        unset($_SESSION['confirm']);

        go('login');

    } else {
        not_found();
    }

}


?>