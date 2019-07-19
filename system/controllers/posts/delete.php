<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/system-core/global_pass.php');

$id = (int)$_POST['id'];   
$table_id = (int)$_POST['table_id'];

$post = new Post($id);
	
//Достаем насзавние таблицы по id
$table = new Table($table_id);
	
//Указываем в какой таблице будем создавать/обновлять
$post->getTable($table->title());
	
//Удаляем пост
$post->deleteLine();

header("Location: http://sonicspeed.ru/system-core/index.php");
    

