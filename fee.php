<html>
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
<td>From Month</td>
<td><select name="st0" id="st0">
<option value="-1" selected>select..</option>
<option value=0>April</option>
<option value=1>May</option>
<option value=2>June</option>
<option value=3>July</option>
<option value=4>August</option>
<option value=5>September</option>
<option value=6>October</option>
<option value=7>Novemeber</option>
<option value=8>Decmeber</option>
<option value=9>January</option>
<option value=10>Februrary</option>
<option value=11>March</option>
</select></td>
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
for($count=0;$count<=$index;$count++){
if(isset($_GET["admno".$count], $_GET["st".$count], $_GET["en".$count])){
echo "Fees Details:   ";
	echo "<br>";
$conn = mysqli_connect("127.0.0.1","root","","school");

// $counter=$_SESSION['count'];
// for($i=0;$i<=$counter;$i++){
echo $count;
echo "<br>";
$admno=$_GET["admno".$count];
$_SESSION['admno'.$count]=$admno;
$en=$_GET['en'.$count];
$_SESSION['en'.$count]=$en;
$startMonth=mysqli_query($conn,"select paid_upto from student where admno=$admno");
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
if($st=="0"){
	echo "April";
}
else if($st=='1'){
	echo "May";
}
else if($st=='2'){
	echo "June";
}
else if($st=="3"){
	echo "July";
}
else if($st=="4"){
	echo "August";
}
else if($st=="5"){
	echo "September";
}
else if($st=="6"){
	echo "October";
}
else if($st=="7"){
	echo "November";
}
else if($st=="8"){
	echo "December";
}
else if($st=="9"){
	echo "January";
}
else if($st=="10"){
	echo "February";
}
else if($st=="11"){
	echo "March";
}
echo "<br>";
echo "End Month:     ";
if($en=="1"){
	echo "April";
}
else if($en=='2'){
	echo "May";
}
else if($en=='3'){
	echo "June";
}
else if($en=="4"){
	echo "July";
}
else if($en=="5"){
	echo "August";
}
else if($en=="6"){
	echo "September";
}
else if($en=="7"){
	echo "October";
}
else if($en=="8"){
	echo "November";
}
else if($en=="9"){
	echo "December";
}
else if($en=="10"){
	echo "January";
}
else if($en=="11"){
	echo "February";
}
else if($en=="12"){
	echo "March";
}
$admno=$_GET["admno".$count];
echo "<br>";
$class=mysqli_query($conn,"select class from student where admno=$admno");
//$re=$conn->query("$class");
$r1=$class->fetch_assoc();
$r3=$r1['class'];
echo "Class:   ".$r3;
echo "<br>";

$adf=mysqli_query($conn,"select fee from fees where class='ALL' and type='ADMISSION'");
$adf1=$adf->fetch_assoc();
$adf1=$adf1['fee'];
$k1=(int)($admno/100);
$d1=date("y");
$ssf=mysqli_query($conn,"select fee from fees where class='ALL' and type='SESSION'");
$ssf1=$ssf->fetch_assoc();
$ssf1=$ssf1['fee'];
$t1=0;
if($k1==$d1){
	if(($st<=0) && ($en>=1)){
		echo "Admission Fee: ".$adf1;
		$t1+=$adf1;
		echo "<br>";
	}
	}
else{
	if(($st<=3) && ($en>=4)){
		echo "Session Fee: ".$ssf1;
		$t1+=$ssf1;
		echo "<br>";
	}
}

$fees=mysqli_query($conn,"select fee from fees where class='$r3' and type='TUTION'");
$r2=$fees->fetch_assoc();
//$r4=(float)$r2['fee'];
$r2=$r2['fee'];
$f1=$r2*$mon;
echo "Tution Fee:   ".$f1;
echo "<br>";

$t1+=$f1;
$qua=mysqli_query($conn,"select fee from fees where class='$r3' and type='EXAM'");
$qua1=$qua->fetch_assoc();
$qua1=$qua1['fee'];
if(($st<=10) && ($en>=11)){
echo "Exam Fee: ". 3*$qua1;
$t1+=3*$qua1;
echo "<br>";
}
else if(($st<=7) && ($en>=8)){
echo "Exam Fee: ". 2*$qua1;
$t1+=2*$qua1;
echo "<br>";
}
else if(($st<=4) && ($en>=5)){
echo "Exam Fee :".$qua1;
$t1+=$qua1;
echo "<br>";
}
if(($st<=5) && ($en>=6)){
$gam=mysqli_query($conn,"select fee from fees where class='ALL' and type='GAME'");
$gam1=$gam->fetch_assoc();
$gam1=$gam1['fee'];
echo "Game Fee: ". $gam1;
$t1+=$gam1;
echo "<br>";	
}

if(($st<=6) && ($en>=7)){
$ele=mysqli_query($conn,"select fee from fees where class='ALL' and type='ELECTRIC'");
$ele1=$ele->fetch_assoc();
$ele1=$ele1['fee'];
echo "Electric Fee: ".$ele1;
$t1+=$ele1;
echo "<br>";
} 

if(($st<8) && ($en>=9)){
$ana=mysqli_query($conn,"select fee from fees where class='ALL' and type='ANNUAL'");
$ana1=$ana->fetch_assoc();
$ana1=$ana1['fee'];
echo "Annual Function: ".$ana1;
$t1+=$ana1;
echo "<br/>";
	}
$route1=mysqli_query($conn,"select route from student where admno='$admno'");
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

$due=mysqli_query($conn,"select dues from student where admno='$admno'");
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