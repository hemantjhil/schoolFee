<!DOCTYPE html>
<html>
<title>School Fee Portal</title>
<head>
	<!-- <script type="text/javascript" src="add_Student.js"></script> -->
	</head>
<body>
	<form action="" method="get">
<div id="student_fee0">
	<script type="text/javascript" src="add_Student.js"></script>
<fieldset>
	<legend></legend>
	
<tr>
<td>Admission No.</td>
<td><input type="text" name="admno0" id="admno0" size="30"></td>
</tr>
<tr>
<td>Upto Month</td>
<td><select name="en0" id="en0">
<option value="-1" selected>select..</option>
<option value=1>April</option>
<option value=2>May</option>
<option value=3>June</option>
<option value=4>July</option>
<option value=5>August</option>
<option value=6>September</option>
<option value=7>October</option>
<option value=8>Novemeber</option>
<option value=9>Decmeber</option>
<option value=10>January</option>
<option value=11>Februrary</option>
<option value=12>March</option>
</select></td>
</tr>
<!-- <input type="integer" name=pay id="pay" size="20"/> -->

</fieldset>
</div>
<div>
<input type="hidden" name=index id="index" value="0">
<input type = "submit" name = "login" value = "CALCULATE"/>
<input type="button" name="add_student" value="ADD STUDENT" onclick="addStudent()">
</div>
</form>
</body>
</html>
<!-- // $count=$_SESSION['index'];
// echo $count;
// echo "greet";
// $admno=$_GET["admno".$count];
// echo $admno;
// // echo $_GET["st"+$count];
// // echo $_GET["en"+$count];
// echo "great";
 -->
 
	<!DOCTYPE html>
	<html>
	<head>
		<title></title>
	<script type="text/javascript" src="add_Student.js"></script>

	</head>
	<body id="tb1">
		<form action="res.php" method="get" id="final0">
			<fieldset>
	<legend></legend>
	Fees Paid:
	<input type="integer" name="pay" id="pay" size="20"/>
	Discount:
	<input type="integer" name="disc" id="disc" size="20"/>
	<br/>
	<br/>
	<br/>
	Remarks :
	<input type="varchar" name="rema" id="rema" size="100"/>
	<br/>
	<br/>

	
	
	</body>
	</html>
		<br/>
		<div id="count"></div>
	Confirm:
	<input type = "submit" name = "login" value = "CONFIRM"/>
	<br/>
	</fieldset>
</form>

<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    echo "hi";
}
$index=$_GET["index"];
$allTotal=0;
$dbusername="id18479409_hemantjhil";
$dbpassword="Manoj1234567@";
$dbname="id18479409_modernjhabra";
$dbhost="localhost";
$year = ( date('m') < 4 ) ? date('Y') - 1 : date('Y');
$studentSession='student_'.$year;
for($count=0;$count<=$index;$count++){
if(isset($_GET["admno".$count], $_GET["en".$count])){
echo "Fees Details:   ";
	echo "<br>";
$conn = mysqli_connect($dbhost,$dbusername,$dbpassword,$dbname);

// $counter=$_SESSION['count'];
// for($i=0;$i<=$counter;$i++){
echo $count;
echo "<br>";
$admno=$_GET["admno".$count];
$_SESSION['admno'.$count]=$admno;
$en=$_GET['en'.$count];
$_SESSION['en'.$count]=$en;
$allMonths=["January","February","March","April","May","June","July","August","September","October","November","December"];
$startMonth=mysqli_query($conn,"select paid_upto from $studentSession where admno=$admno");
//$re=$conn->query("$class");
$startMon=$startMonth->fetch_assoc();
$st=$startMon['paid_upto'];
// $st=$_GET['st'.$count];
$_SESSION['st'.$count]=$st;
$mon=$en-$st;
echo "Total Months:   ";
echo $mon;
echo "<br>";
echo "Starting Month:     ";
if($st==12){
	$st=0;
}else{
	$st+=1;
}
echo $allMonths[$st];
echo "<br>";
echo "End Month:     ";
echo $allMonths[$en];
$admno=$_GET["admno".$count];
echo "<br>";
$class=mysqli_query($conn,"select class from $studentSession where admno=$admno");
//$re=$conn->query("$class");
$r1=$class->fetch_assoc();
$r3=$r1['class'];
echo "Class:   ".$r3;
echo "<br>";

$monthIndex=$st;
if($en>3){ 				//when end month is before start of new year
	while($monthIndex<=$en){
		$cumulativeFee=mysqli_query($conn,"select fee,type from fees where class in ('ALL',$r3) and months_applicable=$monthIndex");
		$cumulativeFeeValue=$cumulativeFee->fetch_assoc();
		for($cumulativeFeeValue as $each){
			$feeTitle=$each['title'];
			$feeValue=$each['fee'];
			echo "Month applicable".$allMonths[$monthIndex-1];
			echo $feeTitle." : ".$feeValue;
			$t1+=$feevalue;
		}
		$monthIndex++;
	}
}
else {				//when end month is in start of new year
	if($monthIndex>=4){				//when start month before new year
		while($index<=12){
			$cumulativeFee=mysqli_query($conn,"select fee,type from fees where class in ('ALL',$r3) and months_applicable=$monthIndex");
			$cumulativeFeeValue=$cumulativeFee->fetch_assoc();
			for($cumulativeFeeValue as $each){
				$feeTitle=$each['title'];
				$feeValue=$each['fee'];
				echo "Month applicable".$allMonths[$monthIndex-1];
				echo $feeTitle." : ".$feeValue;
				$t1+=$feevalue;
			}
			$monthIndex++;
		}
		$index=0;
		while($monthIndex<=$en){
			$cumulativeFee=mysqli_query($conn,"select fee,type from fees where class in ('ALL',$r3) and months_applicable=$monthIndex");
			$cumulativeFeeValue=$cumulativeFee->fetch_assoc();
			for($cumulativeFeeValue as $each){
				$feeTitle=$each['title'];
				$feeValue=$each['fee'];
				echo "Month applicable".$allMonths[$monthIndex-1];
				echo $feeTitle." : ".$feeValue;
				$t1+=$feevalue;
			}
			$monthIndex++;
		}
	}
	else{								//when start month is also in new year
		while($monthIndex<=$en){
				$cumulativeFee=mysqli_query($conn,"select fee,type from fees where class in ('ALL',$r3) and months_applicable=$monthIndex");
				$cumulativeFeeValue=$cumulativeFee->fetch_assoc();
				for($cumulativeFeeValue as $each){
					$feeTitle=$each['title'];
					$feeValue=$each['fee'];
					echo "Month applicable".$allMonths[$monthIndex-1];
					echo $feeTitle." : ".$feeValue;
					$t1+=$feevalue;
				}
				$monthIndex++;
			}
		}
	# code...
}
$route1=mysqli_query($conn,"select route from $studentSession where admno='$admno'");
while ($row = mysqli_fetch_array($route1))
{
    $route = $row['route'];
}
$tranf=mysqli_query($conn,"select rfee from transport where route='$route'");
$tranf1=$tranf->fetch_assoc();
$tranf1=$tranf1['rfee'];
$tranf2=$tranf1*$mon;
echo "Transport Fee: ".$tranf2;
echo "<br>";
$t1+=$tranf2;

$due=mysqli_query($conn,"select dues from $studentSession where admno='$admno'");
$due1=$due->fetch_assoc();
$due1=$due1['dues'];
$t2=$t1+$due1;
echo "Previous Dues:  ".$due1;
echo "<br>";
echo "Total Fee: ".$t2;
$tot[$count]=$t2;
$allTotal+=$tot[$count];
$_SESSION['tot']=$tot[$count];
echo "<br>";
echo "<br>";echo "<br>";echo "<br>";echo "<br>";  
}
$_SESSION['allTotal']=$allTotal;
echo $allTotal;
echo "<br>";echo "<br>";
$_SESSION['index']=$index;
}

// }
?>