<?php

require_once __DIR__."/Db.php";
require_once __DIR__."/Chat.php";
require_once __DIR__."/Message.php";
/**
 * This class manage the messages and information of the client}
 */
class Client{
    
    
    /**
     * The client id
     * @access public
     * @var int
     */
   public $id; 
    
   /**
    * The client name
    * @access public
    * @var string
    */
   public $name;
   /**
    * The client email
    * @access public
    * @var string
    */
   public $email;
   
   /**
    * The client last activiti
    * @access public
    * @var string
    */
   private $last_activity;

   
   private $chat=null;
   
   /**
    * Conection for the object
    * @access private
    * @var Db
    */
   private $dbconection;
   
   /**
    * Add the data sent to the object and store it on the db
    * @param array $data the client data
    * @param String $name The name of the client
    * @param String $email The email of the client
    */
   protected function __construct($data){
       $this->id=$data['id'];
       $this->name=$data['name'];
       $this->email=$data['email'];
       $this->last_activity=$data['last_activity'];
       $this->dbconection=Db::getInstance();
   }
   
   /**
    * Creates a new client and stores it in the database
    * @param String $name The name of the new client
    * @param String $email The email of the new client
    * @return Client
    */
   public static function getNewClient($name,$email){
       if($name==""||$email==""){
           throw new ClientException("The name and/or email cannot be empty");
       }
       $dbconection=Db::getInstance();
       $query="INSERT INTO client (name,email,last_activity) VALUES(?,?,NOW())";
       if($stmt=$dbconection->prepare($query)){
           $stmt->bindParam(1,$name,PDO::PARAM_STR);
           $stmt->bindParam(2,$email,PDO::PARAM_STR);
           if($stmt->execute()){
               $id= $dbconection->getLastId();
               return Client::getClient($id);
           }else{
               throw new DbException("Cannot be saved: Statement error");
           }
       }else{
           throw new DbException("Cannot be saved: Database error");
       }
   }

   
   /**
    * Get an existent Clien from the database
    * @param int $id The id of the Client
    * @return Client
    */
   public static function getClient($id){
       if($id<1){
           throw new ClientException("Invalid Id");
       }
       $dbconection=Db::getInstance();
       $query="SELECT * FROM client WHERE id=?";
       if($stmt=$dbconection->prepare($query)){
           $stmt->bindParam(1,$id,PDO::PARAM_INT);
           if($stmt->execute()){
               if($row=$stmt->fetch(PDO::FETCH_ASSOC)){
                   return new self($row);         
               }else{
                   throw new ClientException("User not found");
               }
           }else{
               throw new DbException("Statement error",$stmt);
           }
       }else{
           throw new DbException("Database error");
       }
   }
   
   
   
   /**
    * Gets the chat id if user has no chat assigned, it creates one and assigns it
    * @return Chat
    */
   public function getChat(){
       if($this->chat!=null)
            return $this->chat;
       
       $query="SELECT id FROM chat WHERE client_id=?";
       if($stmt=$this->dbconection->prepare($query)){
           $stmt->bindParam(1,$this->id,PDO::PARAM_INT);
           if($stmt->execute()){
               if($row =$stmt->fetch(PDO::FETCH_ASSOC)){
                   $this->chat=Chat::getExistingChat($row['id']);
                   return $this->chat;
               }
                    
           }else{
               throw new DbException("Statement error");
           }
       }else{
           throw new DbException("Database error");
       }
       
       $this->chat=Chat::getNewChat($this->id);
       return $this->chat;
   }
   
   
   public function sendMessage($message){
       $chat_id=$this->getChat()->id;
       $type=1;
       if(Message::sendMessage($chat_id, $type, $message)){
           $this->setLastActivity();
           return true;
       }else{
           return false;
       }
   }
   
   
   public function getLastActivity(){
       return $this->last_activity;
   }
   
   public function setLastActivity(){
       $query="UPDATE client SET last_activity=NOW() WHERE id=$this->id";
        if($stmt=$this->dbconection->prepare($query)){
            if($stmt->execute()){
                $newdata=Client::getClient($this->id);
                $this->last_activity=$newdata->getLastActivity();
                return true;
            }else{
                return false;
            }
        }else{
            throw new DbException("Database error");
        }
   }
      
}

/**
 * Exception class for the client class
 */
class ClientException extends Exception{
    public function __construct($message, $code = 0, Exception $previous = null){
        parent::__construct($message, $code, $previous);
    }
    
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
