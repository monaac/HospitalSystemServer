<?php
require "conn.php";
$tag_id = $_POST["tag_id"];

$mysql_qry1 = "SELECT `patient_id` FROM `patient` WHERE tag_id='$tag_id'";

if ($result1=mysqli_query($conn,$mysql_qry1))
{
  while($row1=mysqli_fetch_row($result1))
    {
		$patient_id = $row1[0];
	}
}	

$mysql_qry2 = "SELECT `start_date`, `end_date`,`doctor_id`,`medicine_id`, `quantity_per_dosage`, `status`, `morning`,`afternoon`,`evening`,`mealRelation`FROM `prescription` WHERE patient_id='$patient_id'";

$response = array();

if ($result2=mysqli_query($conn,$mysql_qry2))
{
  while($row2=mysqli_fetch_row($result2))
    {
		$mysql_qry3 = "SELECT `first_name`, `last_name` FROM `doctor` WHERE doctor_id='$row2[2]'";
		if ($result3=mysqli_query($conn,$mysql_qry3))
		{
			while($row3=mysqli_fetch_row($result3))
			{
				$docFName = $row3[0];
				$docLName = $row3[1];
			}	
		}
		
		$mysql_qry4 = "SELECT `medicine_name` FROM `medicine` WHERE medicine_id='$row2[3]'";
		if ($result4=mysqli_query($conn,$mysql_qry4))
		{
			while($row4=mysqli_fetch_row($result4))
			{
				$medName = $row4[0];
			}	
		}		
		array_push($response, array("start_date"=>$row2[0],"end_date"=>$row2[1], "doc_first_name"=>$docFName,"doc_last_name"=>$docLName,"medName"=>$medName,"quantity_per_dosage"=>$row2[4],"status"=>$row2[5],"morning"=>$row2[6],"afternoon"=>$row2[7],"evening"=>$row2[8],"mealRelation"=>$row2[9]));		
    }
  
}
echo json_encode(array("server_response"=>$response));

mysqli_close($conn);
?>