<?php
session_start();
session_destroy();//destroys all session variables
header("Location:Login.php");//sends to login page
?>