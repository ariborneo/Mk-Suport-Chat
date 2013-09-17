<?php

require_once 'classes/MkSession.php';
$session_class = new MkSession;

 ini_set('session.gc_maxlifetime',1);  
 $session_class->gc(ini_get('session.gc_maxlifetime'));