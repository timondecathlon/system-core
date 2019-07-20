<?php
class Table extends Unit{

	public function setTable(){
        return 'core_tables';
    }

	public function title(){
        return $this->getField('title');
    }
	

	
    public function tableId(){
        return $this->getField('id');
    }

    

    
    public function addColumn($name , $type){
        $add_sql = $this->pdo->prepare("ALTER TABLE ".$this->setTable()." ADD $name $type");
        $add_sql->execute();
    }

    public function getTableByName($title){
        $sql = $this->pdo->prepare("SELECT * FROM ".$this->setTable()." WHERE title=:title");
        $sql->bindParam(':title', $title);
        $sql->execute();
        $unit = $sql->fetch(PDO::FETCH_LAZY);
        $this->id = $unit->id;
    }
	
	


}
