<?php
//set_include_path(get_include_path() . PATH_SEPARATOR . 'phpseclib');
set_include_path('.;C:\wamp\bin\php\php5.5.12\pear');
include('Crypt/RSA.php');

$rsa = new Crypt_RSA();

//$rsa->setPrivateKeyFormat(CRYPT_RSA_PRIVATE_FORMAT_PKCS1);
//$rsa->setPublicKeyFormat(CRYPT_RSA_PUBLIC_FORMAT_PKCS1);

//define('CRYPT_RSA_EXPONENT', 65537);
//define('CRYPT_RSA_SMALLEST_PRIME', 64); // makes it so multi-prime RSA is used
extract($rsa->createKey()); // == $rsa->createKey(1024) where 1024 is the key size

echo $privatekey;
echo $publickey;
?>