<?php 
require_once "classes/Client.php";
session_start();
$client =Client::getClient($_SESSION['client_id']);
$client->getChat()->finalize();

session_destroy();

header("Location: index.php");

?>