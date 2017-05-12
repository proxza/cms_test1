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

// Функция вывода pop-up сообщений
function message($text) {
    exit ('{ "message" : "'.$text.'"}');
}

// Функция редиректа
function go($url) {
    exit ('{ "go" : "'.$url.'" }');
}

// Вывод верха страницы и заголовков
function top($title) {
    echo '<!DOCTYPE html>
    <html>
    <head>
    <meta charset="UTF-8">
    <title>'.$title.'</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-1.12.4.js" integrity="sha256-Qw82+bXyGq6MydymqBxNPYTaUXXq7c8v3CwiYwLLNXU="
    crossorigin="anonymous"></script>
    <script src="js/script.js"></script>
    </head>
    
    <body>
    
    <div class="wrapper">
    <div class="menu">
    <a href="/">Главная</a>
    <a href="/login">Вход</a>
    <a href="/register">Регистрация</a>
    </div>
    <div class="content">
    <div class="block">
  
    ';
}

// Вывод низа страницы
function bottom() {
    echo '</div></div></div>
    </body>
    </html>';
}






?>