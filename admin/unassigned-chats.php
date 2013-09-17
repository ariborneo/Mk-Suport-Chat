<?php
require_once 'session_initializer.php';
require_once __DIR__.'/../classes/Chat.php';
if(!isset($_SESSION['user_id']))
    header('Location: login.php ');

$chats= Chat::getUnasignedChats();

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
                <div class="col-md-6 col-md-offset-3">

                    <table class="table table-hover table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Client Name</th>
                            
                            <th>Start Date</th>
                            <th>Take chat</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php 
                                foreach($chats as $chat){
                                    $client_name=Chat::getExistingChat($chat['id'])->getClientName();
                                    echo "<tr>";
                                    echo "<td>$client_name</td>";
                                    echo "<td>$chat[start_date]</td>";
                                    echo "<td><a href='chat.php?id=$chat[id]'>Take</a></td>";
                                    echo "</tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                        
                </div>
               </div>
                
            </div>
            
            
        </div>
        
    </body>
</html>