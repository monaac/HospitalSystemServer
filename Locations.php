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

$mysql_qry2 = "SELECT `time`, `ward_id` FROM `location` WHERE patient_id='$patient_id'";

$response = array();

if ($result2=mysqli_query($conn,$mysql_qry2))
{
  while($row2=mysqli_fetch_row($result2))
    {
		$mysql_qry3 = "SELECT `ward_name` FROM `ward` WHERE ward_id='$row2[1]'";
		if ($result3=mysqli_query($conn,$mysql_qry3))
		{
			while($row3=mysqli_fetch_row($result3))
			{
				$ward_name = $row3[0];
			}	
		}
				
		array_push($response, array("time_stamp"=>$row2[0],"ward_name"=>$ward_name));		
    }
  
}
echo json_encode(array("server_response"=>$response));

mysqli_close($conn);
?>