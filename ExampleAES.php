<?php
/**
 * Created by PhpStorm.
 * User: Ahmad
 * Date: 9/28/2016
 * Time: 10:58 PM
 */
set_include_path('.;C:\wamp\bin\php\php5.5.12\pear');
include('Crypt/AES.php');
include('Crypt/Random.php');

$cipher = new Crypt_AES(CRYPT_AES_MODE_CTR);
// keys are null-padded to the closest valid size
// longer than the longest key and it's truncated
//$cipher->setKeyLength(128);
$cipher->setKey('abcdefghabcdefgh');
// the IV defaults to all-NULLs if not explicitly defined
//$cipher->setIV(crypt_random_string($cipher->getBlockLength() >> 3));
$cipher->setIV('RandomInitVecto1');

$size = 10;
$plaintext = str_repeat('a', $size);
echo $plaintext."<br>";
echo $cipher->encrypt($plaintext)."<br>";
echo $cipher->decrypt($cipher->encrypt($plaintext))."<br>";
?>