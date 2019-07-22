 class DB
{
  	
	public function __construct($host, $user, $password, $db_name) {

     $this->connection = new mysqli($host, $user, $password, $db_name);

     if( !$this->connection ) {
         throw new Exception('Could not connect to DB ');
     }
}

	
	}
	
	//или ваш вариант
	class Connect{
	protected static $db_host = DB_HOST;
	protected static $db_user = DB_USER;	
    protected static $db_password = DB_PASSWORD;     
    protected static $db_name = DB_NAME;
    
    
	
	
    public function __construct(int $id){   
        $this->id = $id;
        $this->mysqli = new mysqli(self::$db_host, self::$db_user, self::$db_password, self::$db_name);       
        $this->mysqli->query("SET 1c_time_names = 'ru_RU'");
        $this->mysqli->query("SET NAMES 'utf8'");
	}
	}