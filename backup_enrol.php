<?php
	session_start();
	$_SESSION['studno']=$stud;
	if(!(isset($_SESSION['username'])) && !(isset($_SESSION['status'])))
	{
		header('Location:index.php');
	}
?>
<?php include('includes/header.php');?>

<div style="text-align:center;color:green;margin:5px;padding:5px;background-color:#CCCCFF;border-radius:5px">WELCOME TO CURRICULUM-BASED ENROLMENT SYSTEM. You are login as<font color="red"> <?php echo $_SESSION['username'];?> </font>| <span class="glyphicons glyphicon-star"><a href="logout.php">Logout</a>&nbsp;|&nbsp;<a href="home.php"><span class="glyphicon glyphicon-home">Home</span></a></div>
<div id="enrolment">
<div id="stud_enrol">
<h5 style="margin-top:15px;color:green;font-weight:bold">STUDENT PAYMENT</h5>
<hr style="border:1px solid grey">
<?php
include("includes/conf.php");
$cors=$_GET['code'];
$stud=$_GET['id'];
$query=mysql_query("select * from payment where studno='$stud'");
	if($numrows=mysql_num_rows($query)>0)
	{

	}
	else
	{
	echo "<div class='alert-danger'>Not Yet Paid.</div>";
	}
?>
<?php
	if(isset($_GET['done']))
	{
		if($_GET['done']=='1')
		{
		echo "<div class='alert-success'>New Record is saved..</div>";
		}
		if($_GET['done']=='0')
		{
		//echo "<div class='alert-warning'>You Billing Information is complete.Enrol!</div>";
		}
		if($_GET['done']=='3')
		{
		echo "<div class='alert-success'>The Record is Saved</div>";
		}
	}
?>
<form method="post" action="_completeStudent.php">

<?php
include("includes/conf.php");
$id=$_GET['id'];
$query=mysql_query("select * from stud_information where studno='$id'");
$numrows=mysql_num_rows($query);
echo "<table width='100%'>";
if($numrows==1)
{

	while($data=mysql_fetch_assoc($query))
	{
	//$course=$data['course'];
	$id=$data['studno'];
	$f=$data['fname'];
	$m=$data['mname'];
	$l=$data['lname'];
	echo"<tr><td>Student No.</td> <td>".$data['studno']."</td></tr>";
	echo"<tr><td>Student Name:</td> <td>".$data['lname'].",".$data['fname']." ".$data['mname']."</td></tr>";
	echo "<tr><input type='hidden' name='studno' value='$id'/></tr>";
	
	}
	
}
$query=mysql_query("select * from payment where studno='$id'");
$check=mysql_fetch_assoc($query);
$ors=$check['tut_orno'];
$paydate=$check['tut_ordate'];
$amount=$check['tut_amount'];
$misor=$check['mis_orno'];
$misamount=$check['mis_amount'];
$misdate=$check['mis_date'];
$course=$check['coursecode'];
$yr=$check['yrlevel'];
$school=$check['schoolyear'];
$sem=$check['semester'];
$gra=$check['graduating'];
?>
	<tr><td>Tution OR Number:</td><td><input required="" type="text" name="orno"value="<?php echo $ors;?>"/></td></tr>
	<tr><td>Payment Date:</td><td><input required="" type="text" name="tut_date" value="<?php echo $paydate;?>"/></td></tr>
	<tr><td>Amount:</td><td><input required="" type="text" name="tut_amount" value="<?php echo $amount;?>"/></td><tr/>
	<tr><td>Miscellanious OR Number:</td><td><input type="text" name="misor" value="<?php echo $misor?>"/></td></tr>
	<tr><td>Payment Date:</td><td><input required="" type="text" name="misdate" value="<?php echo $misdate;?>"/></td></tr>
	<tr><td>Amount:</td><td><input required="" type="text" name="mis_amount" value="<?php echo $misamount;?>"/></td></tr>
	<tr><td>Course:</td><td><input required="" type="text"  name="course" value="<?php echo $course; ?>"/></td></tr>
	<tr><td>Major:</td><td><input type="text" name="major"/></td></tr>
	<tr><td>Minor:</td><td><input type="text" name="minor"/></td></tr>
	<?php
	include("includes/conf.php");
	$code=$_GET['code'];

	?>
	</td><td><input  type="hidden" value="<?php echo $code;?>"name="code"/>
	<tr><td>Year Level:</td><td><input type="text" name="yrlevel" value="<?php echo $yr;?>"/></td></tr>
	<tr><td>School Year:</td><td><input type="text" name="schoolyear" value="<?php echo $school;?>"/></td></tr>
	<tr><td>Semester:</td><td><input type="text" name="yrlevel" value="<?php echo $sem;?>"/></td></tr>

	<tr><td>Graduating:</td><td><input type="text" name="graduate" value="<?php echo $gra;?>"></td><tr/>
	<tr><td>Scholastic:</td>
	<td>
	<select name="scholar">
	<?php
	include("includes/conf.php");
		$query=mysql_query("select * from scholarships");
		if($query){
		while($rows=mysql_fetch_assoc($query))
		{
		echo "<option>".$rows['donorname']."</option>";
		}
		}
	?>
	</select>
	</td></tr>
	<tr><td>Scholarship Grant:</td><td><input type="text" name="grantamount" value="0"/></td></tr>
	<tr><td>Status:</td><td><input required="" type="text" name="status" value="0"/></td></tr>
	<tr><td>Password:</td><td><input required="" type="password" name="password"/>
	</td></tr>
	<tr><td></td><td><input type="reset"style="width:150px;" class="btn btn-primary pull-right"  value="RESET"/><input type="submit" class="btn btn-primary pull-right" style="width:150px;" name="submit" value="SAVE"/></td></tr>
	</table>
	
</form>
</div>
<div id="enroling_student">
	<div style="background-color:#4E387E;color:white">Student Enrolment</div>
	<div id="result">
	<?php
	
		if($_GET['done']=="1" || $_GET['done']=='3' || $_GET['done']=='0')
		{
			echo "<div>";
			$stud=$_GET['id'];
			$tutor=$_GET['code'];
			$yrlevel=$_GET['year'];
			$sems=$_GET['sem'];
			
			include("includes/conf.php");
			
			$query=mysql_query("select * from payment where studno='$stud' and coursecode='$tutor'") or die("cant query the table");
			$num=mysql_num_rows($query);
			if($num==1)
			{
				echo "<table width='50%'>";
				while($row=mysql_fetch_assoc($query))
				{
				echo "<td style='color:black'>Student Number:</td><td style='text-align:left'> &nbsp;&nbsp;&nbsp;&nbsp;".$row['studno']."</td><tr/>";
				echo"<td style='color:black'>Name:</td><td style='text-align:left'>&nbsp;&nbsp;&nbsp;&nbsp;".$l."&nbsp;&nbsp;,".$f."&nbsp;".$m."</td><tr/>";
				echo"<td style='color:black'>Course:</td><td style='text-align:left'>&nbsp;&nbsp;&nbsp;&nbsp;".$row['course']."</td><tr/>";
				echo"<td style='color:black'>Year Level:</td><td style='text-align:left'>&nbsp;&nbsp;&nbsp;&nbsp;".$row['yrlevel']."</td><tr/>";
				echo"<td style='color:black'>School Year:</td><td style='text-align:left'>&nbsp;&nbsp;&nbsp;&nbsp;".$row['schoolyear']."</td><tr/>";
				echo"<td style='color:black'>Semester:</td><td style='text-align:left'>&nbsp;&nbsp;&nbsp;&nbsp;".$row['semester']."</td><tr/>";
				echo "<td style='color:black'>Graduating:</td><td style='text-align:left'>&nbsp;&nbsp;&nbsp;&nbsp;".$row['graduating']."</td><tr/>";
				}
				echo"</table>";
				echo"<hr>";
			}
			else
			{	
			echo "No result";
			}
			echo"</div>";
			echo"<div>";
			echo"<hr style='border:1px solid lightgrey'>";
			echo "<div style='background-color:#300000;color:white'>SUBJECTS TO TAKE</div>";
			$query=mysql_query("select * from subjects where sub_yrlevel='$yrlevel'") or die("cant query the table");
			$num=mysql_num_rows($query);
			if($num>0)
			{
				echo "<table width='100%'><th>Subject</th><th>Description</th><th>Units</th><th>Room</th><tr/>";
				
				while($row=mysql_fetch_assoc($query))
				{
				echo "<td><input type='checkbox' name='enrol'/>".$row['sub_code']."</td><td>".$row['sub_description']."</td><td>".$row['units']."</td><td>".$row['room']."</td></tr>";
				}
			echo"</table>";
			}
			else
			{
			echo "Cannot ";
			}
		}
		?>
	</div>
</div>
</div>
</div>
<?php include("includes/footer.php");?>


