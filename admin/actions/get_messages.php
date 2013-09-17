<?php 
require_once '../session_initializer.php';
require_once __DIR__."/../../classes/Client.php";
require_once __DIR__."/../../classes/Message.php";
require_once __DIR__."/../../classes/Chat.php";

if(isset($_SESSION['user_id'])){
    if(isset($_POST['last_update'])){
        $last_update=isset($_SESSION['last_update'])?$_SESSION['last_update']:"0000-00-00 00:00:00";
        $response = array();
        $response['updated']=$last_update;
        $chat=Chat::getExistingChat($_POST['chat']);
        $messages=Message::getLatestMessages($last_update, $_POST['chat']);
        $last=end($messages);
        if(isset($last['date']))
            $last_update=$last['date'];
       
        $client_name = $chat->getClientName();
        $user_name = $chat->getUserName();
        
        $response['user_name']=$user_name;
        $response['client_name']=$client_name;
        $response['messages']=$messages;
        $response['last_update']=$last_update;
        $response['status']=200;
        $_SESSION['last_update']=$last_update;
        echo json_encode($response);
    }else{
        echo "{status:400,message:$_POST[last_update]}";
    }
}else{
    echo "{status:400,error:'error'}";
}

?>