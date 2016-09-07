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

$mysql_qry2 = "SELECT `date`, `doctor_id`, `bpn`, `bpd`, `temperature`, `pulse`, `weight` FROM `observation` WHERE patient_id='$patient_id'";

$response = array();

if ($result2=mysqli_query($conn,$mysql_qry2))
{
  while($row2=mysqli_fetch_row($result2))
    {
		$mysql_qry3 = "SELECT `first_name`, `last_name` FROM `doctor` WHERE doctor_id='$row2[1]'";
		if ($result3=mysqli_query($conn,$mysql_qry3))
		{
			while($row3=mysqli_fetch_row($result3))
			{
				$docFName = $row3[0];
				$docLName = $row3[1];
			}	
		}
		array_push($response, array("date"=>$row2[0], "doc_first_name"=>$docFName,"doc_last_name"=>$docLName,"bpn"=>$row2[2],"bpd"=>$row2[3],"temperature"=>$row2[4],"pulse"=>$row2[5],"weight"=>$row2[6]));		
    }
  
}
echo json_encode(array("server_response"=>$response));

mysqli_close($conn);
?>