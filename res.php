<?php
ob_start ();
if (isset($_GET["login"]))
{
$conn = mysqli_connect("127.0.0.1","root","","school");
session_start();
$tot=$_SESSION['allTotal'];  //fee of all +previous dues of all
$index=$_SESSION['index'];
$disc=$_GET["disc"];    //overall discount
$eachDisc=$disc/($index+1);     //each person discount
$amtToPay=$tot-$disc;       //amount to be paid after discount
$eachAmtToPay=$amtToPay/($index+1);
$pay=$_GET["pay"];          //paid amout by guardian
$eachPay=$pay/($index+1);
$remark=$_GET["rema"];
$newDues=$amtToPay-$pay;    //new Dues all total;
$eachNewDues=$newDues/($index+1);
for($count=0;$count<=$index;$count++){
$admno[$count]=$_SESSION['admno'.$count];
$en[$count]=$_SESSION['en'.$count];
$st[$count]=$_SESSION['st'.$count];
// $tot2=$tot-$disc;
$class=mysqli_query($conn,"select class from student where admno=$admno[$count]");
//$re=$conn->query("$class");
//$class1;
$r1=$class->fetch_assoc();
$classColumn[$count]=$r1['class'];
//$r5=(float)$r3;
        //echo $r3;
        //echo "<br>";
//echo $class;
//echo "$class";
$name1=mysqli_query($conn,"select studname from student where admno='$admno[$count]'");
while ($row = mysqli_fetch_array($name1)) 
{
    $name[$count] = $row['studname'];  
}
$fname1=mysqli_query($conn,"select fname from student where admno='$admno[$count]'");
while ($row = mysqli_fetch_array($fname1)) 
{
    $fname = $row['fname'];  
}
$addr1=mysqli_query($conn,"select addr from student where admno='$admno[$count]'");
while ($row = mysqli_fetch_array($addr1)) 
{
    $addr = $row['addr'];  
}
$mob1=mysqli_query($conn,"select mob1 from student where admno='$admno[$count]'");
while ($row = mysqli_fetch_array($mob1)) 
{
    $mob = $row['mob1'];  
}
$route1=mysqli_query($conn,"select route from student where admno='$admno[$count]'");
while ($row = mysqli_fetch_array($route1)) 
{
    $route[$count] = $row['route'];  
}
// echo $route[$count];
// $name2=$name1->fetch_assoc();
// $name=(String)$name2;
$fees=mysqli_query($conn,"select fee from fees where class='$classColumn[$count]' and type='TUTION'");
$r2[$count]=$fees->fetch_assoc();
//$r4=(float)$r2['fee'];
$feeCell=$r2[$count];
$eachfee[$count]=$feeCell['fee'];
$qua=mysqli_query($conn,"select fee from fees where class='$classColumn[$count]' and type='EXAM'");
$qua9=$qua->fetch_assoc();
$quarterly[$count]=$qua->fetch_assoc();
$qua1[$count]=$qua9['fee'];
$gam=mysqli_query($conn,"select fee from fees where class='ALL' and type='GAME'");
$gam7=$gam->fetch_assoc();
$gameFee[$count]=$gam->fetch_assoc();
$gam1[$count]=$gam7['fee'];
$ele=mysqli_query($conn,"select fee from fees where class='ALL' and type='ELECTRIC'");
$ele2=$ele->fetch_assoc();
$electricFee[$count]=$gam->fetch_assoc();
$ele1[$count]=$ele2['fee'];
$ana=mysqli_query($conn,"select fee from fees where class='ALL' and type='ANNUAL'");
$ana2=$ana->fetch_assoc();
$ana1[$count]=$ana2['fee'];
$adf=mysqli_query($conn,"select fee from fees where class='ALL' and type='ADMISSION'");
$adf1=$adf->fetch_assoc();
$adf1=$adf1['fee'];
$ssf=mysqli_query($conn,"select fee from fees where class='ALL' and type='SESSION'");
$ssf1=$ssf->fetch_assoc();
$ssf1=$ssf1['fee'];
$k1[$count]=(int)(($admno[$count])/100);
$d1[$count]=date("y");
$tranf=mysqli_query($conn,"select rfee from transport where route='$route[$count]'");
// $tranf5[$count]=$tranf->fetch_assoc();
$tranf6=$tranf->fetch_assoc();
$tranf1[$count]=$tranf6['rfee'];
// echo $tranf1[$count];
$mon[$count]=$en[$count]-$st[$count];
$f1[$count]=$eachfee[$count]*$mon[$count];
$tranf2[$count]=$tranf1[$count]*$mon[$count];
        // echo $mon;
        // echo "<br>";
$paid=mysqli_query($conn,"select paid_amt from student where admno=$admno[$count]");
$r3=$paid->fetch_assoc();
$sql0="update student set discount=$eachDisc+discount where admno='$admno[$count]'";
if(mysqli_query($conn,$sql0)){

}
$sql="update student set remark='$remark' where admno='$admno[$count]'";
if(mysqli_query($conn,$sql)){

}
$sql1="update student set paid_amt='$eachPay'+paid_amt where admno='$admno[$count]'";
if(mysqli_query($conn,$sql1)){

}
$sql2="update student set paid_upto='$en[$count]' where admno='$admno[$count]'";
if(mysqli_query($conn,$sql2)){

}
$total1=$eachfee[$count]*$mon[$count];

$due=mysqli_query($conn,"select dues from student where admno='$admno[$count]'");
$due1=$due->fetch_assoc();
// $dueCell=$due1[$count];
$dueEach[$count]=$due1['dues'];
// $tot1=$tot+$dueEach;
// $tot3=$tot2+$due1;  //previous dues+fee after dues
// $dues=$tot3-$pay;
$sql2="update student set dues='$eachNewDues' where admno='$admno[$count]'";
if(mysqli_query($conn,$sql2)){

}
$class=mysqli_query($conn,"select class from student where admno=$admno[$count]");
$class1='';
while($row=mysqli_fetch_array($class))
{
    $class1[$count]=$row['class'];
}
}
$Date1=date("Y-m-d");
$a1="";
for($i=0;$i<=$index;$i++){
$a1[$i]=strval($admno[$i]);
}
$a2=strval($pay);

$rn=mysqli_query($conn,"select rec from reciept where year=2020");
$rn1=$rn->fetch_assoc();
$rn1=$rn1['rec'];
//$rn2=0;
$rn1+=1;
$sql5="update reciept set rec='$rn1' where year=2020";
if(mysqli_query($conn,$sql5)){

}

if(!file_exists("F:\school\SCHOOL\Student fee details 2019-20\Daily Fee Deposit\\$Date1.txt")){
    $q11="update fee_coll set amt=$pay where comment=1";
    if(mysqli_query($conn,$q11)){

    }
    $a4=strval($pay);
    $a3=$a1.','.$name.','.$a2.', '.$a4.' ;'.PHP_EOL;
    $myfile=fopen("F:\school\SCHOOL\Student fee details 2019-20\Daily Fee Deposit\\$Date1.txt","a+");

    fwrite($myfile,$a3);
    fclose($myfile);
}
else{
    $t10=mysqli_query($conn,"select amt from fee_coll where comment=1");
    $t11=$t10->fetch_assoc();
    $t11=$t11['amt'];
    $t11=$pay+$t11;
    $q12="update fee_coll set amt=$t11 where comment=1";
    if(mysqli_query($conn,$q12)){

    }
    $a4=strval($t11);
    $myfile=fopen("F:\school\SCHOOL\Student fee details 2019-20\Daily Fee Deposit\\$Date1.txt","a+");
    for($i=0;$i<=$index;$i++){
        $a3=$a1[$i].','.$name[$i].' ;'.PHP_EOL;
    
       fwrite($myfile,$a3);
    }
    $a5='paid in total '.$a4.PHP_EOL;
    fwrite($myfile,$a5);
    fclose($myfile);
}
$month=date("F");
if (!file_exists("F:\school\SCHOOL\Student fee details 2019-20\\{$month}\\{$Date1}")) {
mkdir("F:\school\SCHOOL\Student fee details 2019-20\\{$month}\\{$Date1}",700,true);
}
$dir="F:\school\SCHOOL\Student fee details 2019-20\\{$month}\\{$Date1}";
$allAdmNo="";
for($i=0;$i<=$index;$i++){
    $allAdmNo.=$admno[$i].',';
    // $allAdmno.=',';
}
$fileNl=$dir."\\".$allAdmNo.".pdf";

        //echo $total;
require('fpdf181/fpdf.php');

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
$img1="F:\school\SCHOOL\logo.jpg";
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

$last = 100; // This is fetched from database
$last++;
$invoice_number = sprintf('%07d', $last);

$pdf->Cell(130 ,5,'Mob. 9795278925',0,0);
$pdf->Cell(25 ,5,'Invoice #',0,0);
$pdf->Cell(34 ,5,$rn1,0,1);//end of line

$pdf->Cell(130 ,5,'Mail ID mpsvns1995@gmail.com',0,0);
$pdf->Cell(25 ,5,'Student ID',0,0);

$pdf->Cell(34 ,5,$allAdmNo,0,1);//end of line

//make a dummy empty cell as a vertical spacer
$pdf->Cell(189 ,10,'',0,1);//end of line

//billing address
$pdf->Cell(100 ,5,'Bill to',0,1);//end of line

//add dummy cell at beginning of each line for indentation
$pdf->Cell(10 ,5,'',0,0);
for($i=0;$i<=$index;$i++){
$pdf->Cell(90 ,5,$name[$i],0,1);
}

$pdf->Cell(10 ,5,'',0,0);
$pdf->Cell(90 ,5,'S/O '.$fname,0,1);

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
if($k1[$i]==$d1[$i]){
    $pdf->Cell(100 ,5,'Admission Fees',1,0);
    $pdf->Cell(25 ,5,strval($adf1),1,0);
    $pdf->Cell(25 ,5,'-',1,0);
    $pdf->Cell(39 ,5,strval($adf1),1,1,'R');
    // $t1=$t1+$adf1[$i];
}
else{
    $sessionFee=$ssf1;
    $sessFee=strval($sessionFee);
    $pdf->Cell(100 ,5,'Session Fees',1,0);
    $pdf->Cell(25 ,5,$sessFee,1,0);
    $pdf->Cell(25 ,5,'-',1,0);
    $pdf->Cell(39 ,5,$sessFee,1,1,'R');
    // $t1=$t1+$ssf1;
}
// echo $eachfee[$i];
// $tutFee=$r2[$i];
// $tF=strval();
$monTot=$mon[$i];
$monTotal=strval($monTot);
$FeeTot=$f1[$i];
$feeTotal=strval($FeeTot);
$pdf->Cell(100 ,5,'Tuition Fees',1,0);
$pdf->Cell(25 ,5,$eachfee[$i],1,0);
$pdf->Cell(25 ,5,$monTotal,1,0);
$pdf->Cell(39 ,5,$feeTotal,1,1,'R');//end of line
// $t1+=$f1;
// //$examt=$f1;
// $examt=0;
if(($st[$i]<=4) && ($en[$i]>=5)){
$pdf->Cell(100 ,5,'Quarterly Exam Fee',1,0);
// echo $qua1[0];
$pdf->Cell(25 ,5,$qua1[$i],1,0);
$pdf->Cell(25 ,5,'-',1,0);
// $examt=$examt+$qua1;
$pdf->Cell(39 ,5,$qua1[$i],1,1,'R');//end of line
}
if(($st[$i]<=7) && ($en[$i]>=8)){
$pdf->Cell(100 ,5,'Halfyearly Exam Fee',1,0);
$pdf->Cell(25 ,5,$qua1[$i],1,0);
$pdf->Cell(25 ,5,'-',1,0);
// $examt=$examt+$qua1;
$pdf->Cell(39 ,5,$qua1[$i],1,1,'R');
}
if(($st[$i]<=10) && ($en[$i]>=11)){
$pdf->Cell(100 ,5,'Annual Exam Fee',1,0);
$pdf->Cell(25 ,5,$qua1[$i],1,0);
$pdf->Cell(25 ,5,'-',1,0);
// $examt=$examt+$qua1;
$pdf->Cell(39 ,5,$qua1[$i],1,1,'R');
//$t1=$t1+$examt;
}

// $t1+=$examt;
if(($st[$i]<=5) && ($en[$i]>=6)){
$pdf->Cell(100 ,5,'Game Fee',1,0);
$pdf->Cell(25 ,5,$gam1[$i],1,0);
$pdf->Cell(25 ,5,'-',1,0);
$pdf->Cell(39 ,5,$gam1[$i],1,1,'R');//end of line
// $t1=$t1+$gam1;
}

if(($st[$i]<=6) && ($en[$i]>=7)){
$pdf->Cell(100 ,5,'Electric Fee',1,0);
$pdf->Cell(25 ,5,$ele1[$i],1,0);
$pdf->Cell(25 ,5,'-',1,0);
$pdf->Cell(39 ,5,$ele1[$i],1,1,'R');//end of line
// $t1=$t1+$ele1;
}

if(($st[$i]<8) && ($en[$i]>=9)){
$pdf->Cell(100 ,5,'Annual Function',1,0);
$pdf->Cell(25 ,5,$ana1[$i],1,0);
$pdf->Cell(25 ,5,'-',1,0);
$pdf->Cell(39 ,5,$ana1[$i],1,1,'R');//end of line
// $t1=$t1+$ana1;
}

$pdf->Cell(100 ,5,'Transport Fee',1,0);
$pdf->Cell(25 ,5,$tranf1[$i],1,0);
$pdf->Cell(25 ,5,$mon[$i],1,0);
$pdf->Cell(39 ,5,$tranf2[$i],1,1,'R');
// $t1+=$tranf2;

$pdf->Cell(122 ,5,'',0,0);
$pdf->Cell(25 ,5,'Prev. Dues',0,0);
$pdf->Cell(8 ,5,'Rs',1,0);
$pdf->Cell(34 ,5,$dueEach[$i],1,1,'R');
}

$pdf->Cell(122 ,5,'',0,0);
$pdf->Cell(25 ,5,'Total',0,0);
$pdf->Cell(8 ,5,'Rs',1,0);
$pdf->Cell(34 ,5,$tot,1,1,'R');//end of line

$pdf->Cell(122 ,5,'',0,0);
$pdf->Cell(25 ,5,'Discount',0,0);
$pdf->Cell(8 ,5,'Rs',1,0);
$pdf->Cell(34 ,5,$disc,1,1,'R');//end of line

$pdf->Cell(122 ,5,'',0,0);
$pdf->Cell(25 ,5,'Fee after Concession',0,0);
$pdf->Cell(8 ,5,'Rs',1,0);
$pdf->Cell(34 ,5,$amtToPay,1,1,'R');//end of line

$pdf->Cell(122 ,5,'',0,0);
$pdf->Cell(25 ,5,'Subtotal',0,0);
$pdf->Cell(8 ,5,'Rs',1,0);
$pdf->Cell(34 ,5,$amtToPay,1,1,'R');
//
$pdf->Cell(122 ,5,'',0,0);
$pdf->Cell(25 ,5,'Paid',0,0);
$pdf->Cell(8 ,5,'Rs',1,0);
$pdf->Cell(34 ,5,$pay,1,1,'R');

$pdf->Cell(122 ,5,'',0,0);
$pdf->Cell(25 ,5,'Total Due',0,0);
$pdf->Cell(8 ,5,'Rs',1,0);
$pdf->Cell(34 ,5,$newDues,1,1,'R');//end of line
$pdf->Cell(130 ,5,'Remarks:    '.$remark,0,0);
//$pdf->Cell(59 ,5,$rema,0,0);
$pdf->Output($fileNl,'F');
$pdf->Output();

}
ob_end_flush();
?>