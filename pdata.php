
<?php 

require 'include/dbconfig.php';

$pid = $_POST['pid'];
$c = $con->query("select * from orders where id=".$pid."")->fetch_assoc();
$uinfo = $con->query("select * from user where id=".$c['uid']."")->fetch_assoc();


?>

<h5><b>Customer Name :- <?php echo $uinfo['name'];?></b></h5>
<h5><b>Address :- <?php echo $uinfo['hno'].','.$uinfo['society'].','.$uinfo['area'].'-'.$uinfo['pincode'];?></b></h5>
<h5><b>Delivery Date :- <?php echo str_replace('--','',$c['ddate']);?></b></h5>
<h5><b>Delivery Slot :- <?php echo $c['timesloat'];?></b></h5>
<div class="table-responsive">
<table class="table">
<tr>
<th>Sr No.</th>
<th>Prodct Name</th>
<th>Prodct Image</th>
<th>Discount</th>
<th>Prodct Type</th>
<th>Prodct Price</th>
<th>Product Qty</th>
<th>Product Total</th>
</tr>
<?php 
$prid = explode('$;',$c['pid']);
$qty = explode('$;',$c['qty']);
$ptype = explode('$;',$c['ptype']);
$pprice = explode('$;',$c['pprice']);
$pcount = count($qty);

$op = 0;
$subtotal = 0;
	 $ksub = array();
for($i=0;$i<$pcount;$i++)
{
	$op = $op + 1;
$pinfo = $con->query("select * from product where id=".$prid[$i]."")->fetch_assoc();
$discount = $pprice[$i] * $pinfo['discount']*$qty[$i] /100;
	?>
<tr>
<td><?php echo $op;?></td>
<td><?php echo $pinfo['pname'];?></td>
<td><img src="<?php echo $pinfo['pimg'];?>" width="100px"/></td>
<td><?php echo $pinfo['discount'];?></td>
<td><?php echo $ptype[$i];?></td>
<td><?php echo $pprice[$i];?></td>
<td><?php echo $qty[$i];?></td>
<td><?php echo ($pprice[$i] * $qty[$i]) - $discount;?></td>
</tr>
<?php


        $ksub [] = $subtotal  + ($qty[$i] * $pprice[$i]) - $discount;
        
} ?>
</table>
</div>
<ul class="list-group">
  <li class="list-group-item">
    <span class="badge bg-primary float-right budge-own" ><?php echo $c['p_method'];?></span> Payment Method
  </li>
   <li class="list-group-item">
    <span class="badge bg-info float-right budge-own" ><?php echo array_sum($ksub);?></span> Sub Total Price
  </li>
   <li class="list-group-item">
    <span class="badge bg-info float-right budge-own" ><?php echo $c['total'] - array_sum($ksub);?></span>  Delivery Charges
  </li>
  
  <li class="list-group-item">
    <span class="badge bg-info float-right budge-own" ><?php echo $c['total'];?></span> Total Price + Delivery Charges
  </li>
  <li class="list-group-item">
    <span class="badge bg-warning float-right budge-own" ><?php echo $c['status'];?></span> Order Status
  </li>
 
</ul>
