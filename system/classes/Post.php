<?php
class Post extends Unit  
{
  
	//метод для прокидывания таблицы в пост + плюс провека а есть ли такая таблица
    public function getTable($table){
        $tables = new Table(0);
        if(in_array($table,$tables->getAllTables(DB_NAME))){
            $this->table = $table;   
        }else{    
			echo 'table doesnt exist lol =)';
		}
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

