<?php
require "conn.php";
$tag_id = $_POST["tag_id"];
#$tag_id = 560;


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

$mysql_qry2 = "SELECT `report_id`, `date`, `type`, `doc_type` FROM `report` WHERE patient_id='$patient_id'";

$response = array();

if ($result2=mysqli_query($conn,$mysql_qry2))
{
    while($row2=mysqli_fetch_row($result2))
    {
        $nameOfFile = $row2[0];
        if(strcmp($row2[3],$image)==0)
            $nameOfFile .= $image;
        else
            $nameOfFile .= $pdf;

        array_push($response, array("date"=>$row2[1], "type"=>$row2[2],"nameOfFile"=>$nameOfFile));
    }

}
echo json_encode(array("server_response"=>$response));

mysqli_close($conn);
?>