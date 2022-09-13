<?php
if(!defined("APP_START")) die("No Direct Access");
$rs = doquery( $sql, $dblink );
$quantity = $quantity_sold = $remaining_stock = 0;
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
	<th colspan="7">
    	<h1><?php echo get_config( 'site_title' )?></h1>
    	<h2>Stock List</h2>
        <p>
        	<?php
			if( !empty( $date_from ) || !empty( $date_to ) ){
				echo "<br />Date";
			}
			if( !empty( $date_from ) ){
				echo " from ".$date_from;
			}
			if( !empty( $date_to ) ){
				echo " to ".$date_to."<br>";
			}
			if( !empty( $supplier_id ) ){
				echo " Supplier ". get_field($supplier_id, "supplier","supplier_name");
			}
			?>
        </p>
    </th>
</tr>
<tr>
	<th width="2%" align="center">S.no</th>
    <th width="5%" align="center">ID</th>
    <th width="15%">Supplier</th>
    <th width="15%">Item</th>
    <th width="10%" align="right">Item Purchased </th>
    <th width="10%" align="right"> Item Sold </th>
    <th width="10%" align="right">Remaining Stock</th>
</tr>
<?php
if( numrows( $rs ) > 0 ) {
	$sn = 1;
	while( $r = dofetch( $rs ) ) {
		$quantity += $r["quantity"];
		$quantity_sold += $r["quantity_sold"];
		$remaining_stock += $r["remaining_stock"];
		?>
		<tr>
        	<td align="center"><?php echo $sn++;?></td>
            <td align="center"><?php echo $r["item_id"]?></td>
            <td><?php echo unslash( $r["supplier_name"] )?></td>
            <td><?php echo unslash($r["title"]); ?></td>
            <td align="right"><?php echo $r["quantity"]; ?></td>
            <td align="right"><?php echo $r["quantity_sold"]; ?></td>
            <td align="right"><?php echo $r["remaining_stock"]; ?></td>
        </tr>
		<?php
	}
	?>
	<tr>
    	<th colspan="4" align="right">Total</th>
        <th align="right"><?php echo $quantity;?></th>
        <th align="right"><?php echo $quantity_sold;?></th>
        <th align="right"><?php echo $remaining_stock;?></th>
    </tr>
	<?php
}
?>
</table>
<?php
die;