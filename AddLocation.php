<?php
require "conn.php";
$tag_id = $_POST["tag_id"];
$reader_id = $_POST["reader_id"];

//Check if the person exists with the given tag
$mysql_qry = "select * from login where tag_id like '$tag_id'";
$result = mysqli_query($conn,$mysql_qry);
if(mysqli_num_rows($result)>0)
{}
else
{
	echo "not success";
}

//Find the tagged persons role
$mysql_qry4 = "select role from login where tag_id like '$tag_id'";
$nurse = "nurse";
$doctor = "doctor";
$patient = "patient";


if ($result4=mysqli_query($conn,$mysql_qry4))
{
  while($row4=mysqli_fetch_row($result4))
    {
		$role = $row4[0];				
    }
	
	if(strcmp($role,$nurse)==0)
	{
		echo "success";
	}
	else if(strcmp($role,$doctor)==0)
	{
		echo "success";
	}
	else if(strcmp($role,$patient)==0)
	{
		//Find Patient ID
		$mysql_qry1 = "SELECT `patient_id` FROM `patient` WHERE tag_id='$tag_id'";
		if ($result1=mysqli_query($conn,$mysql_qry1))
		{
		  while($row1=mysqli_fetch_row($result1))
			{
				$patient_id = $row1[0];
			}
		}
		else
		{
			echo "not success";
			
		}		
		
		//Check if the ward exists 
		$mysql_qry2 = "SELECT `ward_id` FROM `ward` WHERE reader_id='$reader_id'";
		if ($result2=mysqli_query($conn,$mysql_qry2))
		{
		  while($row2=mysqli_fetch_row($result2))
			{
				$ward_id = $row2[0];
			}
		}
		else
		{
			echo "not success";
			
		}
		//If the ward exists and patients exists.... add location and send success
		$mysql_qry3 = "INSERT INTO `hospital`.`location` (`location_id`, `patient_id`, `time`,`ward_id`) VALUES (NULL, '$patient_id', CURRENT_TIMESTAMP,'$ward_id')";
		if ($result3=mysqli_query($conn,$mysql_qry3))
		{
			echo "success";
		}		
	}	
	else
	{
		echo "not success";
	}
}

mysqli_close($conn);

?>