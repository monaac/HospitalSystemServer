<?php
require "conn.php";
set_include_path('.;C:\wamp\bin\php\php5.5.12\pear');
include('Crypt/AES.php');
include('Crypt/RSA.php');
include('Crypt/Random.php');
include('Math/BigInteger.php');
$recvData = $_POST["tag_id"];
//$recvData = file_get_contents('C:\wamp\www\recv.txt');

//Decrypt the incoming data 
//--------------------------------------------
$rsa = new Crypt_RSA();
$privatekey = file_get_contents('C:\wamp\www\private.txt');
$rsa->loadKey($privatekey);
$decryptedData = $rsa->decrypt(base64_decode($recvData));
//--------------------------------------------

//Load the symmetric key to be sent and the unique to be tested
//--------------------------------------------
$symmetricKey = file_get_contents('C:\wamp\www\symmetric.txt');
$unique = file_get_contents('C:\wamp\www\unique.txt');
//--------------------------------------------

//Test if unique number matches and send symmetric key by encrypting it using the android public key recieved
//--------------------------------------------
$clientPublicKey = file_get_contents('C:\wamp\www\clientPublicKey.txt');
$pieces = explode ('#',$clientPublicKey);
if(strcmp($decryptedData,$unique)==0)
{
	$rsa = new Crypt_RSA();
	$rsa->loadKey(
				array(
					'e'=> new Math_BigInteger($pieces[1]),
					'n'=> new Math_BigInteger($pieces[0]) 
				)
		);
	$pubMod = $rsa->modulus;
	$pubExp = $rsa->exponent;
	$ciphertext = $rsa->encrypt($symmetricKey);
	echo base64_encode($ciphertext);
}	
//--------------------------------------------

mysqli_close($conn);
?>