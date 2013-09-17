<?php
require_once '../session_initializer.php';
require_once '../../classes/User.php';

if(isset($_SESSION['user_id'])){

if(isset($_POST['message'])&&$_POST['message']!=""){
    $user= User::getUser($_SESSION['user_id']);
    $user->sendMessage($_POST['message'], $_POST['id']);
    echo "{status :200}";
}else{
    echo "{status :400}";
}

}else{
     echo "{status :400}";
}
