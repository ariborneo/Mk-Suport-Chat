<?php 
require_once "../classes/Client.php";
require_once "../classes/Message.php";
require_once "../classes/Chat.php";
session_start();
if(isset($_SESSION['client_id'])){
    if(isset($_POST['last_update'])){
        $last_update=isset($_SESSION['last_update'])?$_SESSION['last_update']:$_SESSION['client_id'];
        $response = array();
        $client= Client::getClient($_SESSION['client_id']);
        $chat= $client->getChat();
        $messages=Message::getLatestMessages($last_update, $chat->id);
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
    echo "{status:400}";
}

?>