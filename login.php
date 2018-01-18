<?php
  require_once("include/db.php");
  require_once("include/session.php");
  require_once("include/function.php");
  $con=mysqli_connect('localhost','root','','project');

  if(isset($_POST["submit"])){
    $username=mysqli_real_escape_string($con,$_POST["username"]);
    $password=mysqli_real_escape_string($con,$_POST["password"]);
      if(empty($username)||empty($password))
      {
        $_SESSION["errormessage"]="All fields must be filled";
        redirect("login.php");
      }
  else {
    $found_attempt=login_attempt($username,$password);
    $_SESSION['userid']=$found_attempt['id'];
    $_SESSION['username']=$found_attempt['username'];
    if ($found_attempt) {
      $_SESSION["successmessage"]="Welcome {$_SESSION['username']}";
      redirect("dashboard.php");
    }else {
      $_SESSION["errormessage"]="Invalid username/password";
      redirect("login.php");
    }

  }
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="css/adminstyle.css">
    <title>Login Page</title>
    <style media="screen">
      body{
        background-color: #ffffff;
      }
    </style>
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <br><br>
        <div class="col-sm-offset-4 col-sm-4">
          <?php echo message();
          echo successmessage();
          ?>
          <br><br>
          <h1>Login page!</h1>
          <div class="">
              <form class="" action="login.php" method="post">
                <div class="form-group">
                  <label for="username">Username:</label>
                  <div class="input-group input-group-lg">
                      <span class="input-group-addon">
                        <span class="glyphicon glyphicon-envelope text-primary"></span>
                      </span>
                      <input class="form-control" type="text" name="username" id="username" placeholder="Username">
                  </div>
                </div>
                <div class="form-group">
                  <label for="password">Password:</label>
                  <div class="input-group input-group-lg">
                      <span class="input-group-addon">
                        <span class="glyphicon glyphicon-lock text-primary"></span>
                      </span>
                  <input class="form-control" type="password" name="password" id="password" placeholder="Password">
                </div>
              </div>
              <br>
                  <input class="btn btn-info btn-block "type="Submit" name="submit" value="Login">
            </form>
          </div>
          <br>
        </div>
      </div>
    </div>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  </body>
</html>
