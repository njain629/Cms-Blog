<?php

session_start();
function message(){
  if (isset($_SESSION['errormessage'])) {
    # code...
    $output="<div class=\"alert alert-danger\">";
    $output.=htmlentities($_SESSION['errormessage']);
    $output.="</div>";
    $_SESSION['errormessage']=null;
    return $output;
  }
}
function successmessage(){
  if (isset($_SESSION['successmessage'])) {
    # code...
    $output="<div class=\"alert alert-success\">";
    $output.=htmlentities($_SESSION['successmessage']);
    $output.="</div>";
    $_SESSION['successmessage']=null;
    return $output;
  }
}
 ?>
