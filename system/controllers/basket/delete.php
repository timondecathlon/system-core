<?

session_start();

$id = (int)$_POST['id'];

//есть ли такой товар в корзине
if(in_array($id,$_SESSION['basket'])){
	//считаем количество товаров в корзине
	$count = count($_SESSION['basket'])
	//бежим по корзине и ищем конкретный товар
	for($i = 0; $i < $count; $i++){
		//если нашшли этот товар 
		if($_SESSION['basket'][$i] == $id){
			//то удаляем из корзины
			unset($_SESSION['basket'][$i]);
			break;
		}
		
	}
	sort($_SESSION['basket']);
}  