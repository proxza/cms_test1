<?php

if ($_POST['edit_f']) {

    if ($_POST['password'] and md5($_POST['password']) != $_SESSION['password']) {
        password_valid();
        mysqli_query($connect, "UPDATE `users` SET `password` = '$_POST[password]' WHERE `email` = '$_SESSION[email]'");
    }

    message('Данные сохранены');

}


?>