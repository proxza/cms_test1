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
} elseif ($_SESSION['ulogin'] == 1 AND file_exists('auth/'.$page.'.php')) {
    include 'auth/'.$page.'.php';
} elseif ($_SESSION['ulogin'] != 1 AND file_exists('guest/'.$page.'.php')) {
    include 'guest/'.$page.'.php';
} else {
    exit ('Страница 404');
}

// Вывод верха страницы и заголовков
function top($title) {
    echo '<!DOCTYPE html>
    <html>
    <head>
    <meta charset="UTF-8">
    <title>'.$title.'</title>
    <link rel="stylesheet" href="style.css">
    </head>
    
    <body>
    
    <div class="wrapper">
    <div class="menu">
    <a href="/">Главная</a>
    <a href="/">Вход</a>
    <a href="/">Регистрация</a>
    </div>
    <div class="content">
    <div class="block"> Content
    
    
    ';
}

// Вывод низа страницы
function bottom() {
    echo '</div></div></div>
    </body>
    </html>';
}






?>