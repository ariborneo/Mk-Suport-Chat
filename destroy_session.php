<?php

require_once 'classes/MkSession.php';
$session_class = new MkSession;
session_set_save_handler(array(&$session_class, 'open'),
                         array(&$session_class, 'close'),
                         array(&$session_class, 'read'),
                         array(&$session_class, 'write'),
                         array(&$session_class, 'destroy'),
                         array(&$session_class, 'gc'));
                         
 ini_set('session.gc_maxlifetime',600);                        
 session_start();
echo  $_SESSION['user_id'];
session_destroy();