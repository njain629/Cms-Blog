<?php
require_once("include/db.php");
require_once("include/session.php");
require_once("include/function.php");
$con=mysqli_connect('localhost','root','','project');
if (isset($_GET['id'])) {
  $idfromurl=$_GET['id'];
  $query="UPDATE comments SET status='OFF' WHERE id='$idfromurl'";
  $execute=mysqli_query($con,$query);
  if ($execute) {
    $_SESSION['successmessage']="Comment Disapproved Successfully";
      redirect("comments.php");
  }else{
    $_SESSION['errormessage']="Something went wrong. Try again";
    redirect("comments.php");
  }

}


?>
