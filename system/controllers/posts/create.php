<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/system-core/global_pass.php');


//собираем массивы полей и значение из $_POST
$arr_fields =[];
$arr_values =[];
foreach($_POST as $key=>$value){
	if($key != 'table_id'){
		$arr_fields[] = $key;
		$arr_values[] = $value;
	}
}

//var_dump($_FILES);

//var_dump($_POST)  ;   

//достаем папку сущности
$table = new Table((int)$_POST['table_id']);
$dir = $table->getField('table_folder');

$full_dir = PROJECT_ROOT.'/uploads/'.$dir;

if(!file_exists($full_dir) && !is_dir($full_dir)){
	mkdir($full_dir,0777);
}

//создаем новый пост и получаем его id
$post = new Post(0);
$post->getTable($table->getField('title'));
$post_id = $post->createLine([],[]); 
$post_dir = $dir.'/'.$post_id.'/';

$full_post_dir = PROJECT_ROOT.'/uploads/'.$post_dir;

if(!file_exists($full_post_dir) && !is_dir($full_post_dir)){
	mkdir($full_post_dir,0777);    
}

//echo $dir;  
//echo $full_dir;  


if(isset($_FILES)){ // Проверяем, загрузил ли пользователь файл
	//определяем все поля файлов
	$fields_arr =[];
	foreach($_FILES as $key=>$value){
		$fields_arr[] = $key;
	}	


	//считаем сколько полей пришло
	$files_count = count($fields_arr);
	
	//для каждого инпута смотрим файлы
	for($i = 0; $i < $files_count; $i++){
		
		//считаем файлы в инпуте	
		$files_of_field = count($_FILES[$fields_arr[$i]]['name']);
		
		$arr_fields[] = $fields_arr[$i];
		
		$dist_arr = [];
		//для всех файлов в инпуте
		for($j =0; $j < $files_of_field; $j++){
			//формируем имя файла - поный путь вплоть до имени
			$destiation_dir = PROJECT_ROOT."/uploads/$post_dir/".$_FILES[$fields_arr[$i]]['name'][$j]; // Директория для размещения файла
			//загружаем временный файл по указанному пути
			move_uploaded_file($_FILES[$fields_arr[$i]]['tmp_name'][$j], $destiation_dir ); // Перемещаем файл в желаемую директорию
			$dist_arr[] = "/uploads/$post_dir/".$_FILES[$fields_arr[$i]]['name'][$j];
			echo 'File Uploaded'; // Оповещаем пользователя об успешной загрузке файла 
		}
		
		$dist_string = json_encode($dist_arr);
		$arr_values[] = $dist_string;
		
	}
	
}else{
	echo 'No File Uploaded'; // Оповещаем пользователя о том, что файл не был загружен
}


	
	//создаем/обновляем
    $post->updateLine($arr_fields ,$arr_values);

//header("Location: ".PROJECT_URL."/index.php");    
