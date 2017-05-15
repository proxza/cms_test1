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

// Подключение к базе
$connect = mysqli_connect('localhost', 'root', '', 'cms_1');
if (!$connect) exit ('Не удалось подключиться к базе');

// Проверка существования файлов (страниц)
if (file_exists('all/'.$page.'.php')) {
    include 'all/'.$page.'.php';
} elseif ($_SESSION['ulogin'] == 1 AND file_exists('auth/'.$page.'.php')) {
    include 'auth/'.$page.'.php';
} elseif ($_SESSION['ulogin'] != 1 AND file_exists('guest/'.$page.'.php')) {
    include 'guest/'.$page.'.php';
} else {
    not_found();
}

// Функция вывода pop-up сообщений
function message($text) {
    exit ('{ "message" : "'.$text.'"}');
}

// Функция редиректа
function go($url) {
    exit ('{ "go" : "'.$url.'" }');
}

// Функция рандомной строки
function random_str($num = 30) {
    return substr(str_shuffle('0123456789abcefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $num);
}

// Функция вывода страниц 404 (не найденных)
function not_found() {
    exit ('Страница 404');
}

// Капча
function captcha_show() {
    $questions = array(
        1 => 'Столица России?',
        2 => 'Столица Украины?',
        3 => 'Столица США?',
        4 => 'Имя короля поп музыки?',
        5 => 'Разработчики GTA V?',
        6 => 'Столица Франции?',
        7 => 'Столица Великобритании?',
        8 => 'Столица Китая?',
        9 => 'Ближайший спутник Земли?',
        10 => 'Самая красная планета?',
    );

    // Рандомный выбор вопроса
    $num = mt_rand(1, count($questions));
    $_SESSION['captcha'] = $num;

    echo $questions[$num];
}

// Проверка капчи
function captcha_valid() {
    $answers = array(
        1 => 'москва',
        2 => 'киев',
        3 => 'вашингтон',
        4 => 'майкл',
        5 => 'rockstar',
        6 => 'париж',
        7 => 'лондон',
        8 => 'токио',
        9 => 'луна',
        10 => 'марс',
    );

    // Проверка ответа в сессии
    if ($_SESSION['captcha'] != array_search(mb_strtolower($_POST['captcha']), $answers)) {
        message('Ответ на вопрос указан не верно!');
    }
}

// Проверка почты на валидность
function email_valid() {
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        message('E-mail указан не верно!');
    }
}

// Проверка пароля на валидность
function password_valid() {
    if (!preg_match('/^[A-z0-9]{6,20}$/', $_POST['password'])) {
        message('Пароль не соответствует требованиям!');
    }

    // Шифруем пароль md5
    $_POST['password'] = md5($_POST['password']);
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