<?php
require_once("include/db.php");
require_once("include/session.php");
require_once("include/function.php");
$con=mysqli_connect('localhost','root','','project');
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
                elseif (isset($_GET['category'])) {
                  $category=$_GET['category'];
                    $vquery="SELECT * FROM admin_panel WHERE  category='$category' ORDER BY datetime DESC";
                }
                elseif (isset($_GET['page'])) {
                  $page=$_GET['page'];
                  if ($page<=0) {
                    $showpostfrom=0;
                  }
                  else {
                      $showpostfrom=($page*5)-5;
                  }
                  $vquery="SELECT * FROM admin_panel ORDER BY datetime desc LIMIT $showpostfrom,5;";
                }
                else {
                  $vquery="SELECT * FROM admin_panel ORDER BY datetime desc LIMIT 0,5;";
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
                  <?php echo htmlentities($datetime); ?>
                  <?php
                    $queryapp="SELECT COUNT(*) FROM comments WHERE admin_panel_id=$id AND status='ON' ";
                    $executeapp=mysqli_query($con,$queryapp);
                    $rowsapp=mysqli_fetch_array($executeapp);
                    $totalapp=array_shift($rowsapp);
                    if ($totalapp>0){
                  ?>
                  <span class="badge pull-right">
                    Comments:<?php echo $totalapp;?>
                  </span>
                  <?php
                    }
                    ?>
                    </p>
                  <p class="post">
                    <?php
                    if (strlen($post)>150) {
                      $post=substr($post,0,150)."...";
                    }
                    echo $post;
                    ?></p>
                </div>
              <a href="fullpost.php?id= <?php echo $id; ?>">
                <span class="btn btn-info ">
                  Read More &rsaquo;&rsaquo;
                </span>
              </a>
            </div>
          <?php }?>
            <nav>
              <ul class="pagination pull-left pagination-lg">
                <?php
                if (isset($page)) {
                  if ($page>1) { ?>
                      <li><a href="blog.php?page=<?php echo $page-1;?>">&laquo;</a></li>
                <?php
                    }
                  }
                  $querypage="SELECT COUNT(*) FROM admin_panel";
                  $executepage=mysqli_query($con,$querypage);
                  $rowpage=mysqli_fetch_array($executepage);
                  $totalpost=array_shift($rowpage);
                  $postperpage=ceil($totalpost/5);
                  for ($i=1; $i<=$postperpage ; $i++) {
                    if (isset($page)) {
                      if($i==$page){
                  ?>
                <li class="active"><a href="blog.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
              <?php
                }
              else { ?>
              <li><a href="blog.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                <?php }
                  }
                }
                if (isset($page)) {
                  if ($page+1<=$postperpage ) { ?>
                      <li><a href="blog.php?page=<?php echo $page+1;?>">&raquo;</a></li>
                    <?php }
                  } ?>
              </ul>
            </nav>
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
            </div>
          </div>
      </div>
    </div>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  </body>
</html>
