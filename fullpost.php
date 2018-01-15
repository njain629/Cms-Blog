<?php
require_once("include/db.php");
require_once("include/session.php");
require_once("include/function.php");
$con=mysqli_connect('localhost','root','','project');
if(isset($_POST["submit"]))
{
  $name=mysqli_real_escape_string($con,$_POST["name"]);
  $email=mysqli_real_escape_string($con,$_POST["email"]);
  $comment=mysqli_real_escape_string($con,$_POST["comment"]);
  date_default_timezone_set("Asia/Kolkata");
  $currentime=time();
  $datetime=strftime("%d-%m-%Y %H:%M:%S",$currentime);
  $postidfromurl=$_GET['id'];
    if(empty($name)||empty($email)||empty($comment))
    {
      $_SESSION["errormessage"]="All fields are required";
    } elseif (strlen($comment)>500) {
      $_SESSION["errormessage"]="only 500 characters are allowed in comments";
    } else {
        $query="INSERT INTO comments (datetime,name,email,comment,approvedby,status,admin_panel_id)
        VALUES ('$datetime','$name','$email','$comment','Pending','OFF','$postidfromurl')";
        $execute=mysqli_query($con,$query);
        if ($execute) {
          $_SESSION['successmessage']="Comment added successfully";
          redirect("fullpost.php?id={$postidfromurl}");
        }else {
          $_SESSION['errormessage']="Comment not added.Please try again";
          redirect("fullpost.php?id={$postidfromurl}");
        }
      }
}
 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="js/jquery-3.2.1.min.js"></script>
    <link rel="stylesheet" href="css/publicstyle.css">
    <title>Blog page</title>
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
    <div class="container">
      <div class="blog-header">
        <h1>The Complete Responsive CMS Blog </h1>
        <?php
        echo message();
        echo successmessage(); ?>
      </div>
      <div class="row">
          <div class="col-sm-8">
              <?php
                if (isset($_GET['searchbutton'])) {
                  $search=$_GET['search'];
                  $vquery="SELECT * FROM admin_panel WHERE datetime LIKE '%$search%'
                  OR title LIKE '%$search%' OR category LIKE '%$search%'
                  OR post LIKE '%$search%'";
                }
                else {
                  $postidfromurl=$_GET['id'];
                  $vquery="SELECT * FROM admin_panel WHERE id='$postidfromurl' ORDER BY datetime desc";
                }
                  $execute=mysqli_query($con,$vquery);
                  while ($datarows=mysqli_fetch_array($execute)) {
                    $id=$datarows['id'];
                    $datetime=$datarows['datetime'];
                    $title=$datarows['title'];
                    $category=$datarows['category'];
                    $admin=$datarows['author'];
                    $image=$datarows['image'];
                    $post=$datarows['post'];
              ?>
              <div class="blogpost thumbnail">
                <img  class=" img-responsive img-rounded" src="upload/ <?php echo $image; ?>" alt="image">
                <div class="caption">
                  <h1 id="heading"><?php echo htmlentities($title); ?></h1>
                  <p class="description"> Category: <?php echo htmlentities($category); ?> Published On:
                  <?php echo htmlentities($datetime); ?></p>
                  <p class="post">
                    <?php
                    echo nl2br($post);
                    ?></p>
                </div>
            </div>
          <?php } ?>
            <br><br><br>
            <span class="fieldinfo">Comments</span>
            <?php
            $extractcomment="SELECT * FROM comments
            WHERE admin_panel_id='$postidfromurl' AND status='ON'";
            $execute=mysqli_query($con,$extractcomment);
            while($datarows=mysqli_fetch_array($execute)){
            	$commentdate=$datarows["datetime"];
            	$commentername=$datarows["name"];
            	$comments=$datarows["comment"];
            ?>

            <div class="commentblock">
            	<img style="margin-left: 10px; margin-top: 10px;" class="pull-left" src="images/comment.png" width=70px; height=70px;>
            	<p style="margin-left: 90px;" class="commentinfo"><?php echo $commentername; ?></p>
            	<p style="margin-left: 90px;"class="description"><?php echo $commentdate; ?></p>
            	<p style="margin-left: 90px;" class="comment"><?php echo nl2br($comments); ?></p>

            </div>
            	<hr>
                <?php } ?>
              <br><br>
            <span class="fieldinfo">Share your thoughts for the post</span>
            <br><br>
            <div class="">
                <form class="" action="fullpost.php?id=<?php  echo $postidfromurl; ?>" method="post" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="name">Name:</label>
                    <input class="form-control" type="text" name="name" id="name" placeholder="Name">
                  </div>
                  <div class="form-group">
                    <label for="email">Email:</label>
                    <input class="form-control" type="email" name="email" id="email" placeholder="Email">
                  </div>
                  <div class="form-group">
                    <label for="commentarea">Comment:</label>
                    <textarea class="form-control" name="comment" id="commentarea"></textarea>
                  </div>
                  <br>
                  <input class="btn btn-primary "type="Submit" name="submit" value="Submit">
                </form>
            </div>
          </div>
          <div class="col-sm-offset-1 col-sm-3">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h2 class="panel-header">Categories</h2>
              </div>
              <div class="panel-body">
              <?php
                $query="SELECT * FROM category ORDER BY datetime DESC";
                $exec=mysqli_query($con,$query);
                while ($datarows=mysqli_fetch_array($exec)) {
                  $id=$datarows['id'];
                  $category=$datarows['name'];
               ?>
               <a href="blog.php?category=<?php echo $category;?>">
                 <span id="heading"><?php echo $category.'<br>'; ?></span>
               </a>
             <?php } ?>
              </div>
              <div class="panel-footer">

              </div>
            </div>
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h2 class="panel-header">Recent Post</h2>
              </div>
              <div class="panel-body background">
                <?php
                $vquery="SELECT * FROM admin_panel ORDER BY datetime DESC LIMIT 0,3";
                $exec=mysqli_query($con,$vquery);
                while ($datarows=mysqli_fetch_array($exec)) {
                  $id=$datarows['id'];
                  $datetime=$datarows['datetime'];
                  $title=$datarows['title'];
                  $image=$datarows['image'];
                  $post=$datarows['post'];
                  if (strlen($datetime)>11) {
                    $datetime=substr($datetime,0,11);
                  }
                 ?>
                 <div class="">
                   <img  class="pull-left" style="margin-top:10px; margin-left:10px" src="upload/"<?php echo $image ?> alt="image">
                   <a href="fullpost.php?id=<?php echo $id;?>">
                      <p id="heading" style="margin-left:90px"><?php echo htmlentities($title); ?></p>
                   </a>
                   <p  class="description" style="margin-left:90px"><?php echo htmlentities($datetime) ?></p>
                 </div>
               <?php } ?>
              </div>
              <div class="panel-footer">

              </div>
            </d
          </div>
      </div>
    </div>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  </body>
</html>
