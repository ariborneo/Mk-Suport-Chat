<?php
require_once __DIR__."/Db.php";

class Message{
    /**
     * Message's id
     * @access public
     * @var int
     */
    public $id;
    /**
     * Belonggin chat
     * @access public
     * @var int
     */
    public $chat_id;
    /**
     * Message's Type (1=client,2=user,3=system)
     * @access public
     * @var int
     */
    public $type;
    /**
     * Message's Body
     * @access public
     * @var String
     */
    public $content;
    /**
     * Message's date
     * @access public
     * @var string
     */
    public $date;
    
    /**
     * Sends message
     * @param int $chat_id id of the chat that gets the message
     * @param int $type the message type
     * @param string $content the message body
     * @return boolean
     * @throws DbException
     */
    public static function sendMessage($chat_id,$type,$content){
        $query="INSERT INTO message (chat_id,type,content) VALUES(?,?,?)";
        $db=Db::getInstance();
        if($stmt=$db->prepare($query)){
            $stmt->bindParam(1,$chat_id,PDO::PARAM_INT);
            $stmt->bindParam(2,$type,PDO::PARAM_INT);
            $stmt->bindParam(3,$content,PDO::PARAM_STR);
            if( $stmt->execute() ){
                return true;
            }else{
                throw new DbException("Can't be send:",$stmt);
            }
        }else{
            throw new DbException("Can't be send:");
        }
    }
    
    
    /**
     * GETS an array whit the latest messages of a chat
     * @param String $date the start date
     * @param int $chat the chat id
     * @return array array of message objects
     * @throws DbException
     */
    public static function getLatestMessages($date,$chat){
        $query="SELECT * FROM message WHERE date > ? AND chat_id = ? ORDER BY date";
        $db =Db::getInstance();
        if($stmt=$db->prepare($query)){
            $stmt->bindParam(1,$date,PDO::PARAM_STR);
            $stmt->bindParam(2,$chat,PDO::PARAM_INT);
            if($stmt->execute()){
                return $stmt->fetchAll(PDO::FETCH_OBJ);
            }{
                throw new DbException("Can't get messages:",$stmt);
            }
        }else{
            throw new DbException("Can't get messages:");
        }
    }
    
}
