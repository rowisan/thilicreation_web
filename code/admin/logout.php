<?php
   session_start();
   include("config.php");
   
   if(session_destroy()) {
      header("location:".$path."/login");
   }
?>