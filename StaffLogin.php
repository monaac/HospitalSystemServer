<?php
require "conn.php";
set_include_path('.;C:\wamp\bin\php\php5.5.12\pear');
include('Crypt/AES.php');
include('Crypt/RSA.php');
include('Crypt/Random.php');
include('Math/BigInteger.php');
$tag_id = $_POST["tag_id"];
$role = "";

$mysql_qry = "select role from login where tag_id like '$tag_id'";
$nurse = "nurse";
$doctor = "doctor";

$response = array();

if ($result=mysqli_query($conn,$mysql_qry))
{
  while($row=mysqli_fetch_row($result))
    {
		$role = $row[0];				
    }
	
	if(strcmp($role,$nurse)==0)
	{
		$mysql_qry1 = "SELECT `first_name`, `last_name`, `ward_id` FROM `nurse` WHERE tag_id='$tag_id'";
		if ($result1=mysqli_query($conn,$mysql_qry1))
		{
			while($row1=mysqli_fetch_row($result1))
			{
				$ward_id = $row1[2];
			
				$mysql_qry2 = "SELECT `ward_name` FROM `ward` WHERE ward_id='$ward_id'";
				if ($result2=mysqli_query($conn,$mysql_qry2))
				{	
					while($row2=mysqli_fetch_row($result2))
					{
						$ward_name = $row2[0];
					}
				}
				array_push($response, array("role"=>$role,"first_name"=>$row1[0], "last_name"=>$row1[1],"ward_name"=>$ward_name));						
			}				
		}
		echo json_encode(array("server_response"=>$response));		

	}
	else if(strcmp($role,$doctor)==0)
	{
		$mysql_qry3 = "SELECT `first_name`, `last_name`, `ward_id` FROM `doctor` WHERE tag_id='$tag_id'";
		if ($result3=mysqli_query($conn,$mysql_qry3))
		{
			while($row3=mysqli_fetch_row($result3))
			{
				$ward_id = $row3[2];
		
				$mysql_qry4 = "SELECT `ward_name` FROM `ward` WHERE ward_id='$ward_id'";
				if ($result4=mysqli_query($conn,$mysql_qry4))
				{	
					while($row4=mysqli_fetch_row($result4))
					{
						$ward_name = $row4[0];				
					}
				}
				array_push($response, array("role"=>$role,"first_name"=>$row3[0], "last_name"=>$row3[1],"ward_name"=>$ward_name));						
			}				
		}

//Encrypt Data		
//---------------------------------------------------------------
		$cipher = new Crypt_AES(CRYPT_AES_MODE_ECB);
		$symmetricKey = file_get_contents('C:\wamp\www\symmetric.txt');
		$cipher->setKey($symmetricKey);
		echo base64_encode($cipher->encrypt(json_encode(array("server_response"=>$response))));
//---------------------------------------------------------------		
	}
	else
	{
		echo "failed";
	}
}
mysqli_close($conn);

?>