<?php
require "conn.php";

$response = array();

$mysql_qry = "SELECT `medicine_name` FROM `medicine`";

if ($result=mysqli_query($conn,$mysql_qry))
{
  while($row=mysqli_fetch_row($result))
    {
		array_push($response, array("medicine_name"=>$row[0]));
	}
}	

echo json_encode(array("server_response"=>$response));

mysqli_close($conn);
?>