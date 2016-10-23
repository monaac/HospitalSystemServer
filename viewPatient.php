<?php
require "conn.php";
set_include_path('.;C:\wamp\bin\php\php5.5.12\pear');
include('Crypt/AES.php');
include('Crypt/RSA.php');
include('Crypt/Random.php');
include('Math/BigInteger.php');
$tag_id = $_POST["tag_id"];
//$tag_id = 560;
$mysql_qry = "SELECT `first_name`, `last_name`, `id_num`, `admission_date`,`emergency_num`,`gender`,`phone_num`,`address`,`currWard_id`,`smoker`,`alcoholic`,`image` FROM `patient` WHERE tag_id='$tag_id'";

$response = array();

if ($result=mysqli_query($conn,$mysql_qry))
{
  while($row=mysqli_fetch_row($result))
    {
		$mysql_qry1 = "SELECT `ward_name` FROM `ward` WHERE ward_id='$row[8]'";
		if ($result1=mysqli_query($conn,$mysql_qry1))
		{
			while($row1=mysqli_fetch_row($result1))
			{
				$wardName = $row1[0];
			}				
		}
		
		array_push($response, array("first_name"=>$row[0], "last_name"=>$row[1],"id_num"=>$row[2],"admission_date"=>$row[3],"emergency_num"=>$row[4],"gender"=>$row[5],"phone_num"=>$row[6],"address"=>$row[7],"current_ward"=>$wardName,"smoker"=>$row[9],"alcoholic"=>$row[10],"image"=>$row[11]));
    }
  mysqli_free_result($result);
}
//echo json_encode(array("server_response"=>$response));

//Encrypt Data		
//---------------------------------------------------------------
		$cipher = new Crypt_AES(CRYPT_AES_MODE_ECB);
		$symmetricKey = file_get_contents('C:\wamp\www\symmetric.txt');
		$cipher->setKey($symmetricKey);
		echo base64_encode($cipher->encrypt(json_encode(array("server_response"=>$response))));
//---------------------------------------------------------------		

mysqli_close($conn);
?>