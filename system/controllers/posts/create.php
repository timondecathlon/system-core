<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/system-core/global_pass.php');

//получаем айди тамблицы куда писать
$table_id = $_POST['table_id'];

//собираем массивы полей и значение
$arr_fields =[];
$arr_values =[];
foreach($_POST as $key=>$value){
	if($key != 'table_id'){
		$arr_fields[] = $key;
		$arr_values[] = $value;
	
	}
}

	
	//создаем экземпляр класса для записи/обновления	
    $post = new Post(0);
	
	//Достаем насзавние таблицы по id
	$table = new Table($table_id);

	//Указываем в какой таблице будем создавать/обновлять
    $post->getTable($table->title());
	
	//создаем/обновляем
    $post->createLine($arr_fields ,$arr_values);

header("Location: http://sonicspeed.ru/system-core/index.php");
