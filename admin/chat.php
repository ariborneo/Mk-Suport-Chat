<?php 
require_once 'session_initializer.php';
require_once __DIR__.'/../classes/Chat.php';
require_once __DIR__.'/../classes/User.php';
if(!isset($_SESSION['user_id']))
    header('Location: login.php ');

if(!isset($_GET['id']))
    header('Location: index.php ');

$user=User::getUser($_SESSION['user_id']);
if(!$user->hasChat($_GET['id'])){
    $chat=Chat::getExistingChat($_GET['id']);
    $chat->setUser($_SESSION['user_id']);
}


$_SESSION['last_update']="0000-00-00 00:00:00";
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
        <title>Simple Support Chat</title>
        
    </head>
    <body>
        <div class="container">
            
            <div class="well" id="main">
                <center><h1>Welcome</h1></center>
                
                <a href="end.php?id=<?php echo $_GET['id'] ?>" class="btn btn-danger">End Chat</a>
                <a href="index.php" class="btn btn-primary">Go Home</a>
                <br>
                <br>
                <div id="messages" class="well ">
                    <div id="last"></div>
                    
                </div>
                <form onsubmit="sendUserMessage(<?php echo $_GET['id'] ?>); return false" style="text-align: right" role="form" method="post">
                    <div class="form-group">
                        <label class="sr-only" for="message">Message</label>
                        <input autocomplete="off" type="text" class=" form-control " id="message" placeholder="Enter your message">
                    </div>
                    <button type="submit" class="btn btn-primary">Send</button>
                </form>
                </div>
                
                </div>
            
            
        </div>
        <br />
        <?php if(isset($_SESSION['user_id'])){?>
        <script type="text/javascript">
            $(function(){
                window.setInterval(function(){ getMessagesUser('<?php echo $_SESSION['last_update'] ?>',<?php echo $_GET['id'] ?>) },1000);
            });
        </script>
        <?php } ?>
    </body>
</html>