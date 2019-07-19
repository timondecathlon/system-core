<?php
abstract class Unit implements UnitActions
{

	/*конструктор, подключающийся к базе данных*/
	public function __construct(int $id) {
		$this->id = $id;
        $this->pdo = Connect::getInstance()->getConnection();
	}

    abstract public function setTable();


	//Метод для получения строки из таблицы БД
    public function getLine()
    {
        $sql = $this->pdo->prepare("SELECT * FROM ".$this->setTable()." WHERE id='".$this->id."'");
        $sql->execute();
        return $sql->fetch(PDO::FETCH_LAZY);
    }

	//Метод для получения поля из строки в таблице БД
    public function getField($field)
    {
        return trim($this->getLine()->$field);
    }
	
	
	//Метод для создания строки в таблице БД
    public function createLine($fields_array, $values_array){
        $fields_str = implode(',',$fields_array);
        $placeholders_str = '';
        foreach ($fields_array as $key=>$value) {
            $placeholders_str .= ":$value,";
        }
        $sql = $this->pdo->prepare("INSERT INTO ".$this->setTable()."($fields_str)VALUES(".trim($placeholders_str,',').") ");
        foreach($fields_array as $key=>$value){
            $sql->bindParam(":$fields_array[$key]", $values_array[$key]);
        }
        try {
            $sql->execute();
            $this->id = $this->pdo->lastInsertId();
            return $this->id;
        }catch (PDOException $e) {
            echo 'Подключение не удалось: ' . $e->getMessage();
        }
        return 0;
    }
	
	
	//Метод обновления строки в таблице БД
	public function updateLine($fields_array, $values_array){
        $update_str = '';
        foreach($fields_array as $key=>$value){
                $update_str .= "$value=:$value,";
        }
        $sql = $this->pdo->prepare("UPDATE ".$this->setTable()." SET ".trim($update_str,',')."  WHERE id='".$this->id."'");
        foreach($fields_array as $key=>$value){
            $sql->bindParam(":$value", $values_array[$key]);
        }
        try {
            $sql->execute();
            return $this->getField('id');
        }catch (PDOException $e) {
            echo 'Подключение не удалось: ' . $e->getMessage();
        }
        return 0;
    }

	//Метод обновления поля в строке в таблицы БД
    public function updateField($field, $param){
        $sql = $this->pdo->prepare("UPDATE ".$this->setTable()." SET $field=:param WHERE id=:id");
        $sql->bindParam(':param', $param);
        $sql->bindParam(':id', $this->id);
        if(in_array($field,$this->getTableColumnsNames())) {
            if($sql->execute()){
                return true;
            }
        }
        return false;
    }


	//Метод удаления строки из таблицы БД
    public function deleteLine(){
        $sql = $this->pdo->prepare("DELETE FROM ".$this->setTable()." WHERE id=:id");
        $sql->bindParam(':id', $this->id);
        try {
            $post_id = $this->getField('id');
            $sql->execute();
            return $post_id;
        }catch (PDOException $e) {
            echo 'Подключение не удалось: ' . $e->getMessage();
        }
        return 0;
    }


	//Метод "мягкого" удаления строки из таблицы БД (при больших нагрузках)
    public function softDelete(){
        $post_id = $this->getField('id');
        if($this->updateField('deleted', 1)){
            return $post_id;
        }
        return 0;
    }


	//Метод для получения всех столбцов в таблице БД
    public function getTableColumns(){
        $columns_sql= $this->pdo->prepare("SHOW COLUMNS FROM ".$this->setTable()."");
        $columns_sql->execute();
        return $columns_sql->fetchAll();
    }

	//Метод для получения имен всех столбцов в таблице БД
	public function getTableColumnsNames(){
        $par_arr = [];
        foreach ($this->getTableColumns() as $column){
            $par_arr[$column['Field']] = $column['Field'];
        }
        return $par_arr;
    }
	
	//Метод для проверки есть ли поле в таблице БД
	public function hasField($field_name){
        if(in_array($field_name,$this->getTableColumnsNames())){
            return true;
        }
        return false;
    }


	//Метод для получения всех строк в таблице БД
    public function getAllUnits(){
        $sql = $this->pdo->prepare("SELECT * FROM ".$this->setTable());
        $sql->execute();
        $units = $sql->fetchAll();
        return $units;
    }
    
   
}





