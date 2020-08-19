<?php 
require 'db.php';
header('Content-type: text/json');
$data = json_decode(file_get_contents('php://input'), true);

$uid = $data['uid'];
if ($uid =='')
{
$returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went wrong  try again !");
}
else 
{
$c = $con->query("select * from user where id='".$uid."'");
            $c = $c->fetch_assoc();
            $dc = $con->query("select * from area_db where name='".$c['area']."'");
			if($dc->num_rows != 0)
			{
            $dc = $dc->fetch_assoc();
        $returnArr = array("user"=>$c,"d_charge"=>$dc['dcharge'],"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Profile Get successfully!");
			}
			else 
			{
				$dc = $dc->fetch_assoc();
        $returnArr = array("user"=>$c,"d_charge"=>$dc['dcharge'],"ResponseCode"=>"200","Result"=>"false","ResponseMsg"=>"Please Update Your Area Name.Because It's Not match with Our Delivery Location!!");
			}
}
echo json_encode($returnArr);
?>