<?php
//ini_set('error_reporting', E_ALL);ini_set('display_errors', 1);ini_set('display_startup_errors', 1);

require_once($_SERVER['DOCUMENT_ROOT'].'/nordic/your_name/global_pass.php');


$id = $_POST['id'];
$table_id = $_POST['table_id'];


//проверяем залогинен ли юзер
$logedUser = new Member($_COOKIE['member_id']);

//Если юзер валиден
//if($logedUser->is_valid()){
		
	//создаем экземпляр класса для записи/обновления	
	   $post = new Post($id);
	
	//Достаем насзавние таблицы по id
	$table = new Table($table_id);

	//Указываем в какой таблице будем создавать/обновлять
    $post->getTable($table->title());
	
	//создаем/обновляем
    $post->create();

//}else{
   // header("Location: ".$_SERVER['HTTP_REFERER']);
   // echo "F*ck you, hacker=)";
//}

