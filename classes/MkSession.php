<?php

require_once __DIR__."/Db.php";

class MkSession{
    private $conection;
    private $data;
    
    function open(){
        if($this->conection=Db::getInstance())
            return true;
        return false;
    }
    
    function close(){

        if(!empty($this->data)){
            $result = $this->gc(ini_get('session.gc_maxlifetime'));
            return $result;
        }
        return false;
    }
    
    function read($session_id){
        
        $query = "SELECT * FROM php_session WHERE session_id = ?";
        if($stmt=$this->conection->prepare($query)){
            $stmt->bindParam(1, $session_id,PDO::PARAM_INT);
            if($stmt->execute()){
                if($row=$stmt->fetch(PDO::FETCH_ASSOC)){
                    $this->data=$row;
                    return $row['session_data'];
                    
                }else{
                    return "";  
                }
            }else{
                return "";
            }
        }else{
            return "";
        }
    }
    
    function write($id,$data){
        if (!empty($this->data)) {
            if ($this->data['session_id'] != $id) {
                $this->data = null;
            } 
        }
        
        if(empty($this->data)){
            $created=$this->conection->getTimestamp();
            $updated=$created;
            $user_id=$_SESSION["user_id"]?$_SESSION["user_id"]:"";
            $query="INSERT INTO php_session(session_id,date_created,last_updated,session_data,user_id) VALUES(?,?,?,?,?)";
            $stmt=$this->conection->prepare($query);
            $stmt->bindParam(1,$id,PDO::PARAM_STR);
            $stmt->bindParam(2,$created,PDO::PARAM_STR);
            $stmt->bindParam(3,$updated,PDO::PARAM_STR);
            $stmt->bindParam(4,$data,PDO::PARAM_STR);
            $stmt->bindParam(5,$user_id,PDO::PARAM_INT);
            if($stmt->execute()){
                return true;
            }else{
                throw new DbException("Error on session:",$stmt);
            }
        }else{
            
            $updated=$this->conection->getTimestamp();
            $created=$this->conection->getTimestamp();
            $user_id=$_SESSION["user_id"];
            $query="UPDATE php_session SET user_id=?,last_updated=?,session_data=? WHERE session_id=?";
            
            $stmt=$this->conection->prepare($query);
            $stmt->execute(array($user_id,$updated,$data,$id));
        }
        return true;
    }
    
    function destroy($id){
        
        $query="DELETE FROM php_session WHERE session_id=?";
        $stmt=$this->conection->prepare($query);
        $stmt->bindParam(1,$id,PDO::PARAM_INT);
        $stmt->execute();
        return true;
    }
    
    function gc($max_lifetime){
        
        $real_now = Db::getInstance()->getTimestamp();
        
        $dt1 = strtotime("$real_now - $max_lifetime seconds");
        $dt2 = date('Y-m-d H:i:s', $dt1);
        
        $query ="DELETE FROM php_session WHERE last_updated < ?";
        $stmt=Db::getInstance()->prepare($query);
        $stmt->bindParam(1,$dt2,PDO::PARAM_STR);
        $stmt->execute();
        return true;
    }
    
    function __destruct ()
    // ensure session data is written out before classes are destroyed
    // (see https://bugs.php.net/bug.php?id=33772 for details)
    {
        @session_write_close();

    }
    
    
    
}
