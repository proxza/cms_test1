<?php

// Вывод ошибок
error_reporting(E_ERROR | E_WARNING | E_PARSE);

// Старт сессии
session_start();

// Обработка ЧПУ
if ($_SERVER['REQUEST_URI'] == '/') {
    $page = 'home';
} else {
    $page = substr($_SERVER['REQUEST_URI'], 1);
    if (!preg_match('/^[A-z0-9]{3,30}$/', $page)) exit ('Error URL!');
}

// Проверка существования файлов (страниц)
if (file_exists('all/'.$page.'.php')) {
    include 'all/'.$page.'.php';
} elseif ($_SESSION['ulogin'] == 1 AND file_exists('auth'.$page.'.php')) {
    include 'auth/'.$page.'.php';
} elseif ($_SESSION['ulogin'] != 1 AND file_exists('guest'.$page.'.php')) {
    include 'guest/'.$page.'.php';
} else {
    exit ('Страница 404');
}






?>