<?php
//http://www.9lessons.info/2011/03/live-table-edit-with-jquery-and-ajax.html
	session_start();
	if(!(isset($_SESSION['username'])) && !(isset($_SESSION['level'])==100) && !(isset($_SESSION['status'])))
	{
		header('Location:../index.php?logout=0');
	}
?>
<?php include('includes/header.php');?>
<div style="text-align:center;color:green;margin:5px;padding:5px;background-color:#CCCCFF;border-radius:5px">
WELCOME TO CURRICULUM-BASED ENROLMENT SYSTEM.You are login as<font color="red"> 
<?php echo $_SESSION['username'];?>|<a href="../home.php">
<span class="glyphicon glyphicon-home">Home</span></a>|<a href="manage_subjects.php">
<span class="glyphicons glyphicon-flash">Subjects</span></a>|<a href="instructors.php">
<span class="glyphicons glyphicon-flash">Instructors</span></a>|<a href="../logout.php">
<span class="glyphicon glyphicon-flash">Logout</span></a> </font>
</div>
<div id="content">
<div id="manage">
			 MANAGE USERS
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input style="text-align:center;color:grey;" type="text" placeholder="Type to Search" id="search" name="search" />
			<span class="glyphicon glyphicon-search " ></span>
</div>
	<div class="navbar navbar-default">

	<!--User Accounts-->
	<div id="offered">
	<?php
		if(isset($_GET['del']))
		{
			$error="";
			if($_GET['del']=='1')
			{
			$error="<div class='alert-green'>The User Is Deleted</div>";
			}
			if($_GET['del']=='0')
			{
			$error="<div class='alert-green'>Can't Delete the user Record</div>";
			}
		}
	?>
	<?php
	include("includes/conf.php");
	
	$sql="select * from users";
	$query=mysql_query($sql);
	$i=1;
	if($query)
	{
	echo"<table id='table' class='table table-hover'>
	<thead>
	<th></th>
	<th>First Name</th>
	<th>Last Name</th>
	<th>Username</th>
	<th>Date Registered</th>
	<th>Status</th>
	<th>Action</th></thead>
	<tbody>";
	
	while($data=mysql_fetch_assoc($query))
	{
		$id=$data['user_id'];
		echo "<tr>
		<td>".$i."</td>
		<td>".$data['fname']."</td>
		<td>".$data['lname']."</td>
		<td>".$data['username']."</td>
		<td>".$data['date']."</td>
		<td>".$data['status']."</td>
		<td><a href='update.php?id=$id'><img src='images/update.jpg' title='Activate' width='20' height='20'></a>|
		<a href='deactivate.php?id=$id'><img src='images/deactivate.jpg' title='Deactivate' width='20' height='20'></a>|
		<a href='del_user.php?id=$id'><span class='glyphicon glyphicon-trash' title='Remove'></span></a></td></tr>";
		$i++;
	}
	echo"</tbody></table>";
	}
	else echo"cannot query ";
	?>
		<script type="text/javascript">
			
				var $rows = $('#table tbody tr');
				$('#search').keyup(function () {
				    var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

				    $rows.show().filter(function () {
				        var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
				        return !~text.indexOf(val);
				    }).hide();
				});

		</script>
	</div>	
</div>

<?php include('includes/footer.php')?>