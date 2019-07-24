<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/system-core/global_pass.php');



//смотри м все данные пришедшие постом
//var_dump($_POST);

//смотрим все файлы пришедшие 
//var_dump($_FILES);

//создаем экземпляр универсального класса Post что работать с таблицей (записывать в нее)
$post = new Post(0);

//Создаем экземпляр класса Table чтобы по переданному айдишнику таблицы  узнать инфу о таблице например ее название
$table = new Table($_POST['table_id']);
$table_name = $table->getField('title');

//смотри название таблицы
//echo $table_name;

//сообщаем название экзэмпляру класса - теперь он знает с какой таблицей работать
$post->getTable($table_name);

//получаем все колонки в таблице с данными сущностями
$post_columns = $post->getTableColumnsNames();

//смотри массив полей
//var_dump($post->getTableColumnsNames());

//создаем новую строку(пост) в таблице и получаем его id
$post_id = $post->createLine([],[]);

//набираем массив полей и массив значений
$arr_fields = [];
$arr_values = [];


//для кадого столбца в таблице
foreach($post_columns as $column){
	
	
	//если передан пост элемент для этой колонки то обрабатываем
	if($_POST[$column]){
		//добавлячем это поле в массив полей
		$arr_fields[] = $column;
		
		if($column == 'password'){
			//если это поле пароль то криптуем значение в нем
			$value = crypt($_POST[$column]);
		}elseif(is_array($_POST[$column])){
			//если это поле массив то сериализуем его в json строку
			$value = json_encode($_POST[$column]);
		}else{
			//иначе просто сохраняем
			$value = $_POST[$column];
		}
		//записываем значение для поля в массив значений
		$arr_values[] = $value;
		
	}
	
	
	//если передан файл для этой колонки обрабатываем
	if($_FILES[$column]){
		
		//смотрим название папуи для сущностей в таблице таблиц
		$dir =  '/uploads/'.$table->getField('table_folder').'/';
		//если папка не существует то ее создаем с правами
		if(!file_exists(PROJECT_ROOT.$dir) && !is_file(PROJECT_ROOT.$dir)){
			mkdir(PROJECT_ROOT.$dir,0777);
		}

		
		//echo  $dir;

		//создаем путь для папки конкретного поста по id (название папки совпадает с id поста в таблице в БД)
		$post_dir = $dir.$post_id.'/';
		
		
		//echo  $post_dir;

		//если папка не существует то ее создаем с правами
		if(!file_exists(PROJECT_ROOT.$post_dir) && !is_file(PROJECT_ROOT.$post_dir)){
			mkdir(PROJECT_ROOT.$post_dir,0777);
		}	

		//если это множественные файлы
		if(is_array($_FILES[$column]['name'])){
				
			//считаем количество файлов	
			$names_count = count($_FILES[$column]['name']);
			for($i = 0; $i < $names_count; $i++){
				//загружаем файл и пишем ссылку на него в массив ссылок для этого файла
				move_uploaded_file($_FILES[$column]['tmp_name'][$i], PROJECT_ROOT.$post_dir.$_FILES[$column]['name'][$i] );
				$arr_files[] = $post_dir.$_FILES[$column]['name'][$i];
			}  
			
			//добавлчяем поле в массив полей
			$arr_fields[] = $column; 
			//сериализуем все ссылки и добавляем в массив значений
			$arr_values[] = json_encode($arr_files);
		
		}else{
			//иначе загружаем файли
			move_uploaded_file($_FILES[$column]['tmp_name'], PROJECT_ROOT.$post_dir.$_FILES[$column]['name'] );

			//добавлчяем поле в массив полей
			$arr_fields[] = $column;
			//сериализуем все ссылки и добавляем в массив значений			
			$arr_values[] = $post_dir.$_FILES[$column]['name'];
		}
		   
		
	}     
}

/*
устаревший код
foreach($_POST as $key=>$value){
	if($key != 'table_id'){
		$arr_fields[] = $key;
		if($key == 'password'){
			$arr_values[] = crypt($value);
		}elseif(is_array($value)){
			$value = json_encode($value);
		}else{
			$arr_values[] = $value;
		}
	}
}
*/



//выводим набранные массивы
//var_dump($arr_fields);
//var_dump($arr_values);

//обновляем поля созданного поста
$post->updateLine($arr_fields,$arr_values);




/*



















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
