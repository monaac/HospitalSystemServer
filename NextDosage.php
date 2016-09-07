<?php
require "conn.php";
$tag_id = $_POST["tag_id"];
#$tag_id = "560";


$mysql_qry1 = "SELECT `patient_id` FROM `patient` WHERE tag_id='$tag_id'";

if ($result1=mysqli_query($conn,$mysql_qry1))
{
  while($row1=mysqli_fetch_row($result1))
    {
		$patient_id = $row1[0];
	}
}	

$current_hour = date("H");

$status = "active";

$mysql_qry2 = "SELECT `medicine_id`, `quantity_per_dosage`, `status`, `morning`,`afternoon`,`evening`,`mealRelation`, `prescription_id` FROM `prescription` WHERE patient_id='$patient_id' AND status = 'active'";

$response = array();
$medName = "";
$t = "true";

if ($result2=mysqli_query($conn,$mysql_qry2))
{
  while($row2=mysqli_fetch_row($result2))
    {		
		$mysql_qry4 = "SELECT `medicine_name` FROM `medicine` WHERE medicine_id='$row2[0]'";
		if ($result4=mysqli_query($conn,$mysql_qry4))
		{
			while($row4=mysqli_fetch_row($result4))
			{
				$medName = $row4[0];
			}	
		}
		
		if($current_hour > "5" and $current_hour < "11" and $row2[3] == $t)
		{
			array_push($response, array("medName"=>$medName,"quantity_per_dosage"=>$row2[1], "mealRelation"=>$row2[6],"prescription_id"=>$row2[7]));		
		}
		elseif($current_hour > "10" and $current_hour < "17" and $row2[4] == $t)
		{
			array_push($response, array("medName"=>$medName,"quantity_per_dosage"=>$row2[1], "mealRelation"=>$row2[6],"prescription_id"=>$row2[7]));			
		}
		elseif($current_hour > "17" and $current_hour < "23" and $row2[5] == $t)
		{
			array_push($response, array("medName"=>$medName,"quantity_per_dosage"=>$row2[1], "mealRelation"=>$row2[6],"prescription_id"=>$row2[7]));		
		}
		
    }
  
}
echo json_encode(array("server_response"=>$response));

mysqli_close($conn);
?>