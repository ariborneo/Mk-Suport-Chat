<?php
include 'Client.php';
include 'User.php';
$option = 'opcion';
if(isset($argv[1]))
    $option=$argv[1];

try{
switch($option){
    case "add-client":
        $client= Client::getNewClient($argv[2], $argv[3]);
        if($client)echo "Done! id=".$client->id;
        break;
    case "get-client":
        $client= Client::getClient($argv[2]);
        if($client) print_r($client);
        break;
    case "get-client-chat":
        $client= Client::getClient($argv[2]);
        if($client) print_r($client->getChat());
        break;
    case "get-unasigned":
        $chats= Chat::getUnasignedChats();
        if($chats) print_r($chats);
        break;
    case "add-user":
        $user= User::getNewUser($argv[2], $argv[3], $argv[4]);
        if($user)echo "Done! id=".$user->id;
        break;
    case "get-user":
        $user= User::getUser($argv[2]);
        if($user)print_r($user);
        break;
    case "val-user":
        $user= User::validateUser($argv[2],$argv[3]);
        echo $user?"valid":"invalid";
        break;
    case "chat-assign":
        $chat = Chat::getExistingChat($argv[2]) ;
        if($chat->setUser($argv[3]))
            echo $chat->getUser();
        else {
            echo "Error";
        }
        break;
    case "client-msg":
        $user= Client::getClient($argv[2]);
        if($user->sendMessage($argv[3]))
            echo $user->getLastActivity();
        else {
            echo "Error";
        }
        break;
    
    default:
        echo "unexisting function";
        break;
}
}catch(Exception $e){
    echo "Error: ".$e->getMessage();
}
