<?php
require "conn.php";
$tag_id = $_POST["tag_id"];
$type = $_POST["type"];

$mysql_qry1 = "SELECT `patient_id` FROM `patient` WHERE tag_id='$tag_id'";

if ($result1=mysqli_query($conn,$mysql_qry1))
{
  while($row1=mysqli_fetch_row($result1))
    {
		$patient_id = $row1[0];
	}
}	

$mysql_qry = "INSERT INTO `hospital`.`allergies` (`allergy_id`, `patient_id`, `type`) VALUES (NULL, '$patient_id', '$type')";

if ($result=mysqli_query($conn,$mysql_qry))
{
	echo "success";
}
mysqli_close($conn);
?>