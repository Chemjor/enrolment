<?php
	session_start();
	if(!(isset($_SESSION['username'])) && !(isset($_SESSION['status'])) && !(isset($_SESSION['level'])=='100'))
	{
		header('Location:../index.php');
	}
?>
<?php include('includes/header.php'); ?>
<div style="text-align:center;color:green;margin:5px;padding:5px;background-color:#CCCCFF;border-radius:5px">
WELCOME TO CURRICULUM-BASED ENROLMENT SYSTEM.You are login as<font color="red"> 
<?php echo $_SESSION['username'];?>|<a href="../home.php">
<span class="glyphicon glyphicon-home">Home</span></a>|<a href="manage_subjects.php">
<span class="glyphicon glyphicon-edit">Subjects</span></a>|<a href="../logout.php">
<span class="glyphicon glyphicon-remove">Logout</span></a> </font>
</div> 	

<div id="manage">
			 MANAGE INSTRUCTORS
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input style="text-align:center;color:grey;" type="text" placeholder="Type to Search" id="search" name="search" />
			<span class="glyphicon glyphicon-search " ></span>
</div>

<div id="offered">
<?php
	$msg='';
	if(isset($_GET['done'])){
		if($_GET['done']=='1'){
			$msg= "<div class='alert alert-success'>The Instructor is Activate</div>";
		}
		if($_GET['done']=='2'){
			$msg=  "<div class='alert alert-success'>The Instructor is Deactivate</div>";
		}
		if($_GET['done']=='0'){
			$msg=  "<div class='alert alert-success'>Cannot Update the Table</div>";
		}

	}
?>
<?php
	//get all the level 60 users
	$query=mysql_query("SELECT * FROM teachers");
	$rows=mysql_num_rows($query);
	$i=1;
	if($rows>0)
	{
		echo"<table width='100%' id='table' class='table table-hover'>
		<thead><tr>
		<th></th>
		<th>ID</th>
		<th>Title</th>
		<th>First Name</th>
		<th>Middle Name</th>
		<th>Last Name</th>
		<th>Suffix</th>
		<th>College</th>
		<th>Status</th>
		<th style='text-align:center'>Action</th>
		</tr></thead><tbody>";
		while($data=mysql_fetch_assoc($query))
		{
			$id=$data['teacher_id'];
			$n=$data['title'].",&nbsp;".$data['fname']."&nbsp;".$data['mname']."&nbsp;".$data['lname'];
			$_SESSION['inst']=$n;
			echo"<tr>
			<td>".$i."</td>
			<td>".$data['teacher_id']."</td>
			<td>".$data['title']."</td>
			<td>".$data['fname']."</td>
			<td>".$data['mname']."</td>
			<td>".$data['lname']."</td>
			<td>".$data['suffix']."</td>
			<td>".$data['college']."</td>
			<td>".$data['level']."</td>
			<td style='text-align:center'><a href='instructor_subject.php?id=$id&name=$n' ><span class='glyphicon glyphicon-view' title='View Subjects'>Subjects</span></a>
			|<a href='activate_inst.php?id=$id'><img src='images/deactivate.jpg' title='Activate' width='20' height='20'>Open</a>|
			<a href='deactivate_inst.php?id=$id'><img src='images/update.jpg' title='Deactivate' width='20' height='20'>Block</span></a>
			</td>
			
			</tr>";
			$i++;

		}
		echo "</tbody></table>";
	}?>

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

<?php include('includes/footer.php');?>