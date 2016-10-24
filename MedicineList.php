<?php
require "conn.php";
set_include_path('.;C:\wamp\bin\php\php5.5.12\pear');
include('Crypt/AES.php');
include('Crypt/RSA.php');
include('Crypt/Random.php');
include('Math/BigInteger.php');

//Extract Data Required from database and package it
//---------------------------------------------------------------
$response = array();

$mysql_qry = "SELECT `medicine_name` FROM `medicine`";

if ($result=mysqli_query($conn,$mysql_qry))
{
  while($row=mysqli_fetch_row($result))
    {
		array_push($response, array("medicine_name"=>$row[0]));
	}
}
//---------------------------------------------------------------

//Encrypt Outgoing Data
//---------------------------------------------------------------
        $cipher = new Crypt_AES(CRYPT_AES_MODE_ECB);
        $symmetricKey = file_get_contents('C:\wamp\www\symmetric.txt');
        $cipher->setKey($symmetricKey);
        echo base64_encode($cipher->encrypt(json_encode(array("server_response"=>$response))));
//---------------------------------------------------------------	
mysqli_close($conn);
?>