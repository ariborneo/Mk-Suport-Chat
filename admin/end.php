<?php 
require_once 'session_initializer.php';
require_once __DIR__.'/../classes/Chat.php';
if(!isset($_SESSION['user_id']))
    header('Location: login.php ');
if(!isset($_GET['id']))
    header('Location: index.php ');

   $chat=Chat::getExistingChat($_GET['id']);
   $chat->finalize();
   
   
   header('Location: index.php ');