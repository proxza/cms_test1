<?php

top('Выход');

session_unset($_SESSION);
session_destroy();
go('login');

?>


<?php


bottom();

?>
