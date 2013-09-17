<?php
session_start();
require_once '../classes/Client.php';

if(isset($_SESSION['client_id'])){

if(isset($_POST['message'])&&$_POST['message']!=""){
    $client = Client::getClient($_SESSION['client_id']);
    $client->sendMessage($_POST['message']);
    echo "{status :200}";
}else{
    echo "{status :400}";
}

}else{
     echo "{status :400}";
}
