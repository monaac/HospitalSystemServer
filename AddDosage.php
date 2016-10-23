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
$nurse_tag = $obj->{"nurse_tag"};
$t = $obj->{"time"};
$prescription_id = $obj->{"prescription_id"};

$patient_id = "";
$nurse_id = "";

$mysql_qry1 = "SELECT `patient_id` FROM `patient` WHERE tag_id='$tag_id'";
if ($result1=mysqli_query($conn,$mysql_qry1))
{
    while($row1=mysqli_fetch_row($result1))
    {
        $patient_id = $row1[0];
    }
}

$mysql_qry2 = "SELECT `nurse_id` FROM `nurse` WHERE tag_id='$nurse_tag'";
if ($result2=mysqli_query($conn,$mysql_qry2))
{
    while($row2=mysqli_fetch_row($result2))
    {
        $nurse_id = $row2[0];
    }
}

$mysql_qry = "INSERT INTO `hospital`.`dosage` (`dosage_id`, `time`, `patient_id`, `nurse_id`, `prescription_id`) VALUES (NULL, '$t','$patient_id','$nurse_id','$prescription_id')";

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