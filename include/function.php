<?php
//require_once("db.php");
require_once("include/session.php");
function  redirect ($newlocation){
  header("Location:".$newlocation);
  exit;
}
function login_attempt($username,$password){
  $con=mysqli_connect('localhost','root','','project');
  $query="SELECT * FROM registration WHERE username='$username' AND password='$password'";
  $execute=mysqli_query($con,$query);
  if ($admin=mysqli_fetch_assoc($execute)) {
      return $admin;
  }else {
    return null;
  }
}

function login(){
  if (isset($_SESSION['userid'])) {
      return true;
  }
}

function confirmlogin(){
  if(!login()){
    $_SESSION['errormessage']="Login required";
    redirect('login.php');
  }
}

?>
