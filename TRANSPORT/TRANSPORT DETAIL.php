<html>
<title>STUDENT TRANSPORT DETAIL</title>
<head>
	<!-- <script type="text/javascript" src="add_Student.js"></script> -->
	</head>
<body>
	<form action="" method="get">
<div id="student_fee0">
	<!-- <script type="text/javascript" src="add_Student.js"></script> -->
<fieldset>
	<legend>STUDENT DETAIL</legend>

<tr>
<td>Admission No.</td>
<td><input type="text" name="admno" id="admno" size="30"></td>
</tr>
<!-- <input type="integer" name=pay id="pay" size="20"/> -->

</fieldset>
</div>
<div>
<input type="hidden" name=index id="index" value="0">
<input type = "submit" name = "login" value = "CHECK ROUTE"/>
</div>
</form>
</body>
</html>

<!DOCTYPE html>
<html>
	<head>
		<title></title>
	<!-- <script type="text/javascript" src="add_Student.js"></script> -->
</head>
	<body id="tb1">
		<form action="updateRoute.php" method="get" id="final0">
			<fieldset>
			<legend>ROUTE DETAIL</legend>

<?php
$year = date("m") < 4 ? date("Y") - 1 : date("Y");
$studentSession = "student_" . $year;
include('../config.php');
if (isset($_GET["admno"])) {
	$admno = $_GET["admno"];
	$routeDetail = "SELECT st.admno, sd.name, t.id,t.rfee,t.route_name  FROM student_2022 st 
					join student_detail sd on sd.admno=st.admno 
					LEFT join transport t on t.id= st.transport_route 
					WHERE st.admno='$admno'";
    $routeQuery = mysqli_query($conn, $routeDetail);
    $routeFetch = $routeQuery->fetch_assoc();

    $studentName=$routeFetch["name"];
    $routeName=$routeFetch["route_name"];
    $routeFee = $routeFetch["rfee"];
    echo '<input type="hidden" maxlength=100 name="admno" id="admno" value="'.$admno.'">';

    echo "ADMISSION NO : ".$admno;
    echo "</br>";
    echo "</br>";

    echo "STUDENT NAME : ".$studentName;
    echo "</br>";
    echo "</br>";
    echo "ROUTE : ".$routeName;
    echo "</br>";
    echo "</br>";
    echo "ROUTE FARE ".$routeFee;
    echo "</br>";
    echo "</br>";
}
?>


<tr>
<td>UPDATE ROUTE</td>
<td><select name="route_id" id="route_id">
<option value="-1" selected>select..</option>
<option value=2>JANSA - 600</option>
<option value=3>BADAURA - 600</option>
<option value=4>MOHAMMADPUR - 600</option>
<option value=5>GORAI - 700</option>
<option value=6>KUNDARIA - 800</option>
<option value=7>BENIPUR - 800</option>
<option value=8>BHIKHAMPUR - 800</option>
<option value=9>SAMBHUPUR - 800</option>
<option value=10>HATHI - 800</option>
<option value=11>DASRATHPUR - 800</option>
<option value=12>KARDHANA - 800</option>
<option value=13>BASANTPUR - 800</option>
<option value=14>TARSAW - 800</option>
<option value=15>SAPREHTA - 1000</option>
<option value=16>DILAWALPUR - 1000</option>
</select></td>
</tr>

<input type = "submit" name = "login" id = "login" value = "CONFIRM" />

</fieldset>

</form>

</body>
</html>