<?php

//Корень проекта там где лежит  global_pass.php
define('PROJECT_ROOT', __DIR__);

//подключаем отображение ошибок
include_once(PROJECT_ROOT.'/errors.php');

//Формируем URL
$isHttps = !empty($_SERVER['HTTPS']) && 'off' !== strtolower($_SERVER['HTTPS']);
($isHttps) ? $protocol = 'https' : $protocol = 'http';
//если папка не в корне домена то менять )
$hostname = $protocol.'://'.$_SERVER['HTTP_HOST'].'/';
$parts = explode($_SERVER['HTTP_HOST'],__DIR__);
$folder = array_pop($parts);
define('PROJECT_URL',$protocol.'://'.$_SERVER['HTTP_HOST'].$folder);

//Записываем пассы в константы
define("DB_HOST", 'localhost');
define("DB_NAME", 'db_name_here');
define("DB_USER", 'db_user_here');
define("DB_PASSWORD", 'db_pass_here');

//Для процедурки  
$pdo = new \PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASSWORD);
$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
$pdo->exec("set names utf8");

//для использования классов
include_once(PROJECT_ROOT.'/system/classes/autoload.php');

