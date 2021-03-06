<?php
  require_once("include/db.php");
  require_once("include/session.php");
  require_once("include/function.php");
  confirmlogin();
  $con=mysqli_connect('localhost','root','','project');
  if(isset($_POST["submit"]))
  {
    $category=mysqli_real_escape_string($con,$_POST["category"]);
    $title=mysqli_real_escape_string($con,$_POST["title"]);
    $post=mysqli_real_escape_string($con,$_POST["post"]);
    date_default_timezone_set("Asia/Kolkata");
    $currentime=time();
    $datetime=strftime("%d-%m-%Y %H:%M:%S",$currentime);
    $admin=$_SESSION['username'];
    $image=$_FILES['image']['name'];
    $target="/opt/lampp/htdocs/php/project/upload".$_FILES['image']["name"];
      if(empty($title))
      {
        $_SESSION["errormessage"]="Title can't be empty";
        redirect("addnewpost.php");
      } elseif (strlen($title)<2) {
        $_SESSION["errormessage"]="Title can't be less than 2 characters";
        redirect("addnewpost.php");
      } else {
          $query="INSERT INTO admin_panel (datetime,title,category,author,image,post)
          VALUES ('$datetime','$title','$category','$admin','$image','$post')";
          $execute=mysqli_query($con,$query);
          move_uploaded_file($_FILES['image']["tmp_name"],$target);
          if ($execute) {
            $_SESSION['successmessage']="Post added successfully";
            redirect("addnewpost.php");
          }else {
            $_SESSION['errormessage']="Post not added";
            redirect("addnewpost.php");
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
            <li class="active"><a href="addnewpost.php">
              <span class="glyphicon glyphicon-list-alt"></span>
            	&nbsp;ADD NEW POST</a></li>
            <li ><a href="categories.php">
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
          <h1>Add New Post</h1>
          <?php echo message();
          echo successmessage();
          ?>
          <div class="">
              <form class="" action="addnewpost.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="title">Title:</label>
                  <input class="form-control" type="text" name="title" id="title" placeholder="Title">
                </div>
                <div class="form-group">
                  <label for="categoryname">Category:</label>
                </div>
                <select class="form-control" name="category" id="categoryname">
                  <?php
                    $vquery="SELECT * FROM category";
                    $execute=mysqli_query($con,$vquery);
                    while ($datarows=mysqli_fetch_array($execute)) {
                        $id=$datarows['id'];
                        $name=$datarows['name'];
                        ?>
                        <option ><?php echo $name; ?></option>
                        <?php
                      }
                    ?>
                </select>
                <br>
                <div class="form-group">
                  <label for="imageselect">Select Image:</label>
                  <input class="form-control" type="file" name="Image" id="imageselect">
                </div>
                <div class="form-group">
                  <label for="postarea">Post:</label>
                  <textarea class="form-control" name="post" id="postarea"></textarea>
                </div>
                <br>
                <input class="btn btn-primary "type="Submit" name="submit" value="Add new post">
              </form>
          </div>
          <br>
        </div>
      </div>
    </div>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  </body>
</html>
