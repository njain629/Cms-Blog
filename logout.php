<?php
require_once("include/session.php");
require_once("include/function.php");

  $_SESSION['userid']=null;
  session_destroy();
  redirect('login.php');
 ?>
