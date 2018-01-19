<?php
require_once("include/db.php");
require_once("include/session.php");
require_once("include/function.php");
$con=mysqli_connect('localhost','root','','project');
if (isset($_GET['id'])) {
  $idfromurl=$_GET['id'];
  $query="DELETE FROM category WHERE id='$idfromurl'";
  $execute=mysqli_query($con,$query);
  if ($execute) {
    $_SESSION['successmessage']="Category Deleted Successfully";
      redirect("categories.php");
  }else{
    $_SESSION['errormessage']="Something went wrong. Try again";
    redirect("categories.php");
  }

}


?>
