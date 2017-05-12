<?php

if ($_POST['login_f']) {
    message('Авторизация');
} elseif ($_POST['register_f']) {
    go('login');
} elseif ($_POST['recovery_f']) {
    message('Восстановление пароля');
} elseif ($_POST['confirm_f']) {
    message('Подтверждение');
}


?>