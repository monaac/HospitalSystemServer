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

$mysql_qry2 = "SELECT `type` FROM `allergies` WHERE patient_id='$patient_id'";

$response = array();

if ($result2=mysqli_query($conn,$mysql_qry2))
{
  while($row2=mysqli_fetch_row($result2))
    {
		array_push($response, array("type"=>$row2[0]));		
    }
  
}
echo json_encode(array("server_response"=>$response));

mysqli_close($conn);
?>