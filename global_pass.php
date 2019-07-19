<?php

//Корень проекта там где лежит  global_pass
define('PROJECT_ROOT', __DIR__);

$isHttps = !empty($_SERVER['HTTPS']) && 'off' !== strtolower($_SERVER['HTTPS']);
($isHttps) ? $protocol = 'https' : $protocol = 'http';

//если папка не в корне домена то менять )
$hostname = $protocol.'://'.$_SERVER['HTTP_HOST'].'/';
define('PROJECT_URL',$protocol.'://'.$_SERVER['HTTP_HOST']);


define("DB_HOST", 'localhost');
define("DB_NAME", 'pennylane');
define("DB_USER", 'timon');
define("DB_PASSWORD", '20091993dec');

//на всякий случай оставляем для процедурки
$pdo = new \PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASSWORD);
$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
$pdo->exec("set names utf8");