<?php
  require_once("include/db.php");
  require_once("include/session.php");
  require_once("include/function.php");
  confirmlogin();
  $con=mysqli_connect('localhost','root','','project');
  if(isset($_POST["submit"]))
  {
    $category=mysqli_real_escape_string($con,$_POST["category"]);
    date_default_timezone_set("Asia/Kolkata");
    $currentime=time();
    $datetime=strftime("%d-%m-%Y %H:%M:%S",$currentime);
    $admin=$_SESSION['username'];
      if(empty($category))
      {
        $_SESSION["errormessage"]="All fields must be filled";
        redirect("categories.php");
  } elseif (strlen($category)>99) {
    $_SESSION["errormessage"]="too long name";
    redirect("categories.php");
    # code...
  }else {
    $query="INSERT INTO category (datetime,name,creatorname) VALUES ('$datetime','$category','$admin')";
    $execute=mysqli_query($con,$query);
    if ($execute) {
      # code...
      $_SESSION['successmessage']="Category added successfully";
      redirect("categories.php");
    }else {
      $_SESSION['errormessage']="Category not added";
      redirect("categories.php");
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
    <title></title>
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
            <li class="active"><a href="categories.php">
              <span class="glyphicon glyphicon-tags"></span>
            	&nbsp;CATEGORIES</a></li>
            <li><a href="admin.php">
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
            	&nbsp;LOGOUT</a>
            </li>
          </ul>
        </div>
        <div class="col-sm-10">
          <h1>Categories</h1>
          <?php echo message();
          echo successmessage();
          ?>
          <div class="">
              <form class="" action="categories.php" method="post">
                <div class="form-group">
                  <label for="categoryname">Name:</label>
                  <input class="form-control" type="text" name="category" id="categoryname" placeholder="Name">
                </div>
                <input class="btn btn-primary "type="Submit" name="submit" value="Add new category">

              </form>
          </div>
          <br>
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <tr>
                <th>Sr no</th>
                <th>Date & time</th>
                <th>Name</th>
                <th>Creator Name</th>
                <th>Action</th>
              </tr>
              <?php
              $vquery="SELECT * FROM category";
              $execute=mysqli_query($con,$vquery);
              $srno=0;
              while ($datarows=mysqli_fetch_array($execute)) {
                $id=$datarows['id'];
                $Datetime=$datarows['datetime'];
                $name=$datarows['name'];
                $creatorname=$datarows['creatorname'];
                $srno++;
              ?>
              <tr>
                <td><?php echo $srno; ?></td>
                <td><?php echo $Datetime; ?></td>
                <td><?php echo $name; ?></td>
                <td><?php echo $creatorname; ?></td>
                <td><a href="deletecategory.php?id=<?php echo $id;?>">
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
