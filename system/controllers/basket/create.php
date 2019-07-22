<?php

//require_once($_SERVER['DOCUMENT_ROOT'].'/system-core/global_pass.php');

session_start();

$id = (int)$_POST['id'];

if(!in_array($id,$_SESSION['basket'])){
	array_push($_SESSION['basket'],$id);
}  