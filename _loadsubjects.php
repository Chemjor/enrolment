<?php

			$query=mysql_query("select * from subject_offered where course_id='$coscode' and sub_yr='$yrlevel'");
								 
			if($query)
			{
				echo"<table class='table table-hover' width='100%'><th></th><th>SUBJECT</th><th>SECTION</th><th>DESCRIPTION</th><th>SCHEDULE</th><th>ROOM</th><th>UNITS</th><tr/>";
				while($data=mysql_fetch_assoc($query))
				{
				echo "<td><input type='checkbox' name='subject' value=''><td>".$data['subject_code']."</td><td>".$data['sections']."</td><td>".$data['sub_description']."</td><td>".$data['schedule']."</td><td>".$data['room']."</td><td>".$data['sub_units']."</td><tr/>";
				}
				echo"</table>";
			}
			else
			echo"Error in the query table";
			
		?>