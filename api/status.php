<?php 
require 'db.php';
$data = json_decode(file_get_contents('php://input'), true);
$main = array();
if($data['uid'] == '')
{
    $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");
}
else
{
    date_default_timezone_set('Asia/Kolkata');
        $timestamp = date("Y-m-d");
    $uid = strip_tags(mysqli_real_escape_string($con,$data['uid']));
$count = mysqli_num_rows(mysqli_query($con,"select * from orders where uid=".$uid." and status='completed' and rate = 0 "));
$fetch = mysqli_fetch_assoc(mysqli_query($con,"select * from uread where uid=".$uid." and date='".$timestamp."'"));

if($fetch['counts'] == '')
{
$c = 0;
}
else
{
$c = $fetch['counts'];
}
 
$totalnoti = mysqli_num_rows(mysqli_query($con,"select * from noti where date='".$timestamp."'"));
$finalcount = $totalnoti - $c;

if($count != 0)
{
$fetch = mysqli_fetch_assoc(mysqli_query($con,"select * from orders where uid=".$uid." and status='completed' and rate = 0 order by id limit 1"));
$returnArr = array("orderid"=>$fetch['oid'],"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Rate Pending!","count"=>$finalcount);
}
else 
{
    $returnArr = array("orderid"=>"0","ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"No Pending Rate!!","count"=>$finalcount);
}
}
echo json_encode($returnArr);
?>