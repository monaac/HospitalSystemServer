<?php
require "conn.php";
set_include_path('.;C:\wamp\bin\php\php5.5.12\pear');
include('Crypt/AES.php');
include('Crypt/RSA.php');
include('Crypt/Random.php');
include('Math/BigInteger.php');
$tag_id = $_POST["tag_id"];

//Extract Data Required from database and package it
//---------------------------------------------------------------
$mysql_qry1 = "SELECT `patient_id` FROM `patient` WHERE tag_id='$tag_id'";

if ($result1=mysqli_query($conn,$mysql_qry1))
{
    while($row1=mysqli_fetch_row($result1))
    {
        $patient_id = $row1[0];
    }
}

$mysql_qry2 = "SELECT `time`, `nurse_id`, `prescription_id` FROM `dosage` WHERE patient_id='$patient_id' ORDER BY `time` DESC";

$response = array();
$medName = "";
$quantity = "";
$nurse = "";
$medicine_id = "";
$morning = "morning";
$afternoon = "afternoon";
$evening = "evening";

$current_hour = date("H");
$current_date = date("YYYY-mm-dd");

if ($result2=mysqli_query($conn,$mysql_qry2))
{
    while($row2=mysqli_fetch_row($result2))
    {

        $mysql_qry3 = "SELECT `medicine_id`, `quantity_per_dosage` FROM `prescription` WHERE `prescription_id`='$row2[2]'";
        if ($result3=mysqli_query($conn,$mysql_qry3))
        {
            while($row3=mysqli_fetch_row($result3))
            {
                $medicine_id = $row3[0];
                $quantity = $row3[1];
            }
        }

        $mysql_qry4 = "SELECT `medicine_name` FROM `medicine` WHERE medicine_id='$medicine_id'";
        if ($result4=mysqli_query($conn,$mysql_qry4))
        {
            while($row4=mysqli_fetch_row($result4))
            {
                $medName = $row4[0];
            }
        }

        $mysql_qry5 = "SELECT `first_name`, `last_name` FROM `nurse` WHERE nurse_id = '$row2[1]'";
        if ($result5=mysqli_query($conn,$mysql_qry5))
        {
            while($row5=mysqli_fetch_row($result5))
            {
                $nurse = $row5[0];
                $nurse .= " ";
                $nurse .= $row5[1];
            }
        }

        $time_stamp = strtotime($row2[0]);
        $hour = date('H',$time_stamp);

        if($hour>"-1" && $hour<"11")
            array_push($response, array("nurse"=>$nurse,"time"=>$row2[0],"medName"=>$medName,"quantity"=>$quantity,"period"=>$morning));
        elseif($hour>"11" && $hour<"18")
            array_push($response, array("nurse"=>$nurse,"time"=>$row2[0],"medName"=>$medName,"quantity"=>$quantity,"period"=>$afternoon));
        elseif($hour>"17" && $hour<"24")
            array_push($response, array("nurse"=>$nurse,"time"=>$row2[0],"medName"=>$medName,"quantity"=>$quantity,"period"=>$evening));

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