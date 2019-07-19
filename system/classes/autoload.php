<?php
//если папка не в корне домена то менять )
//require_once('./global_pass.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');

function classLoader($class) {
    require_once( PROJECT_ROOT.'/system/classes/'.str_replace('\\','/',$class.'.php'));
}
spl_autoload_register('classLoader');


