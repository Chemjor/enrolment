<?php
	session_start();
	if(!(isset($_SESSION['username'])) && !(isset($_SESSION['status'])) && !(isset($_SESSION['level'])=='100'))
	{
		header('Location:../index.php');
	}
?>
<?php include('includes/header.php'); ?>
<!-- ajax-->

<!--end ajax-->
<div style="text-align:center;color:green;margin:5px;padding:5px;background-color:#CCCCFF;border-radius:5px">
WELCOME TO CURRICULUM-BASED ENROLMENT SYSTEM.You are login as<font color="red"> 
<?php echo $_SESSION['username'];?>|<a href="../home.php">
<span class="glyphicon glyphicon-home">Home</span></a>|<a href="instructors.php">
<span class="glyphicon glyphicon-user">Instructor</span></a>|<a href="manage_subjects.php">
<span class="glyphicon glyphicon-user">Subjects</span></a>|<a href="../logout.php">
<span class="glyphicon glyphicon-remove">Logout</span></a> </font>
</div>
<div id="offered">
<?=alert_messages()?>
<style type="text/css">
	tr .hover{background-color: blue;}
</style>
	<div style="">
	<?php
		$query=mysql_query("select * from subject_units");
		echo "<table class='table table-stripped'>
				<th>Course ID</th><th>Semester</th><th>Units</th><th>Year Level</th><th width='12%'>Operation|
				 <a href='add-units.php'data-toggle='modal'  data-target='#myModal id='add-units'>
				 <span class='glyphicon glyphicon-plus'></span></a></th><tr/>";
		while($data=mysql_fetch_assoc($query)){
			$id=$data['id'];
			echo "<tr><td>".$data['course_id']."</td>
			<td>".$data['semester']."</td>
			<td>".$data['units']."</td>
			<td>".$data['yrlevel']."</td>
			<td>
			<span class='json-data hidden'>".json_encode($data)."</span>
			<a href='#editModal' data-toggle='modal' data-target='#myModal' class='units-edit'>
			<span class='glyphicon glyphicon-edit' title='edit'>Edit</span></a>
			|&nbsp;<a href='actions.php?r=deleteUnits&id=$id'>
			<span class='glyphicon glyphicon-trash' title='Delete'></span></a></tr>";
		}
		echo "</table>";
	?>
	</div>
<script type="text/javascript">
	$(document).ready(function(){
		//add units//
		$("#add-units").click(function(){
		//input here
			$("#myModalLabel").html('Create New Units');
			$("#units-form").attr('action', 'actions.php?r=createUnits');
			$("#units-form input").val('');
		});
		//do edit of the units
		$(".units-edit").click(function(){
			var data  = $(this).parent().find(".json-data").html();
			var data = JSON.parse(data);

			$("#myModalLabel").html('Edit Units');
			$("#units-form").attr('action', 'actions.php?r=updateUnits');
			$("#course_id").val(data.course_id);
			$("#cos_id").val(data.id);
			$("#semester").val(data.semester);
			$("#units").val(data.units);
			$("#yr_level").val(data.yrlevel);			
	});
});
</script>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#A0CFEC;text-align:center;padding:10px;color:white">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel"><b>{Modal Label}</b></h4>
      </div>

      <form  class="form" role="form" method="post" id="units-form" action="{url_action}">
      <input type="hidden" id="cos_id" name="id" />
 		<div id="add_sub">
 			  <div class="form-group">
			  <label for="course_id" >Course ID:</label>
			  <div><input type="text"  required class="form-control" id="course_id" name="course_id"></div>
			  </div>
			  <div class="form-group">
			  <label for="semester" >Semester:</label>
			  <div><input type="text" required class="form-control" id="semester" name="semester"></div>
			  </div>

			  <div class="form-group" >
			  <label for="units">Units:</label>
			  <div><input type="text" required class="form-control" id="units" name="units"></div>
			  </div>

			  <div class="form-group">
			  <label for="yr_level">Year Level:</label>
			  <div> <input type="text" required class="form-control" id="yr_level" name="yr_level"></div>
			  </div>
		</div>
      <div class="modal-footer" style="padding:5px">
      <button type="submit" class="btn btn-primary">UpDate</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        
      </div>

		</form>  

		</div>
		</div>
	</div>		 
</div>


<?php include('includes/footer.php');?>