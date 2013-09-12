<?php
require_once __DIR__."/Db.php";

class Message{
    public $id;
    public $chat_id;
    public $type;
    public $content;
    public $date;
    
    
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
}
