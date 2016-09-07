<?php
require "conn.php";
$tag_id = $_POST["tag_id"];
$role = $_POST["role"];
$mysql_qry = "select * from login where tag_id like '$tag_id' and role like '$role'";
$result = mysqli_query($conn,$mysql_qry);
if(mysqli_num_rows($result)>0){
	echo "success";
}
else{
	echo "not success";
}
mysqli_close($conn);

?>