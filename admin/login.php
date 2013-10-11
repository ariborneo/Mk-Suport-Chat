<?php 
require_once 'session_initializer.php';
require_once __DIR__.'/../classes/User.php';

if(isset($_POST['username'])){
    if($id=User::validateUser($_POST['username'], $_POST['password'])){
        $_SESSION['user_id']=$id;
        header('Location: index.php');
    }else{
        $message="Invalid credentials";
    }
}

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
                <form  role="form" method="post">
                    <?php if(isset($message)) echo "<div class='alert alert-danger'>$message</div>" ?>
                    <div class="form-group">
                        <label for="name">Username </label>
                        <input type="text"  class="form-control" id="username" placeholder="Full Name" name="username" />
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <label for="email">Password</label>
                        <input type="password"  class="form-control" id="password" placeholder="Email" name="password" />
                        <span class="help-block">Try: admin/1234</span>
                    </div>
                    <input type="submit" value="Enter" class="btn btn-primary" />
                </form>
                </div>
               </div>
                
            </div>
            
            
        </div>
        
    </body>
</html>
