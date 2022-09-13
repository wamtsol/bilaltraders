<?php
if(!defined("APP_START")) die("No Direct Access");
$extra='';
if(isset($_SESSION["purchase"]["list"]["date_from"]) && !empty($_SESSION["purchase"]["list"]["date_from"])){
	$date_from=$_SESSION["purchase"]["list"]["date_from"];
	$extra.=" and datetime_added>='".datetime_dbconvert($date_from)."'";
}
if(isset($_SESSION["purchase"]["list"]["date_to"]) && !empty($_SESSION["purchase"]["list"]["date_to"])){
	$date_to=$_SESSION["purchase"]["list"]["date_to"];
	$extra.=" and datetime_added<'".datetime_dbconvert($date_to)."'";
}
if(isset($_SESSION["purchase"]["list"]["q"]) && !empty($_SESSION["purchase"]["list"]["q"])){
	$q=$_SESSION["purchase"]["list"]["q"];
	$extra.=" and supplier_id like '%".$q."%'";
}

$order_by = "supplier_id";
$order = "asc";
if( isset( $_SESSION["purchase"]["list"]["order_by"] ) ){
	$order_by = $_SESSION["purchase"]["list"]["order_by"];
}
if( isset( $_SESSION["purchase"]["list"]["order"] ) ){
	$order = $_SESSION["purchase"]["list"]["order"];
}
$orderby = $order_by." ".$order;
//if(isset($_GET["id"]) && !empty($_GET["id"])){
	$sales=doquery("select * from purchase where 1 $extra order by $orderby", $dblink);
	$total_items = $total_price = $discount = $net_price = 0;
	
	?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Sales List</title>
<style>
body{
	font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
}
.print-list{
}
.print-list h3{
	font-size:20px;
	text-transform:uppercase;
	text-align:center;
	margin: 10px 0 0;
}
.print-list p{
	font-size:16px;
	text-align:center;
	margin: 10px 0 10px;
}
.print-list table{
	width:100%;
	border-collapse: collapse;
	text-align:left;
}
.print-list table th,.print-list table td{
	border:1px solid #000;
	padding: 5px;
	font-size: 14px;
}
</style>
</head>
<body>
<div class="print-list">
	<h3>Purchase List</h3>
    <p>List of All Purchases</p>
	<table class="table table-hover list">
            <tr>
                <th width="5%" style="text-align:center">S#</th>
                <th width="15%">Date</th>
                <th width="20%">Cash/Supplier Name</th>
                <th width="15%" style="text-align:right;">Total Items</th>
                <th width="15%" style="text-align:right;">Total Price</th>
                <th width="10%" style="text-align:right;">Discount</th>
                <th width="10%" style="text-align:right;">Net Price</th>
            </tr>
            <?php
            if(numrows($sales)>0){
                $sn=1;
                while($sale=dofetch($sales)){
					$total_items += $sale["total_items"];
					$total_price += $sale["total_price"];
					$discount += $sale["discount"];
					$net_price += $sale["net_price"];
                    ?>
                    <tr>
                    	<td style="text-align:center"><?php echo $sn++?></td>
                        <td style="text-align:left;"><?php echo datetime_convert($sale["datetime_added"]); ?></td>
                        <td style="text-align:left;"><?php echo empty(get_field($sale["supplier_id"], "supplier","supplier_name"))?"Cash": get_field($sale["supplier_id"], "supplier","supplier_name"); ?></td>
                        <td style="text-align:right;"><?php echo unslash($sale["total_items"]); ?></td>
                        <td style="text-align:right;"><?php echo curr_format(unslash($sale["total_price"])); ?></td>
                        <td style="text-align:right;"><?php echo curr_format(unslash($sale["discount"])); ?></td>
                        <td style="text-align:right;"><?php echo curr_format(unslash($sale["net_price"])); ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
            <tr>
            	<td colspan="3" style="text-align:right;">Total</td>
                <td style="text-align:right;"><?php echo $total_items;?></td>
                <td style="text-align:right;"><?php echo $total_price;?></td>
                <td style="text-align:right;"><?php echo $discount;?></td>
                <td style="text-align:right;"><?php echo $net_price;?></td>
            </tr>
        </table>
</div>
</body>
</html>
<?php
die;
//}