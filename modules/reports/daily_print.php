<?php
if(!defined("APP_START")) die("No Direct Access");
$extra='';
$is_search=true;
if(isset($_GET["date"])){
	$date=slash($_GET["date"]);
	$_SESSION["reports"]["daily"]["date"]=$date;
}

if(isset($_SESSION["reports"]["daily"]["date"]))
	$date=$_SESSION["reports"]["daily"]["date"];
else
	$date=date("d/m/Y");

if($date != ""){
	$extra.=" and date BETWEEN '".date('Y-m-d',strtotime(date_dbconvert($date)))." 00:00:00' AND '".date('Y-m-d',strtotime(date_dbconvert($date)))." 23:59:59'";
}

$order_by = "date";
$order = "asc";
$orderby = $order_by." ".$order;
$sql="select * from sales where 1 $extra order by $orderby";
$rs = doquery( $sql, $dblink );
?>
<style>
h1, h2, h3, p {
    margin: 0 0 10px;
}

body {
    margin:  0;
    font-family:  Arial;
    font-size:  11px;
}
.head th, .head td{ border:0;}
th, td {
    border: solid 1px #000;
    padding: 5px 5px;
    font-size: 11px;
	vertical-align:top;
}
table table th, table table td{
	padding:3px;
}
table {
    border-collapse:  collapse;
	max-width:1200px;
	margin:0 auto;
}
</style>
<table width="100%" cellspacing="0" cellpadding="0">
    <tr class="head">
        <th colspan="9">
            <?php echo get_config( 'fees_chalan_header' )?>
            <h2>General Journal List</h2>
        </th>
    </tr>
    <tr>
        <th width="5%" align="center">S.no</th>
        <th>Date</th>
        <th>Customer Name</th>
        <th align="right">Total Brands</th>
        <th align="right">Price</th>
        <th align="right">Discount</th>
        <th align="right">Net Price</th>
    </tr>
    <tr>
        <th colspan="3" align="right">Total</th>
        <?php
        $sql="select sum(total_items), sum(total_price), sum(discount), sum(net_price) from sales where 1 $extra order by $orderby";
        $total=dofetch(doquery($sql, $dblink));
        ?>
        <th align="right"><?php echo $total[ "sum(total_items)" ]?></th>
        <th align="right">Rs. <?php echo curr_format($total[ "sum(total_price)" ])?></th>
        <th align="right">Rs. <?php echo curr_format($total[ "sum(discount)" ])?></th>
        <th align="right">Rs. <?php echo curr_format($total[ "sum(net_price)" ])?></th>
    </tr>
    <tbody>
		<?php
		if( numrows( $rs ) > 0 ) {
		$sn = 1;
        	while($r=dofetch($rs)){             
				?>
				<tr>
                    <td align="center"><?php echo $sn++;?></td>
                    <td><?php echo datetime_convert($r["date"]); ?></td>
                    <td><?php echo get_field($r["customer_id"], "customer","customer_name");?></td>
                    <td align="right"><?php echo unslash($r["total_items"]); ?></td>
                    <td align="right">Rs. <?php echo curr_format(unslash($r["total_price"])); ?></td>
                    <td align="right">Rs. <?php echo curr_format(unslash($r["discount"])); ?></td>
                    <td align="right">Rs. <?php echo curr_format(unslash($r["net_price"])); ?></td>
                </tr>
				<?php
			}
		}
        ?>
    </tbody>
</table>
<?php
die;
