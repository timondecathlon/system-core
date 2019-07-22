<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/system-core/global_pass.php');

?>

<form action="<?=PROJECT_URL?>/system/controllers/posts/create.php" method="POST" enctype="multipart/form-data">             
	<input type="text" name="title" value="" placeholder="название" />
	<input type="num" name="price" value="" placeholder="цена" />   
	 
	
	
		
		<input id="test1" style="display: none;" type="file" name="photo[]"  multiple />
		<label for="test1" style="width: 50px; height: 20px; background: red;">
			бло бло
		</label>	
			
	<input type="hidden" name="table_id" value="1" />
	<button>Send</button>
</form>



<?/*






<!--
Удаление
<form action="<?=PROJECT_URL?>/system/controllers/posts/delete.php" method="POST">             
	<input type="num" name="id" value="" placeholder="какой пост удалить?" />
	<input type="hidden" name="table_id" value="1" />
	<button>Send</button>
</form>

-->

<?

 $banner = new Post(0);
 $banner->getTable('banners'); 
 //echo  $banner->getField('photo');
 
 $all_banners = $banner->getAllUnits();
 
 foreach($all_banners as $banner_item){
		$banner = new Post($banner_item['id']);
		$banner->getTable('banners');
		echo $banner->getField('title').$banner->getField('photo').$banner->getField('link');
		?>
		Удаление ПОСТА НОМЕР <?=$banner->getField('id')?>
			<form action="<?=PROJECT_URL?>/system/controllers/posts/delete.php" method="POST">             
				<input type="hidden" name="id" value="<?=$banner->getField('id')?>" placeholder="какой пост удалить?" />
				<input type="hidden" name="table_id" value="<?=$banner->setTableId()?>" />
				<button>Удалить</button>
			</form>
		
		<?
		echo '<br>';
		echo '<br>'; 
 }
/*
	//var_dump($banner->getAllUnits());
	
	
	
	<a href="card.php?id=<?=$good->getField('id')?>" />
	
	</a>
	
	
	$good = new Post($_GET['id']);
	$good->getTable('goods');
	
	<?=$good->getField('price')?>
	
	<?=$good->getField('title')?>
	
	<?=$good->getField('articul')?>
	
	<?=$good->getField('photo')?>
	
	
	
	<form action="<?=PROJECT_URL?>/system/controllers/basket/create.php" method="POST">
		<input type="hidden" name="id" value="<?=$good->getField('id')?>"/>
		<button>Добавить в корзину</button>
	</form>
	
	
	<form action="<?=PROJECT_URL?>/system/controllers/basket/delete.php" method="POST">
		<input type="hidden" name="id" value="<?=$good->getField('id')?>"/>
		<button>x</button>
	</form>
	
	
	

?>



