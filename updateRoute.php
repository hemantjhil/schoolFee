<?php
if (isset($_GET["login"]) && isset($_GET["admno"]))
{
include('config.php');
$admno=$_GET['admno'];
$route_id=$_GET['route_id'];
$routeUpdateQuery="update student_2022 set transport_route= 2 where admno='$admno'";
if(mysqli_query($conn,$routeUpdateQuery)){
	echo "ADMISSION NO : ".$admno;
    echo "</br>";
    echo "</br>";

	echo "UPDATE SUCCESS";
}
else{
	echo "UPDATE FAIL";
}
}
?>