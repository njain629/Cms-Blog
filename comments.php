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
            <li ><a href="dashboard.php">
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
            <li class="active"><a href="comments.php">
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
            	&nbsp;LOGOUT</a></li>
          </ul>
        </div>
        <div class="col-sm-10">
          <h1>Manage Comments</h1>
          <div><?php echo Message();
        	      echo SuccessMessage();
        	?></div>
          <h1>Un-Approved Comments</h1>
        	<div class="table-responsive">
        		<table class="table table-striped table-hover">
        	<tr>
        	<th>No.</th>
        	<th>Name</th>
        	<th>Date</th>
        	<th>Comment</th>
        	<th>Approve</th>
        	<th>Delete Comment</th>
        	<th>Details</th>
        	</tr>
        <?php
        $query="SELECT * FROM comments WHERE status='OFF' ORDER BY id desc";
        $execute=mysqli_query($con,$query);
        $srno=0;
        while($datarows=mysqli_fetch_array($execute)){
        	$commentid=$datarows['id'];
        	$datetime=$datarows['datetime'];
        	$pname=$datarows['name'];
        	$pcomment=$datarows['comment'];
        	$commentedpostid=$datarows['admin_panel_id'];
        	$srno++;
        if(strlen($pname) >10) { $pname = substr($pname, 0, 10).'..';}

        ?>
        <tr>
        	<td><?php echo htmlentities($srno); ?></td>
        	<td style="color: #5e5eff;"><?php echo htmlentities($pname); ?></td>
        	<td><?php echo htmlentities($datetime); ?></td>
        	<td><?php echo htmlentities($pcomment); ?></td>
        	<td><a href="approvecomments.php?id=<?php echo $commentid; ?>">
        	<span class="btn btn-success">Approve</span></a></td>
        	<td><a href="deletecomments.php?id=<?php echo $commentid;?>">
        	<span class="btn btn-danger">Delete</span></a></td>
        	<td><a href="fullpost.php?id=<?php echo $commentedpostid; ?>" target="_blank">
        	<span class="btn btn-primary">Live Preview</span></a></td>
        </tr>
        <?php } ?>
        		</table>
        	</div>
        	    <h1>Approved Comments</h1>
        	<div class="table-responsive">
        		<table class="table table-striped table-hover">
        	<tr>
        	<th>No.</th>
        	<th>Name</th>
        	<th>Date & Time</th>
        	<th>Comment</th>
        	<th>Approved By</th>
        	<th>Revert Approval </th>
        	<th>Delete Comment</th>
        	<th>Details</th>
        	</tr>
        <?php
        $query="SELECT * FROM comments WHERE status='ON' ORDER BY id desc";
        $execute=mysqli_query($con,$query);
        $srno=0;
        while($dataRows=mysqli_fetch_array($execute)){
        	$commentid=$dataRows['id'];
        	$datetime=$dataRows['datetime'];
        	$pname=$dataRows['name'];
        	$pcomment=$dataRows['comment'];
        	$approvedby=$dataRows['approvedby'];
        	$commentedpostid=$dataRows['admin_panel_id'];
        	$srno++;
        if(strlen($pname) >10) { $pname = substr($pname, 0, 10).'..';}
        if(strlen($datetime)>18){$datetime=substr($datetime,0,18);}

        ?>
        <tr>
        	<td><?php echo htmlentities($srno); ?></td>
        	<td style="color: #5e5eff;"><?php echo htmlentities($pname); ?></td>
        	<td><?php echo htmlentities($datetime); ?></td>
        	<td><?php echo htmlentities($pcomment); ?></td>
        	<td><?php echo htmlentities($approvedby); ?></td>
        	<td><a href="disapprovecomments.php?id=<?php echo $commentid;?>">
        	<span class="btn btn-warning">Dis-Approve</span></a></td>
        	<td><a href="deletecomments.php?id=<?php echo $commentid;?>">
        	<span class="btn btn-danger">Delete</span></a></td>
        	<td><a href="fullpost.php?id=<?php echo $commentedpostid; ?>"target="_blank">
        	<span class="btn btn-primary">Live Preview</span></a></td>
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
