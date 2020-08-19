<?php 
require 'db.php';
$data = json_decode(file_get_contents('php://input'), true);
$main = array();
if($data['uid'] == '' or $data['count'] == '')
{
    $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");
}
else
{
    $uid = strip_tags(mysqli_real_escape_string($con,$data['uid']));
    $count = strip_tags(mysqli_real_escape_string($con,$data['count']));
     date_default_timezone_set('Asia/Kolkata');
        $timestamp = date("Y-m-d");
    $check = mysqli_num_rows(mysqli_query($con,"select * from uread where uid=".$uid." and date='".$timestamp."'"));
    if($check !=0)
    {
        mysqli_query($con,"update uread set counts = counts + ".$count." where uid=".$uid." and date='".$timestamp."'");
    }
    else 
    {
        mysqli_query($con,"insert into uread(`uid`,`counts`,`date`)values(".$uid.",".$count.",'".$timestamp."')");
    }
    $returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"count updated!!");
}
echo json_encode($returnArr);
?>