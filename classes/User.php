<?php

require_once __DIR__."/Db.php";
require_once __DIR__."/Chat.php";
require_once __DIR__."/Message.php";

/**
 * Clase para el manejo de los Usuarios
 */
 
class User{
    
    /**
     * User's id
     * @access public
     * @var int
     */
    public $id;
    /**
     * User's username
     * @access public
     * @var string
     */
    public $username;
    /**
     * User's password
     * @access public
     * @var string
     */
    public $password;
    /**
     * User's display name
     * @access public
     * @var string
     */
    public $display_name;
    
    /**
     * Constructor de User
     * @param Array $data array whit the users data 
     */
    private function __construct($data){
        $this->id=$data['id'];
        $this->username=$data['username'];
        $this->password=$data['password'];
        $this->display_name=$data['display_name'];
    }
    
    /**
     * Creates a new user and returns an instanceof the class
     * @param string $username User's username
     * @param string $password User's password
     * @param string $display_name User's display name
     * @return User
     */
    public static function getNewUser($username,$password,$display_name){
        if($username==""||$password==""||$display_name==""){
            throw new UserException("Invalid data");
        }
        $query="INSERT INTO user (username,password,display_name) VALUES(?,?,?)";
        $dbconnection = Db::getInstance();
        if($stmt=$dbconnection->prepare($query)){
            $stmt->bindParam(1,$username,PDO::PARAM_STR);
            $stmt->bindParam(2,md5($password),PDO::PARAM_STR);
            $stmt->bindParam(3,$display_name,PDO::PARAM_STR);
            if($stmt->execute()){
                $id=$dbconnection->getLastId();
                return User::getUser($id);
            }else{
                throw new DbException("Cannot be saved: Statement error",$stmt);
            }
        }else{
            throw new DbException("Cannot be saved: Database error");
        }
    }
    
    /**
     * Return an instance whit the data of an existing user
     * @param int $id User's id
     *  @return User
     */
    public static function getUser($id){
        $query="SELECT * FROM user WHERE id=?";
        $dbconnection = Db::getInstance();
        if($stmt=$dbconnection->prepare($query)){
            $stmt->bindParam(1,$id,PDO::PARAM_INT);
            if($stmt->execute()){
                if($row=$stmt->fetch(PDO::FETCH_ASSOC)){
                    return  new self($row);
                }else{
                    throw new UserException("Usuario no encontrado");
                }
            }else{
                throw new DbException("Cannot be loaded: Statement error",$stmt);
            }
        }else{
            throw new DbException("Cannot be loaded: Database error");
        }
    }
    
    /**
     * Verifies the user credentials
     * @param string $username 
     * @param string $password
     * @return boolean
     * @throws DbException
     */
    public static function validateUser($username,$password){
        $query="SELECT id FROM user WHERE username=? AND password=?";
        $dbconnection=Db::getInstance();
        if($stmt=$dbconnection->prepare($query)){
            $stmt->bindParam(1,$username,PDO::PARAM_STR);
            $stmt->bindParam(2,md5($password),PDO::PARAM_STR);
            if($stmt->execute()){
                if($row=$stmt->fetch()){
                    return $row['id'];
                }else{
                    return false;
                }
            }
            else{
                throw new DbException("Cannot be checked: Statement error",$stmt);
            }
        }else{
            throw new DbException("Cannot be checked: Database error");
        }
    }
    
    /**
     * Sends a clien message
     * @param string @message the message content
     * @param int @chat_id  the tarcget chat id
     * @return boolean
     */
    public function sendMessage($message,$chat_id){
       $type=2;
       if($this->hasChat($chat_id)){
           if(Message::sendMessage($chat_id, $type, $message)){
               return true;
           }else{
               return false;
           }
       }else{
           return false;
       }
    }
    
    /**
     * Verifies that a user owns a chat
     * @param int $id The chat id
     * @return boolean  
     * @throws DbException
     */
    public function hasChat($id){
        $query="SELECT id FROM chat WHERE id=? and user_id=$this->id";
        $db=Db::getInstance();
        if($stmt=$db->prepare($query)){
            $stmt->bindParam(1,$id,PDO::PARAM_INT);
            if($stmt->execute()){
                if($stmt->fetch())
                    return true;
                else {
                    return false;
                }
            }else{
                throw new DbException("Error:",$stmt);
            }
        }else{
            throw new DbException("Error:");
        }
    }
    
    
    public function getChats(){
        $db = Db::getInstance();
        $query="SELECT * FROM chat WHERE status=1 AND user_id=$this->id";
        $stmt = $db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

/**
 * Exception class for the user class
 */
class UserException extends Exception{
    public function __construct($message, $code = 0, Exception $previous = null){
        parent::__construct($message, $code, $previous);
    }
    
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
