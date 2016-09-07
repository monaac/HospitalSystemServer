<?php
require "conn.php";
$tag_id = $_POST["tag_id"];
$doctor_tag = $_POST["doctor_tag"];
$bpn = $_POST["bpn"];
$bpd = $_POST["bpd"];
$temperature = $_POST["temperature"];
$pulse = $_POST["pulse"];
$weight = $_POST["weight"];

$patient_id = "";
$doctor_id = "";

$mysql_qry1 = "SELECT `patient_id` FROM `patient` WHERE tag_id='$tag_id'";

if ($result1=mysqli_query($conn,$mysql_qry1))
{
  while($row1=mysqli_fetch_row($result1))
    {
		$patient_id = $row1[0];
	}
}	

$mysql_qry2 = "SELECT `doctor_id` FROM `doctor` WHERE tag_id='$doctor_tag'";

if ($result2=mysqli_query($conn,$mysql_qry2))
{
  while($row2=mysqli_fetch_row($result2))
    {
		$doctor_id = $row2[0];
	}
}

$mysql_qry = "INSERT INTO `hospital`.`observation` (`observation_id`, `patient_id`, `doctor_id`, `date`, `bpn`, `bpd`, `temperature`, `pulse`, `weight`) VALUES (NULL, '$patient_id', '$doctor_id', CURRENT_TIMESTAMP, '$bpn', '$bpd', '$temperature', '$pulse', '$weight')";

if ($result=mysqli_query($conn,$mysql_qry))
{
	echo "success";
}
mysqli_close($conn);
?>