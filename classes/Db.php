<?php
/**
 * This class manage the database conection
 * Uses the singleton patter to avoid to many connections
 */
 class Db{
     
   /**#@+
    * @access protected
    * @var string
    */  
   protected $host='localhost';
   protected $database='mksc';
   protected $user='root';
   protected $pass='root';
   /**#@-*/
   
   /**
    * The conection variable whith the active conection
    * @access public
    * @var PDO
    */
   public $conexion;
   
   protected static $instancia;
   
   /**
    * The constructor of our class set to private so it can be called from outside
    */
   private function __construct(){
        try {
            $this->conexion=new PDO("mysql:host=$this->host;dbname=$this->database;charset=utf8",$this->user,$this->pass);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
   }
   
   /**
    * The get instance methof form wich we're gona get the active instance
    */
   public static function getInstance(){
       if ( !self::$instancia instanceof self) {
         self::$instancia = new self;
      }
      return self::$instancia;
   }
   
   
   /**
    * Function to prepare a statement
    * @param String $query The SQL query we are going to execute
    * @return PDOStatement the statement whit the resul
    */
   public function prepare($query){
       return $this->conexion->prepare($query);
   }
   
   /**
    * Metod tho get the last error info of our conection
    * @return Array Info array of the last error
    */ 
   public function getError(){
       return $this->conexion->errorInfo();
   }
   
   /**
    * Method to return the last insert id
    * @return mixed The last insert Id
    */ 
   public function getLastId(){
       return $this->conexion->lastInsertId();
   }
}
 
/**
 * Exception class for the database
 */
class DbException extends Exception{
    public function __construct($message,$stmt=null ,$code = 0, Exception $previous = null){
        
        if($stmt!=null)
            $error=$stmt->errorInfo();
        else{
            $database=Db::getInstance();
            $error=$database->getError(); 
        }
           
        $message.=" ".$error[2];
        parent::__construct($message, $code, $previous);
    }
    
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
