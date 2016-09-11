<?php
require "conn.php";
$first_name = $_POST["first_name"];
$last_name = $_POST["last_name"];

$mysql_qry = "select tag_id from patient where first_name like '$first_name' and last_name like '$last_name'";
$result = mysqli_query($conn,$mysql_qry);
if(mysqli_num_rows($result)>0){
    if($row=mysqli_fetch_row($result))
    {
        echo $row[0];
    }
}
else{
    echo "not success";
}
mysqli_close($conn);

?>