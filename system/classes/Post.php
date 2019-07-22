<?php
class Post extends Unit  
{
  
	//метод для прокидывания таблицы в пост + плюс провека а есть ли такая таблица
    public function getTable($table){       
        $this->table = $table;          
    }  

    public function setTable(){
        return $this->table;
    }
	
	
	public function postId(){
        return (int)$this->getField('id');
    }

	public function title(){
        return $this->getField('title');
    }
    
    public function description(){
        return $this->getField('description');
    }


    public function setTableId(){
        $table = new Table(0);
        $table->getTableByName($this->setTable());
        return $table->tableId();
    }
  
}

