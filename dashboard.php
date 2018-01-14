<?php
require_once("include/db.php");
require_once("include/session.php");
require_once("include/function.php");
confirmlogin();
$con=mysqli_connect('localhost','root','','project');
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <script src="js/jquery-3.2.1.min.js"></script>
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
            <li class="active"><a href="dashboard.php">
              <span class="glyphicon glyphicon-th"></span>
            	&nbsp;DASHBOARD</a></li>
            <li><a href="addnewpost.php">
              <span class="glyphicon glyphicon-list-alt"></span>
            	&nbsp;ADD NEW POST</a></li>
            <li><a href="categories.php">
              <span class="glyphicon glyphicon-tags"></span>
            	&nbsp;CATEGORIES</a></li>
            <li><a href="admin.php">
              <span class="glyphicon glyphicon-user"></span>
            	&nbsp;MANAGE ADMINS</a></li>
            <li><a href="comments.php">
              <span class="glyphicon glyphicon-comment"></span>
            	&nbsp;COMMENTS
              <?php
                $queryt="SELECT COUNT(*) FROM comments WHERE status='OFF' ";
                $executet=mysqli_query($con,$queryt);
                $rowst=mysqli_fetch_array($executet);
                $total=array_shift($rowst);
                if ($total>0) {
              ?>
              <span class="label pull-right label-warning">
                <?php echo $total;?>
              </span>
              <?php
                }
               ?>
            </a></li>
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
          <h1>Admin Dashboard</h1>
          <div class="">
            <?php
            echo message();
            echo successmessage(); ?>
          </div>
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <tr>
                <th>No</th>
                <th>Post Title</th>
                <th>Date & Time</th>
                <th>Author</th>
                <th>Category</th>
                <th>Banner</th>
                <th>Comments</th>
                <th>Action</th>
                <th>Details</th>
              </tr>
              <?php
                $vquery="SELECT * FROM admin_panel ORDER BY datetime DESC";
                $execute=mysqli_query($con,$vquery);
                $srno=0;
                while ($datarows=mysqli_fetch_array($execute)) {
                  $id=$datarows['id'];
                  $datetime=$datarows['datetime'];
                  $title=$datarows['title'];
                  $category=$datarows['category'];
                  $admin=$datarows['author'];
                  $image=$datarows['image'];
                  $post=$datarows['post'];
                  $srno++;
                ?>
                <tr>
                  <td><?php echo $srno; ?></td>
                	<td style="color: #5e5eff;"><?php
                	if(strlen($title)>19){$title=substr($title,0,19).'..';}
                	echo $title;
                	?></td>
                	<td><?php
                	echo $datetime;
                	?></td>
                	<td><?php
                	if(strlen($admin)>10){$admin=substr($admin,0,10);}
                	echo $admin; ?></td>
                	<td><?php
                	if(strlen($category)>10){$category=substr($category,0,10);}
                	echo $category;
                	?></td>
                  <td><img src="upload/" <?php echo $image; ?> alt="image"></td>
                  <td>
                      <?php
                        $queryapp="SELECT COUNT(*) FROM comments WHERE admin_panel_id=$id AND status='ON' ";
                        $executeapp=mysqli_query($con,$queryapp);
                        $rowsapp=mysqli_fetch_array($executeapp);
                        $totalapp=array_shift($rowsapp);
                        if ($totalapp>0){
                      ?>
                      <span class="label pull-right label-success">
                        <?php echo $totalapp;?>
                      </span>
                      <?php
                        }
                       ?>
                       <?php
                         $queryunapp="SELECT COUNT(*) FROM comments WHERE admin_panel_id=$id AND status='OFF' ";
                         $executeunapp=mysqli_query($con,$queryunapp);
                         $rowsunapp=mysqli_fetch_array($executeunapp);
                         $totalunapp=array_shift($rowsunapp);
                         if ($totalunapp>0) {
                       ?>
                       <span class="label label-danger">
                         <?php echo $totalunapp;?>
                       </span>
                       <?php
                         }
                        ?>
                  </td>
                  <td>
                    <a href="editpost.php?Edit=<?php echo $id; ?>">
                	     <span class="btn btn-warning">Edit</span>
                	   </a>
                  	<a href="deletepost.php?Delete=<?php echo $id; ?>">
                  	   <span class="btn btn-danger">Delete</span>
                  	</a>
                  </td>
                  <td>
                  <a href="fullpost.php?id=<?php echo $id; ?>" target="_blank">
                	   <span class="btn btn-primary"> Live Preview</span>
                	</a>
                </td>
                </tr>
              <?php } ?>
            </table>
          </div>
        </div>
      </div>
    </div>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  </body>
</html>
