<?php
require "conn.php";
set_include_path('.;C:\wamp\bin\php\php5.5.12\pear');
include('Crypt/AES.php');
include('Crypt/RSA.php');
include('Crypt/Random.php');
include('Math/BigInteger.php');
$client_response = $_POST["client_response"];

//Decrypt Incoming Data
//---------------------------------------------------------------
	$cipher = new Crypt_AES(CRYPT_AES_MODE_ECB);
	$symmetricKey = file_get_contents('C:\wamp\www\symmetric.txt');
	$cipher->setKey($symmetricKey);
	$decryptedData = $cipher->decrypt(base64_decode($client_response));
//---------------------------------------------------------------	

//Unpack Incoming Data
//---------------------------------------------------------------
$obj = json_decode($decryptedData);
$tag_id = $obj->{"tag_id"};
$typeOfFile = $obj->{"typeOfFile"};
//---------------------------------------------------------------

$mysql_qry1 = "SELECT `patient_id` FROM `patient` WHERE tag_id='$tag_id'";

if ($result1=mysqli_query($conn,$mysql_qry1))
{
    while($row1=mysqli_fetch_row($result1))
    {
        $patient_id = $row1[0];
    }
}

$image = ".jpg";
$pdf = ".pdf";
$nameOfFile = "";
$i = "image";

$mysql_qry2 = "SELECT `report_id`,`doc_type` FROM `report` WHERE patient_id='$patient_id' AND type = '$typeOfFile'";

if ($result2=mysqli_query($conn,$mysql_qry2))
{
    while($row2=mysqli_fetch_row($result2))
    {
        $nameOfFile = $row2[0]; //report_id
        if(strcmp($row2[1],$i)==0)
            $nameOfFile .= $image;
        else
            $nameOfFile .= $pdf;
		
		//Encrypt File and store on server
		//---------------------------------------------------------------
			$cipher = new Crypt_AES(CRYPT_AES_MODE_ECB);
			$symmetricKey = file_get_contents('C:\wamp\www\symmetric.txt');
			$cipher->setKey($symmetricKey);
			$pathToFile = 'C:\wamp\www'.DIRECTORY_SEPARATOR.$nameOfFile;
			$newFileName = 'C:\wamp\www'.DIRECTORY_SEPARATOR.$row2[0].'E';	
			if(strcmp($row2[1],$i)==0)
				$newFileName  .= $image;
			else
				$newFileName  .= $pdf;			
			$fileData = file_get_contents($pathToFile);
			$encryptedFileData = $cipher->encrypt($fileData);
			file_put_contents($newFileName,$encryptedFileData);
			$newFileNameToSend = $row2[0].'E';	
			if(strcmp($row2[1],$i)==0)
				$newFileNameToSend  .= $image;
			else
				$newFileNameToSend  .= $pdf;	
			echo $newFileNameToSend;
		//---------------------------------------------------------------
    }
}
mysqli_close($conn);
?>