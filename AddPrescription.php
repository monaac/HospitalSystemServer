<?php
require "conn.php";
set_include_path('.;C:\wamp\bin\php\php5.5.12\pear');
include('Crypt/AES.php');
include('Crypt/RSA.php');
include('Crypt/Random.php');
include('Math/BigInteger.php');
$client_response = $_POST["client_response"];

//Decrypt Data		
//---------------------------------------------------------------
	$cipher = new Crypt_AES(CRYPT_AES_MODE_ECB);
	$symmetricKey = file_get_contents('C:\wamp\www\symmetric.txt');
	$cipher->setKey($symmetricKey);
	$decryptedData = $cipher->decrypt(base64_decode($client_response));
//---------------------------------------------------------------	

$obj = json_decode($decryptedData);

$tag_id = $obj->{"tag_id"};
$doctor_tag = $obj->{"doctor_tag"};
$medicine_name = $obj->{"medicine_name"};
$quantity_per_dosage = $obj->{"quantity_per_dosage"};
$end_date = $obj->{"end_date"};
$morning = $obj->{"morning"};
$afternoon = $obj->{"afternoon"};
$evening = $obj->{"evening"};
$mealRelation = $obj->{"mealRelation"};


$patient_id = "";
$doctor_id = "";
$medicine_id = "";

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

$mysql_qry3 = "SELECT `medicine_id` FROM `medicine` WHERE medicine_name='$medicine_name'";

if ($result3=mysqli_query($conn,$mysql_qry3))
{
  while($row3=mysqli_fetch_row($result3))
    {
		$medicine_id = $row3[0];
	}
}

$curr_date = date("Y-m-d");

$status = "active";

$mysql_qry = "INSERT INTO `hospital`.`prescription` (`prescription_id`, `patient_id`, `doctor_id`, `medicine_id`, `quantity_per_dosage`, `start_date`, `end_date`, `status`, `morning`, `afternoon`, `evening`, `mealRelation`) VALUES (NULL, '$patient_id','$doctor_id','$medicine_id','$quantity_per_dosage','$curr_date', '$end_date', '$status', '$morning', '$afternoon', '$evening', '$mealRelation')";

if ($result=mysqli_query($conn,$mysql_qry))
{
	echo "success";
}
else
{
    echo "failed";
}
mysqli_close($conn);
?>