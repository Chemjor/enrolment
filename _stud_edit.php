<?php
ob_start();
	session_start();
	if(!(isset($_SESSION['username'])) && !(isset($_SESSION['status'])))
	{
		header('Location:index.php');
	}
?>
<?php 
include('includes/header.php');
include("_function_country.php");
include("includes/conf.php");
?>

<div style="text-align:center;color:green;margin:5px;padding:5px;background-color:#CCCCFF;border-radius:5px">WELCOME TO CURRICULUM-BASED ENROLMENT SYSTEM. You are login as<font color="red"> <?php echo $_SESSION['username'];?> </font>|<a href="home.php">
<span class="glyphicon glyphicon-home">Home</span></a>|<a href="logout.php"><span class="glyphicon glyphicon-flash">Logout</span></a></div>
<!--right panel-->
<div  id="contents">
	<!--right panel-->
	<div id="enrol1">
<script type="text/javascript "src="js/livesearch.js"></script>
<script type='text/javascript'>

$(document).ready(function(){

$("#search_results").slideUp();

$("#button_find").click(function(event){

event.preventDefault();

search_ajax_way();

});

$("#search_query").keyup(function(event){

event.preventDefault();

search_ajax_way();

});

});

function search_ajax_way(){

$("#search_results").show();

var search_this=$("#search_query").val();

$.post("search.php", {searchit : search_this}, function(data){

$("#display_results").html(data);
})
}

</script>
	
		<div id="search"><div style="text-align:center;color:green;margin:10px;background-color:#CCCCFF">SEARCH STUDENT</h4></div>
		<form method="post" >
		<center><input style="width:200px" type="text"  placeholder="studno or surname" class="form-control" name="search_query" id="search_query" /></center><br>
		
		</form>
		<div id="display_results"></div>

		</div>
		
	</div>
	<!--right panel-->
	<div id="enrol2">
	
		<div style="text-align:center;color:green;margin:10px;background-color:#CCCCFF">STUDENT REGISTRATION FORM - (if student is not in the database)</div>
		<center>
		<?php
		if(isset($_GET['error']))
		{
			if($_GET['error']=="1"){
			echo "<div class='alert-warning'>The students Information exist in the System.Proceed to enrolment</div>";
			}
			if($_GET['error']=="2"){
			echo "<div class='alert-warning'>The Record is Saved....</div>";
			}
			if($_GET['error']=="4"){
			echo "<div class='alert-warning'>Please enter the password....</div>";
			}
		}
		?>
		<?php
		include('includes/conf.php');
			$id=$_GET['id'];
			$query=mysql_query("select * from stud_information where studno='$id'");
			$data=mysql_fetch_assoc($query);
			$fnames=$data['fname'];
			$mids=$data['mname'];
			$lnames=$data['lname'];
			$f=$data['sufname'];
			$dob=$data['bday'];
			$bplaces=$data['bplace'];
			$courses=$data['course'];
			$stret=$data['street'];
			$barang=$data['barangay'];
			$citys=$data['town'];
			$provs=$data['province'];
			$conts=$data['contact'];
			$parents=$data['parent'];
			$parnos=$data['parent_con'];
			$fathers=$data['father'];
			$fno=$data['father_con'];
			$mothers=$data['mother'];
			$mno=$data['mother_con'];
			$sp=$data['spouse'];
			$spno=$data['spouse_con'];
			$boz=$data['numboy'];
			$gir=$data['numgirl'];
			$or=$data['or_num'];
			$ordata=$data['or_date'];
			$country=$data['country'];
			
		?>

		<table width="70%">
		<form  method="post" action="check_stud_edit.php">
			<input type="hidden" value="<?php echo $id;?>" name="studno"/>
			<td width="10%">First Name:<td><input type="text" class="form-control" required="" name="fname" value="<?php echo $fnames;?>"  /></td><tr/>
			<td>Middle Name:<td><input type="text" class="form-control" required="" name="mname" value="<?php echo $mids;?>"/></td><tr/>
			<td>Last Name:<td><input type="text" class="form-control" required="" name="lname" value="<?php echo $lnames;?>"/></td><tr/>
			<td>Suffix:<td><input type="text" class="form-control" required="" name="suf" value="<?php echo $f;?>"/></td><tr/>
			<td>Gender:</td><td>
			<select name="gender"   required="gender" >
			<option class="form-control" value="M">Male</option>
			<option class="form-control" value="F">Female</option>
			</select>
			</td><tr/>
			<td>Status:</td><td>
			<select name="status" required="">
			<option class="form-control" value="Single">Single</option>
			<option class="form-control" value="Married">Married</option>
			<option class="form-control" value="Separated">Separated</option>
			<option class="form-control" value="Widow">Widow</option>
			<option class="form-control" value="Bachelor">Bachelor</option>
			</select>
			</td><tr/>
			<td>BirthDay:<td><input type="date" value="<?php echo $dob;?>" required="" class="form-control" name="dob"/></td><tr/>
			<td>Birth Place:<td><input type="text" value="<?php echo $bplaces;?>" required="" class="form-control" name="bplace"/></td><tr/>
			<td>Course:</td>
			<td>
			<select name="course">
			<?php
			include("includes/conf.php");
				$query="SELECT * FROM courses ORDER BY name";
				$result=mysql_query($query);
				if($result){
				$num=mysql_num_rows($result);
				if($num>0){
					$i=0;
					while ($i < $num){
						$rows=mysql_fetch_assoc($result);
						$courseid=$rows['courseid'];
						$course=$rows['name'];
						if ($course==$courseid)
							echo "<option value='$course' selected>$course";
						else
							echo "<option value='$course'>$course";
						$i++;
					}
				
				}
			}?>
			</select>
			</td><tr/>
			<tr/>
			<td>Street:<td><input type="text" required="" value="<?php echo $stret;?>" class="form-control" name="street"/></td><tr/>
			<td>Barangay:<td><input type="text" required="" class="form-control" value="<?php echo $barang;?>" name="barangay"/></td><tr/>
			<td>City / Town:<td><input type="text" required="" class="form-control" value="<?php echo $citys;?>" name="town"/></td><tr/>
			<td>Province:<td><input type="text" required=""  class="form-control" value="<?php echo $provs;?>" name="province"/></td><tr/>
			<td>Country:</td>
			<td>
			<select name="country" required="" >
				<?php
					$countries = get_countries();
					
					foreach ($countries as $country_code =>$country_name)
					{	
						
					if ($country_code ==$country_code)
						{
						echo "<option value='$country_code' selected>$country_name";
						}
					elseif($country_code==$country_name)
						{
							echo "<option value='$country_code'>$country_name";
						}
					}
				?>
			</select>
			</td>	
			<tr/>
			<td>Contact No:<td><input type="text" required="" value="<?php echo $conts;?>" class="form-control" name="contact"/></td><tr/>
			<td>Parent/Guardian:<td><input type="text" required=""value="<?php echo $parents;?>" class="form-control" name="parent"/></td><tr/>
			<td>Contact No.(Guardian):<td><input type="text" required="" value="<?php echo $parnos;?>" class="form-control" name="parno" /></td><tr/>
			<td>Father's Name:<td><input type="text" required="" class="form-control" value="<?php echo $fathers;?>" name="father"/></td><tr/>		
			<td>Father's No:<td><input type="text" required="" class="form-control" value="<?php echo $fno;?>" name="fatherno"/></td><tr/>
			<td>Mother's Name:<td><input type="text" required="" class="form-control" value="<?php echo $mothers;?>" name="mother"/></td><tr/>	
			<td>Mother's No:<td><input type="text" required="" class="form-control" value="<?php echo $mno;?>" name="motherno"/></td><tr/>
			<td>Spouse Name :<td><input type="text"  class="form-control" value="<?php echo $sp;?>" name="spouse"/></td><tr/>
			<td>Spouse No:<td><input type="text"  class="form-control" value="<?php echo $spno;?>" name="spouseno"/></td><tr/>
			<td>No of Children:<td>
			<?php
			include("includes/conf.php");
				$query=mysql_query("select * from stud_information");
				$rows=mysql_fetch_assoc($query);
				$boys=$rows['numboy'];
				$girls=$rows['numboy'];
				
				if(!$boys)
				{
				$boy=0;
				}
				if(!$girls)
				{
				$girl=0;
				}
			?>
			Boys:<input type="text" required="" class="form-control" name="boys" value="<?php echo $boy;?>"/><br>
			Girls:<input type="text" required="" class="form-control" value="<?php echo $girl;?>" name="girls" />
			</td><tr/>
			<td>OR Number:<td><input  type="text" required="" class="form-control" value="<?php echo $or;?>" name="orno"/></td><tr/>
			<td>OR Date:<td><input type="date" required="" class="form-control" value="<?php echo $ordata;?>" name="ordate"/></td><tr/>	
			<td>Password:</td><td><input type="password" class=" form-control" name="password"/></td><tr/>
			<td><input type="submit" class="btn btn-primary form-control pull-right" name="submit"/></td><tr/>
		</table>	
		</form>
	</div>
</div>

<?php include("includes/footer.php");?>
