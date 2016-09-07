<?php
require "conn.php";
$tag_id = $_POST["tag_id"];
$role = "";

$mysql_qry = "select role from login where tag_id like '$tag_id'";
$nurse = "nurse";
$doctor = "doctor";
$patient = "patient";

$response = array();

if ($result=mysqli_query($conn,$mysql_qry))
{
  while($row=mysqli_fetch_row($result))
    {
		$role = $row[0];				
    }
	
	if(strcmp($role,$nurse)==0)
	{
		echo "nurse";
	}
	else if(strcmp($role,$doctor)==0)
	{
		echo "doctor";
	}
	else if(strcmp($role,$patient)==0)
	{
		echo "patient";
	}	
	else
	{
		echo "failed";
	}
}

mysqli_close($conn);

?>