<?php
  require_once("include/db.php");
  require_once("include/session.php");
  require_once("include/function.php");
  confirmlogin();
  $con=mysqli_connect('localhost','root','','project');
  if(isset($_POST["submit"]))
  {
    $username=mysqli_real_escape_string($con,$_POST["username"]);
    $password=mysqli_real_escape_string($con,$_POST["password"]);
    $confirmpass=mysqli_real_escape_string($con,$_POST["confirmpass"]);
    date_default_timezone_set("Asia/Kolkata");
    $currentime=time();
    $datetime=strftime("%d-%m-%Y %H:%M:%S",$currentime);
    $admin=$_SESSION['username'];
      if(empty($username)||empty($password)||empty($confirmpass))
      {
        $_SESSION["errormessage"]="All fields must be filled";
        redirect("admin.php");
  } elseif (strlen($password)<6) {
    $_SESSION["errormessage"]="Password too short. Enter more than 5 characters";
    redirect("admin.php");
  }elseif ($password!=$confirmpass) {
    $_SESSION["errormessage"]="Password / Confirm Password does not match";
    redirect("admin.php");
  }
  else {
    $query="INSERT INTO registration (datetime,username,addedby,password)
    VALUES ('$datetime','$username','$admin','$password')";
    $execute=mysqli_query($con,$query);
    if ($execute) {
      $_SESSION['successmessage']="Admin added successfully";
      redirect("admin.php");
    }else {
      $_SESSION['errormessage']="Admin not added";
      redirect("admin.php");
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
    <title>Manage Admins</title>
  </head>
  <body>
    <div style="height:10px; background:#27aae1;"></div>
    <nav class="navbar navbar-default" role="navigation">
			<div class="container">
				<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
				data-target="#collapse">
				<span class="sr-only">Toggle Navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
				</div>
				<div class="collapse navbar-collapse" id="collapse">
				<ul class="nav navbar-nav">
					<li><a href="#">Home</a></li>
					<li class="active"><a href="blog.php">Blog</a></li>
					<li><a href="#">About Us</a></li>
					<li><a href="#">Services</a></li>
					<li><a href="#">Contact Us</a></li>
					<li><a href="#">Feature</a></li>
				</ul>
				<form action="blog.php" class="navbar-form navbar-right">
				<div class="form-group">
				<input type="text" class="form-control" placeholder="Search" name="search" >
				</div>
			         <button class="btn btn-default" name="searchbutton">Go</button>
				</form>
				</div>
			</div>
		</nav>
    <div style="height:10px; background:#27aae1; margin-top:-20px;"></div>
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-2">
          <br><br>
          <ul id="sidemenu" class="nav nav-pills nav-stacked">
            <li><a href="dashboard.php">
              <span class="glyphicon glyphicon-th"></span>
            	&nbsp;DASHBOARD</a></li>
            <li><a href="addnewpost.php">
              <span class="glyphicon glyphicon-list-alt"></span>
            	&nbsp;ADD NEW POST</a></li>
            <li ><a href="categories.php">
              <span class="glyphicon glyphicon-tags"></span>
            	&nbsp;CATEGORIES</a></li>
            <li class="active"><a href="admin.php">
              <span class="glyphicon glyphicon-user"></span>
            	&nbsp;MANAGE ADMINS</a></li>
            <li><a href="comments.php">
              <span class="glyphicon glyphicon-comment"></span>
            	&nbsp;COMMENTS</a></li>
            <li><a href="blog.php?page=1">
              <span class="glyphicon glyphicon-equalizer"></span>
            	&nbsp;LIVE BLOGS</a></li>
            <li><a href="logout.php">
              <span class="glyphicon glyphicon-log-out"></span>
            	&nbsp;LOGOUT</a></li>
          </ul>
        </div>
        <div class="col-sm-10">
          <h1>Manage Admin Access</h1>
          <?php echo message();
          echo successmessage();
          ?>
          <div class="">
              <form class="" action="admin.php" method="post">
                <div class="form-group">
                  <label for="username">Username:</label>
                  <input class="form-control" type="text" name="username" id="username" placeholder="Username">
                </div>
                <div class="form-group">
                  <label for="password">Password:</label>
                  <input class="form-control" type="password" name="password" id="password" placeholder="Password">
                </div>
                <div class="form-group">
                  <label for="confirmpass">Username:</label>
                  <input class="form-control" type="password" name="confirmpass" id="confirmpass" placeholder="Retype same password">
                </div>
                <input class="btn btn-primary "type="Submit" name="submit" value="Add new admin">

              </form>
          </div>
          <br>
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <tr>
                <th>Sr no</th>
                <th>Date & time</th>
                <th>Admin Name</th>
                <th>Added By</th>
                <th>Action</th>
              </tr>
              <?php
              $vquery="SELECT * FROM registration";
              $execute=mysqli_query($con,$vquery);
              $srno=0;
              while ($datarows=mysqli_fetch_array($execute)) {
                $id=$datarows['id'];
                $datetime=$datarows['datetime'];
                $name=$datarows['username'];
                $admin=$datarows['addedby'];
                $srno++;
              ?>
              <tr>
                <td><?php echo $srno; ?></td>
                <td><?php echo $datetime; ?></td>
                <td><?php echo $name; ?></td>
                <td><?php echo $admin; ?></td>
                <td><a href="deleteadmin.php?id=<?php echo $id;?>">
                  <span class="btn btn-danger">Delete</span></a></td>
              </tr>
                <?php
                }
                ?>
            </table>
          </div>
        </div>
      </div>
    </div>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  </body>
</html>
