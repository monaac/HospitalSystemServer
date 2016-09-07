<?php
require "conn.php";

$tag_id = "999";
$id_num = "6642135763021";
$first_name = "Hello";
$last_name = "World";
$gender = "male";
$phone_num = "0827809898";
$emergency_num = "0619453231";
$address = "Clancey Avenue";
$current_ward = "3";

#$tag_id = $_POST["tag_id"];
#$id_num = $_POST["role"];
#$first_name = $_POST["tag_id"];
#$last_name = $_POST["role"];
#$gender = $_POST["tag_id"];
#$phone_num = $_POST["role"];
#$emergency_num = $_POST["tag_id"];
#$address = $_POST["role"];
#$current_ward = $_POST["role"];

$mysql_qry = "INSERT INTO `hospital`.`patient` (`patient_id`, `tag_id`, `id_num`, `first_name`, `last_name`, `gender`, `phone_num`, `emergency_num`, `address`, `admission_date`, `current_ward`) VALUES (NULL, '$tag_id', '$id_num', '$first_name', '$last_name', '$gender', '$phone_num', '$emergency_num', '$address', CURRENT_TIMESTAMP, '$current_ward')";

if($conn->query($mysql_qry) === TRUE){
	echo "insert success";
}
else{
	echo "Error: ". $mysql_qry . "<br>". $conn->error;
}
mysqli_close($conn);
?>