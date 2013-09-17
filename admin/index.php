<?php 
require_once 'session_initializer.php';
if(!isset($_SESSION['user_id']))
    header('Location: login.php ');
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/main.css">
        <script src="../js/jquery.min.js"></script>
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <script src="../js/main.js"></script>
        <title>Simple Support Chat Back End</title>
        
    </head>
    <body>
         <div class="container">
            
            <div class="well" id="main">
                <center><h1>Welcome</h1></center>
                <div class="row">
                <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-heading">Actions</div>
                    <div class="panel-body">
                        <a href="unassigned-chats.php">View Unassigned chats</a>
                        <br>
                        <br>
                        <a href="my_chats.php">View my assigned chats</a>
                    </div>
                </div>
                </div>
               </div>
                
            </div>
            
            
        </div>
        
    </body>
</html>