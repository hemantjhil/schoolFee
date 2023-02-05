

<?php
//echo "YES";
ob_start ();
error_reporting(E_ALL);
// ini_set('display_errors', '1');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
if (isset($_GET["login"]))
{
$dbusername = "id18479409_hemantjhil";
$dbpassword = "Manoj1234567@";
$dbname = "id18479409_modernjhabra";
$dbhost = "localhost";
session_start();
$tot=$_GET['allTotal'];  //fee of all +previous dues of all
$index=$_GET['index'];
$disc=$_GET["disc"];    //overall discount
$route = [];
$conn = mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname);

// echo "total: ".$tot;
// echo "index: ".$index;
//echo "disc: ".$disc;
$eachDisc=$disc/($index+1);     //each person discount
$amtToPay=$tot-$disc;       //amount to be paid after discount
$eachAmtToPay=$amtToPay/($index+1);
$pay=$_GET["paid"];          //paid amout by guardian
$eachPay=$pay/($index+1);
$remark=$_GET["remarks"];
$newDues=$amtToPay-$pay;    //new Dues all total;

//unique identifer
$uniqueKey= $tot.''.$index.''.$disc.''.$pay.''.$remark;

$eachNewDues=$newDues/($index+1);
$route=[];

for($count=0;$count<=$index;$count++){
    //echo "yes";
$admno[$count]=$_GET['admno'.$count];
$en[$count]=$_GET['en'.$count];
$st[$count]=$_GET['st'.$count];
//fetching start month of each student
$year = date("m") < 4 ? date("Y") - 1 : date("Y");
$studentSession = "student_" . $year;
// $paidUptoQuery = "select paid_upto from $studentSession where admno='$admno[$count]'";
// $startMonth = mysqli_query($conn, $paidUptoQuery);
// $startMon = $startMonth->fetch_assoc();
// $st = $startMon["paid_upto"];
// //echo "st value : ".$st;
// if (is_null($st)) {
//     $st = 4;
// } elseif ($st == 12) {
//     $st = 1;
// } else {
//     $st += 1;
// }

// $tot2=$tot-$disc;
$class=mysqli_query($conn,"select class from $studentSession where admno=$admno[$count]");
//$re=$conn->query("$class");
//$class1;
$r1=$class->fetch_assoc();
$classColumn[$count]=$r1['class'];

$name1=mysqli_query($conn,"select name from student_detail where admno='$admno[$count]'");
while ($row = mysqli_fetch_array($name1)) 
{
    $name[$count] = $row['name'];
}
$fname1=mysqli_query($conn,"select father_name from student_detail where admno='$admno[$count]'");
while ($row = mysqli_fetch_array($fname1)) 
{
    $fname = $row['father_name'];
}
$addr1=mysqli_query($conn,"select address from student_detail where admno='$admno[$count]'");
while ($row = mysqli_fetch_array($addr1)) 
{
    $addr = $row['address'];
}
$mob1=mysqli_query($conn,"select mob1 from student_detail where admno='$admno[$count]'");
while ($row = mysqli_fetch_array($mob1)) 
{
    $mob = $row['mob1'];  
}
$route1=mysqli_query($conn,"select transport_route from $studentSession where admno='$admno[$count]'");
$route[$count] = null;
// echo "count : ".$count;
while ($row = mysqli_fetch_array($route1))
{
    $route[$count] = $row['transport_route'];
    //$route=$route[$count];
}
        // echo $mon;
        // echo "<br>";
$paid=mysqli_query($conn,"select amt_paid from $studentSession where admno=$admno[$count]");
$r3=$paid->fetch_assoc();
//echo $eachDisc;

//check unique value for idempotent handle
$receipts=mysqli_query($conn,"select receipt_no from receipts where unique_id='$uniqueKey'");
$receiptAss=$receipts->fetch_assoc();

//$re=$conn->query("$class");
//$class1;
$due=mysqli_query($conn,"select dues from $studentSession where admno='$admno[$count]'");
$due1=$due->fetch_assoc();
// $dueCell=$due1[$count];
$dueEach[$count]=$due1['dues'];

$isNew = false;
$rn1=null;
// echo $receipts;
if(is_null($receiptAss)){
$isNew=true;
$sql0="update $studentSession set discount=$eachDisc+discount where admno='$admno[$count]'";
if(mysqli_query($conn,$sql0)){

}
$sql="update $studentSession set remark='$remark' where admno='$admno[$count]'";
if(mysqli_query($conn,$sql)){

}
$sql1="update $studentSession set amt_paid=$eachPay+amt_paid where admno='$admno[$count]'";
if(mysqli_query($conn,$sql1)){

}
$sql2="update $studentSession set paid_upto='$en[$count]' where admno='$admno[$count]'";
if(mysqli_query($conn,$sql2)){

}
//$total1=$eachfee[$count]*$mon[$count];

$sql2="update $studentSession set dues='$eachNewDues' where admno='$admno[$count]'";
if(mysqli_query($conn,$sql2)){

}


}else{
    $receiptColumn=$receiptAss['receipt_no'];
    $rn1=$receiptColumn;
}

// $tot1=$tot+$dueEach;
// $tot3=$tot2+$due1;  //previous dues+fee after dues
// $dues=$tot3-$pay;


}

$allAdmNo="";
$allNames="";
for($i=0;$i<=$index;$i++){
    $allAdmNo.=$admno[$i].',';
    // $allAdmno.=',';
    $allNames.=$name[$i].',';
}
//update receipt
if($isNew){
$receiptQuery="select receipt_no from receipt_count where year=2022";
$rn=mysqli_query($conn,$receiptQuery);
//echo $receiptQuery;
$rn1=$rn->fetch_assoc();
$rn1=$rn1['receipt_no'];
//$rn2=0;
$rn1+=1;
$sql5="update receipt_count set receipt_no='$rn1' where year='2022'";
if(mysqli_query($conn,$sql5)){

}
$receiptsQuery="insert into receipts  (receipt_no, amount_paid, comment, unique_id, student_ids, student_names)
VALUES ('$rn1', '$pay', '$remark','$uniqueKey','$allAdmNo','$allNames')";
if(mysqli_query($conn,$receiptsQuery)){

}
}
$Date1=date("Y-m-d");
//$a1="";
//for($i=0;$i<=$index;$i++){
//$a1[$i]=strval($admno[$i]);
//}
$a2=strval($pay);

$month=date("F");
//if (!file_exists("F:\school\SCHOOL\Student fee details 2019-20\\{$month}\\{$Date1}")) {
//mkdir("F:\school\SCHOOL\Student fee details 2019-20\\{$month}\\{$Date1}",700,true);
//}
//$dir="F:\school\SCHOOL\Student fee details 2019-20\\{$month}\\{$Date1}";

$fileNl=$allAdmNo.".pdf";

        //echo $total;

require('fpdf185/fpdf.php');

//A4 width : 219mm
//default margin : 10mm each side
//writable horizontal : 219-(10*2)=189mm

//create pdf object
$pdf = new FPDF('P','mm','A4');
//add new page
$pdf->AddPage();
//output the result
//set font to arial, bold, 14pt
$pdf->SetFont('Arial','B',14);
$img1="school logo blue.png";
//$pdf->imageUniformToFill($img1);
//$pdf->Cell( 100, 40, $pdf->Image($img1, $pdf->GetX(), $pdf->GetY()+5, 33.78), 0, 1 ,'R', false);
$pdf->Image($img1,100,15,35,35);
// $pdf->Image($img1, 0, 0, 0, 0);
//Cell(width , height , text , border , end line , [align] )

$pdf->Cell(130 ,5,'MODERN PUBLIC SCHOOL',0,0);
$pdf->Cell(59 ,5,'INVOICE',0,1);//end of line

//set font to arial, regular, 12pt
$pdf->SetFont('Arial','',12);
$pdf->Cell(130 ,5,'JHABRA DEIPUR JALALPUR JANSA',0,0);
$pdf->Cell(59 ,5,'',0,1);//end of line

$pdf->Cell(130 ,5,'VARANASI INDIA 221405',0,0);

$Date=date("d/m/Y");
$pdf->Cell(25 ,5,'Date',0,0);
$pdf->Cell(34 ,5,$Date,0,1);//end of line

$pdf->Cell(130 ,5,'Mob. 9451093677',0,0);
$pdf->Cell(25 ,5,'Invoice #',0,0);
$pdf->Cell(34 ,5,$rn1,0,1);//end of line

$pdf->Cell(130 ,5,'Mail ID modern@mpsvns.in',0,0);
$pdf->Cell(25 ,5,'Student ID',0,0);

$pdf->Cell(34 ,5,$allAdmNo,0,1);//end of line

//make a dummy empty cell as a vertical spacer
$pdf->Cell(189 ,10,'',0,1);//end of line

//billing address
$pdf->Cell(100 ,5,'Bill to',0,1);//end of line

//add dummy cell at beginning of each line for indentation
$pdf->Cell(10 ,5,'',0,0);
// for($i=0;$i<=$index;$i++){
$pdf->Cell(90 ,5, $allNames,0,1);
// }

$pdf->Cell(10 ,5,'',0,0);
$pdf->Cell(90 ,5,'Parents '.$fname,0,1);

$pdf->Cell(10 ,5,'',0,0);
$pdf->Cell(90 ,5,$addr,0,1);

$pdf->Cell(10 ,5,'',0,0);
$pdf->Cell(90 ,5,$mob,0,1);

//make a dummy empty cell as a vertical spacer
//$pdf->Cell(189 ,10,'',0,1);//end of line

//invoice contents
$pdf->SetFont('Arial','B',12);

$pdf->Cell(100 ,5,'Description',1,0);
$pdf->Cell(25 ,5,'Fees',1,0);
$pdf->Cell(25 ,5,'Months',1,0);
$pdf->Cell(39 ,5,'Amount',1,1);//end of line

$pdf->SetFont('Arial','',12);

// $t1=0;
//Numbers are right-aligned so we give 'R' after new line parameter
for($i=0;$i<=$index;$i++){
$admno=$admno[$i];
$eachEn=$en[$i];
$eachRoute=$route[$i];
$eachDues=$dueEach[$i];
//initalizing total amount 0
$t1 = 0;
$allMonths = [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December"
        ];

$firstTwoDigitOfAdmNo=(int)(($admno)/100);
$sessionStartDigits=fmod($year,100);
$monthIndex = $st[$i];
$pdf->SetFont('Arial','B',12);
$pdf->Cell(100 ,5,$name[$i],1,1);
$pdf->SetFont('Arial','',12);
if ($eachEn > 3)
        {   //when end month is before start of new year
            //echo "Month Index : ".$monthIndex;
            while ($monthIndex <= $eachEn)
            {
                
                runFeeAlgo($monthIndex,$allMonths,$studentSession,$admno,$conn,$eachRoute,$sessionStartDigits,$firstTwoDigitOfAdmNo,$eachEn,$pdf);
                // echo "Month applicable" .$allMonths[$monthIndex - 1];
                // $feeQuery = "select fee,type from fees where class in ('ALL',(select class from $studentSession where
                //     admno=$admno)) and months_applicable in ($monthIndex,'ALL')";
                // //echo $feeQuery;
                // $cumulativeFee = mysqli_query($conn, $feeQuery);
                // // echo "</br>";
                // while ($each = mysqli_fetch_array($cumulativeFee)) {
                //     $feeTitle = $each[1];
                //     $feeValue = $each[0];
                //     if($feeTitle=="ADMISSION FEE"){
                //         if($sessionStartDigits==$firstTwoDigitOfAdmNo){
                //             $pdf->Cell(100 ,5,$feeTitle,1,0);
                //             $pdf->Cell(25 ,5,$feeValue,1,0);
                //             $pdf->Cell(25 ,5,$allMonths[$monthIndex-1],1,0);
                //             $pdf->Cell(39 ,5,$feeValue,1,1,'R');
                //             // echo $feeTitle . " : " . $feeValue;
                //         }
                //     }else{
                //         if($feeTitle=="SESSION FEE"){
                //             if($sessionStartDigits!=$firstTwoDigitOfAdmNo){
                //                 $pdf->Cell(100 ,5,$feeTitle,1,0);
                //                 $pdf->Cell(25 ,5,$feeValue,1,0);
                //                 $pdf->Cell(25 ,5,$allMonths[$monthIndex-1],1,0);
                //                 $pdf->Cell(39 ,5,$feeValue,1,1,'R');
                //                 // echo $feeTitle . " : " . $feeValue;
                //             }
                //         }else{
                //             $pdf->Cell(100 ,5,$feeTitle,1,0);
                //             $pdf->Cell(25 ,5,$feeValue,1,0);
                //             $pdf->Cell(25 ,5,$allMonths[$monthIndex-1],1,0);
                //             $pdf->Cell(39 ,5,$feeValue,1,1,'R');
                //             // echo $feeTitle . " : " . $feeValue;
                //         }
                //     }
                //     // echo "</br>";
                //     $t1 += $feeValue;
                // }
                // if(!is_null($eachRoute)){
                //     $tranf = mysqli_query(
                //                 $conn,
                //                 "select rfee from transport where id='$eachRoute' ");
                //     if(!is_bool($tranf)){
                //         $tranf1 = $tranf->fetch_assoc();
                //         $tranf1 = $tranf1["rfee"];
                //         $tranf2 = $tranf1;
                //         $t1 += $tranf2;
                //         $pdf->Cell(100 ,5,"TRANSPORT FEE ",1,0);
                //         $pdf->Cell(25 ,5,$tranf2,1,0);
                //         $pdf->Cell(25 ,5,$allMonths[$monthIndex-1],1,0);
                //         $pdf->Cell(39 ,5,$tranf2,1,1,'R');
                //         // echo "TRANSPORT FEE: " . $tranf2;
                //         // echo "</br>";
                //     }
                // }
                //echo "</br>";
                $monthIndex++;
            }
        }
else{ //when end month is in start of new year
            if ($monthIndex >= 4)
            { //when start month before new year
                while ($monthIndex <= 12)
                {
                    // 
                    runFeeAlgo($monthIndex,$allMonths,$studentSession,$admno,$conn,$t1,$eachRoute,$sessionStartDigits,$firstTwoDigitOfAdmNo,$eachEn,$pdf);
                    //echo "Month Index : ".$monthIndex;
                    // echo "Month applicable" .$allMonths[$monthIndex - 1];
                    // $feeQuery = "select fee,type from fees where class in ('ALL',(select class from $studentSession where
                    //     admno=$admno)) and months_applicable in ($monthIndex,'ALL')";
                    // //echo $feeQuery;
                    // $cumulativeFee = mysqli_query($conn, $feeQuery);
                    // echo "</br>";
                    // while ($each = mysqli_fetch_array($cumulativeFee)) {
                    //     $feeTitle = $each[1];
                    //     $feeValue = $each[0];
                    //     if($feeTitle=="ADMISSION FEE"){
                    //         if($sessionStartDigits==$firstTwoDigitOfAdmNo){
                    //             $pdf->Cell(100 ,5,$feeTitle,1,0);
                    //             $pdf->Cell(25 ,5,$feeValue,1,0);
                    //             $pdf->Cell(25 ,5,$allMonths[$monthIndex-1],1,0);
                    //             $pdf->Cell(39 ,5,$feeValue,1,1,'R');
                    //             // echo $feeTitle . " : " . $feeValue;
                    //         }
                    //     }else{
                    //         if($feeTitle=="SESSION FEE"){
                    //             if($sessionStartDigits!=$firstTwoDigitOfAdmNo){
                    //                 $pdf->Cell(100 ,5,$feeTitle,1,0);
                    //                 $pdf->Cell(25 ,5,$feeValue,1,0);
                    //                 $pdf->Cell(25 ,5,$allMonths[$monthIndex-1],1,0);
                    //                 $pdf->Cell(39 ,5,$feeValue,1,1,'R');
                    //                 // echo $feeTitle . " : " . $feeValue;
                    //             }
                    //         }else{
                    //             $pdf->Cell(100 ,5,$feeTitle,1,0);
                    //             $pdf->Cell(25 ,5,$feeValue,1,0);
                    //             $pdf->Cell(25 ,5,$allMonths[$monthIndex-1],1,0);
                    //             $pdf->Cell(39 ,5,$feeValue,1,1,'R');
                    //             // echo $feeTitle . " : " . $feeValue;
                    //         }
                    //     }
                    //     echo "</br>";
                    //     $t1 += $feeValue;
                    // }
                    // if(!is_null($eachRoute)){
                    //     $tranf = mysqli_query(
                    //                     $conn,
                    //                     "select rfee from transport where id='$eachRoute'"
                    //                 );
                    //     if(!is_bool($tranf)){
                    //         $tranf1 = $tranf->fetch_assoc();
                    //         $tranf1 = $tranf1["rfee"];
                    //         $tranf2 = $tranf1;
                    //         $t1 += $tranf2;
                    //         $pdf->Cell(100 ,5,"TRANSPORT FEE ",1,0);
                    //         $pdf->Cell(25 ,5,$tranf2,1,0);
                    //         $pdf->Cell(25 ,5,$allMonths[$monthIndex-1],1,0);
                    //         $pdf->Cell(39 ,5,$tranf2,1,1,'R');
                    //         // echo "TRANSPORT FEE: " . $tranf2;
                    //         // echo "</br>";
                    //     }
                    // }
                    //echo "</br>";
                    $monthIndex++;
                }
                $monthIndex = 1;
                while ($monthIndex <= $eachEn)
                {
                    runFeeAlgo($monthIndex,$allMonths,$studentSession,$admno,$conn,$t1,$eachRoute,$sessionStartDigits,$firstTwoDigitOfAdmNo,$eachEn,$pdf);
                    //echo "Month Index : ".$monthIndex;
                    // echo "Month applicable" .$allMonths[$monthIndex - 1];
                    // $feeQuery = "select fee,type from fees where class in ('ALL',(select class from $studentSession where
                    //     admno=$admno)) and months_applicable in ($monthIndex,'ALL')";
                    // //echo $feeQuery;
                    // $cumulativeFee = mysqli_query($conn, $feeQuery);
                    // // echo "</br>";
                    // while ($each = mysqli_fetch_array($cumulativeFee)) {
                    //     $feeTitle = $each[1];
                    //     $feeValue = $each[0];
                    //     if($feeTitle=="ADMISSION FEE"){
                    //         if($sessionStartDigits==$firstTwoDigitOfAdmNo){
                    //                 $pdf->Cell(100 ,5,$feeTitle,1,0);
                    //                 $pdf->Cell(25 ,5,$feeValue,1,0);
                    //                 $pdf->Cell(25 ,5,$allMonths[$monthIndex-1],1,0);
                    //                 $pdf->Cell(39 ,5,$feeValue,1,1,'R');
                    //             // echo $feeTitle . " : " . $feeValue;
                    //         }
                    //     }else{
                    //         if($feeTitle=="SESSION FEE"){
                    //             if($sessionStartDigits!=$firstTwoDigitOfAdmNo){
                    //                 $pdf->Cell(100 ,5,$feeTitle,1,0);
                    //                 $pdf->Cell(25 ,5,$feeValue,1,0);
                    //                 $pdf->Cell(25 ,5,$allMonths[$monthIndex-1],1,0);
                    //                 $pdf->Cell(39 ,5,$feeValue,1,1,'R');
                    //                 // echo $feeTitle . " : " . $feeValue;
                    //             }
                    //         }else{
                    //             $pdf->Cell(100 ,5,$feeTitle,1,0);
                    //             $pdf->Cell(25 ,5,$feeValue,1,0);
                    //             $pdf->Cell(25 ,5,$allMonths[$monthIndex-1],1,0);
                    //             $pdf->Cell(39 ,5,$feeValue,1,1,'R');
                    //             // echo $feeTitle . " : " . $feeValue;
                    //         }
                    //     }
                    //     // echo "</br>";
                    //     $t1 += $feeValue;
                    // }
                    // if(!is_null($eachRoute)){
                    //     $tranf = mysqli_query(
                    //                     $conn,
                    //                     "select rfee from transport where id='$eachRoute'"
                    //                 );
                    //     if(!is_bool($tranf)){
                    //         $tranf1 = $tranf->fetch_assoc();
                    //         $tranf1 = $tranf1["rfee"];
                    //         $tranf2 = $tranf1;
                    //         $t1 += $tranf2;
                    //         $pdf->Cell(100 ,5,"TRANSPORT FEE ",1,0);
                    //         $pdf->Cell(25 ,5,$tranf2,1,0);
                    //         $pdf->Cell(25 ,5,$allMonths[$monthIndex-1],1,0);
                    //         $pdf->Cell(39 ,5,$tranf2,1,1,'R');
                    //         // echo "TRANSPORT FEE: " . $tranf2;
                    //         // echo "</br>";
                    //     }
                    // }
                    //echo "</br>";
                    $monthIndex++;
                }
            } else
            {   //when start month is also in new year
                while ($monthIndex <= $eachEn)
                {
                    runFeeAlgo($monthIndex,$allMonths,$studentSession,$admno,$conn,$t1,$eachRoute,$sessionStartDigits,$firstTwoDigitOfAdmNo,$eachEn,$pdf);
                    //echo "Month Index : ".$monthIndex;
                    // echo "Month applicable" .$allMonths[$monthIndex - 1];
                    // $feeQuery = "select fee,type from fees where class in ('ALL',(select class from $studentSession where
                    //     admno=$admno)) and months_applicable in ($monthIndex,'ALL')";
                    // //echo $feeQuery;
                    // $cumulativeFee = mysqli_query($conn, $feeQuery);
                    // echo "</br>";
                    // while ($each = mysqli_fetch_array($cumulativeFee)) {
                    //     $feeTitle = $each[1];
                    //     $feeValue = $each[0];
                    //     if($feeTitle=="ADMISSION FEE"){
                    //         if($sessionStartDigits==$firstTwoDigitOfAdmNo){
                    //             $pdf->Cell(100 ,5,$feeTitle,1,0);
                    //             $pdf->Cell(25 ,5,$feeValue,1,0);
                    //             $pdf->Cell(25 ,5,$allMonths[$monthIndex-1],1,0);
                    //             $pdf->Cell(39 ,5,$feeValue,1,1,'R');
                    //             // echo $feeTitle . " : " . $feeValue;
                    //         }
                    //     }else{
                    //         if($feeTitle=="SESSION FEE"){
                    //             if($sessionStartDigits!=$firstTwoDigitOfAdmNo){
                    //                 $pdf->Cell(100 ,5,$feeTitle,1,0);
                    //                 $pdf->Cell(25 ,5,$feeValue,1,0);
                    //                 $pdf->Cell(25 ,5,$allMonths[$monthIndex-1],1,0);
                    //                 $pdf->Cell(39 ,5,$feeValue,1,1,'R');
                    //                 // echo $feeTitle . " : " . $feeValue;
                    //             }
                    //         }else{
                    //             $pdf->Cell(100 ,5,$feeTitle,1,0);
                    //             $pdf->Cell(25 ,5,$feeValue,1,0);
                    //             $pdf->Cell(25 ,5,$allMonths[$monthIndex-1],1,0);
                    //             $pdf->Cell(39 ,5,$feeValue,1,1,'R');
                    //             // echo $feeTitle . " : " . $feeValue;
                    //         }
                    //     }
                    //     // echo "</br>";
                    //     $t1 += $feeValue;
                    // }
                    // if(!is_null($eachRoute)){
                    //     $tranf = mysqli_query(
                    //                     $conn,
                    //                     "select rfee from transport where id='$eachRoute'"
                    //                 );
                    //     if(!is_bool($tranf)){
                    //         $tranf1 = $tranf->fetch_assoc();
                    //         $tranf1 = $tranf1["rfee"];
                    //         $tranf2 = $tranf1;
                    //         $t1 += $tranf2;
                    //         $pdf->Cell(100 ,5,"TRANSPORT FEE ",1,0);
                    //         $pdf->Cell(25 ,5,$tranf2,1,0);
                    //         $pdf->Cell(25 ,5,$allMonths[$monthIndex-1],1,0);
                    //         $pdf->Cell(39 ,5,$tranf2,1,1,'R');
                    //         // echo "TRANSPORT FEE: " . $tranf2;
                    //         // echo "</br>";
                    //     }
                    // }
                    //echo "</br>";
                    $monthIndex++;
                }
            }

            // $dueEach[$count]
            # code...

}

            $pdf->Cell(100 ,5,"PREVIOUS DUES ",1,0);
            $pdf->Cell(25 ,5,$eachDues,1,0);
            $pdf->Cell(25 ,5,'-',1,0);
            $pdf->Cell(39 ,5,$eachDues,1,1,'R');




}



$pdf->Cell(122 ,5,'',0,0);
$pdf->Cell(25 ,5,'Total',0,0);
$pdf->Cell(8 ,5,'Rs',1,0);
$pdf->Cell(34 ,5,$tot,1,1,'R');//end of line
if($disc>0){
    $pdf->Cell(122 ,5,'',0,0);
    $pdf->Cell(25 ,5,'Discount',0,0);
    $pdf->Cell(8 ,5,'Rs',1,0);
    $pdf->Cell(34 ,5,$disc,1,1,'R');//end of line

    $pdf->Cell(97 ,5,'',0,0);
    $pdf->Cell(50 ,5,'Fee after Concession',0,0);
    $pdf->Cell(8 ,5,'Rs',1,0);
    $pdf->Cell(34 ,5,$amtToPay,1,1,'R');//end of line
}
$pdf->Cell(122 ,5,'',0,0);
$pdf->Cell(25 ,5,'Subtotal',0,0);
$pdf->Cell(8 ,5,'Rs',1,0);
$pdf->Cell(34 ,5,$amtToPay,1,1,'R');
//
$pdf->Cell(122 ,5,'',0,0);
$pdf->Cell(25 ,5,'Paid',0,0);
$pdf->Cell(8 ,5,'Rs',1,0);
$pdf->Cell(34 ,5,$pay,1,1,'R');
if($newDues>0){
$pdf->Cell(118 ,5,'',0,0);
$pdf->Cell(29 ,5,'Current Dues',0,0);
$pdf->Cell(8 ,5,'Rs',1,0);
$pdf->Cell(34 ,5,$newDues,1,1,'R');//end of line
}


$pdf->Cell(130 ,5,'Remarks:    '.$remark,0,0);
//$pdf->Cell(59 ,5,$rema,0,0);





$pdf->Output();

}

function runFeeAlgo($monthIndex,$allMonths,$studentSession,$admno,$conn,$eachRoute,$sessionStartDigits,$firstTwoDigitOfAdmNo,$eachEn,$pdf){
    $t3=0;
    // echo "Month applicable" .$allMonths[$monthIndex - 1];
                    $feeQuery = "select fee,type from fees where class in ('ALL',(select class from $studentSession where
                        admno=$admno)) and months_applicable in ($monthIndex,'ALL')";
                    //echo $feeQuery;
                    $cumulativeFee = mysqli_query($conn, $feeQuery);
                    // echo "</br>";
                    while ($each = mysqli_fetch_array($cumulativeFee)) {
                        $feeTitle = $each[1];
                        $feeValue = $each[0];
                        if($feeTitle=="ADMISSION FEE"){
                            if($sessionStartDigits==$firstTwoDigitOfAdmNo){
                                $pdf->Cell(100 ,5,$feeTitle,1,0);
                                $pdf->Cell(25 ,5,$feeValue,1,0);
                                $pdf->Cell(25 ,5,$allMonths[$monthIndex-1],1,0);
                                $pdf->Cell(39 ,5,$feeValue,1,1,'R');
                                // echo $feeTitle . " : " . $feeValue;
                            }
                        }else if($feeTitle=="SESSION FEE"){
                                if($sessionStartDigits!=$firstTwoDigitOfAdmNo){
                                    $pdf->Cell(100 ,5,$feeTitle,1,0);
                                    $pdf->Cell(25 ,5,$feeValue,1,0);
                                    $pdf->Cell(25 ,5,$allMonths[$monthIndex-1],1,0);
                                    $pdf->Cell(39 ,5,$feeValue,1,1,'R');
                                    // echo $feeTitle . " : " . $feeValue;
                                }
                        }else{
                                $pdf->Cell(100 ,5,$feeTitle,1,0);
                                $pdf->Cell(25 ,5,$feeValue,1,0);
                                $pdf->Cell(25 ,5,$allMonths[$monthIndex-1],1,0);
                                $pdf->Cell(39 ,5,$feeValue,1,1,'R');
                                // echo $feeTitle . " : " . $feeValue;
                            }
                        // echo "</br>";
                        // $t1 += $feeValue;
                    }
                    if(!is_null($eachRoute)){
                        $tranf = mysqli_query(
                                        $conn,
                                        "select rfee from transport where id='$eachRoute'"
                                    );
                        if(!is_bool($tranf)){
                            $tranf1 = $tranf->fetch_assoc();
                            $tranf1 = $tranf1["rfee"];
                            $tranf2 = $tranf1;
                            $t1 += $tranf2;
                            $pdf->Cell(100 ,5,"TRANSPORT FEE ",1,0);
                            $pdf->Cell(25 ,5,$tranf2,1,0);
                            $pdf->Cell(25 ,5,$allMonths[$monthIndex-1],1,0);
                            $pdf->Cell(39 ,5,$tranf2,1,1,'R');
                            // echo "TRANSPORT FEE: " . $tranf2;
                            // echo "</br>";
                        }
                    }
                    //echo "</br>";
                    // $monthIndex++;
}
ob_end_flush();
?>