<?php
session_start();
require_once 'classes/Client.php';
$id=null;

if((isset( $_POST['name']) &&  $_POST['name']!="" ) && (isset($_POST['email']) &&  $_POST['email']!="" )){
    $client= Client::getNewClient($_POST['name'], $_POST['email']);
    $_SESSION['client_id']=$client->id;
    $id=$_SESSION['client_id'];
    $_SESSION['chat_id']=$client->getChat()->id;
}
else if(isset($_SESSION['client_id'])){
    $client=Client::getClient($_SESSION['client_id']);
    $id=$_SESSION['client_id'];
    $chat_id=$_SESSION['chat_id'];
}

if(isset($_POST['message'])&&$_POST['message']!=""){
    
}

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/main.css">
        <script src="js/jquery.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="js/main.js"></script>
        <title>Simple Support Chat</title>
    </head>
    <body>
        <div class="container">
            
            <div class="well" id="main">
                <center><h1>Welcome</h1></center>
                <?php
                if($id==null){
                ?>
                <div class="row">
                <div class="col-md-4 col-md-offset-4">
                <form onsubmit="return validateEnter()" role="form" method="post">
                    <div class="form-group">
                        <label for="name">Full Name </label>
                        <input type="text"  class="form-control" id="name" placeholder="Full Name" name="name" />
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email"  class="form-control" id="email" placeholder="Email" name="email" />
                        <span class="help-block"></span>
                    </div>
                    <input type="submit" value="Enter" class="btn btn-primary" />
                </form>
                </div>
                <?php 
                }
                else{
                ?>
                <a href="logout.php" class="btn btn-danger">Leave Chat</a>
                <br>
                <br>
                <div id="messages" class="well">
                    
                    
                </div>
                <form onsubmit="return validateMessage()" style="text-align: right" role="form" method="post">
                    <div class="form-group">
                        <label class="sr-only" for="message">Message</label>
                        <input autocomplete="off" type="text" class=" form-control " id="message" placeholder="Enter your message">
                    </div>
                    <button type="submit" class="btn btn-primary">Send</button>
                </form>
                <?php
                }
                ?></div>
                
                </div>
            
            
        </div>
    </body>
</html>