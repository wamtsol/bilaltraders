<?php
if(!defined("APP_START")) die("No Direct Access");
$rs = doquery( $sql, $dblink );
$opening_stock = $quantity = $quantity_sold = $remaining_stock = $stock_return_total = $stock_return_total_price = $purchase_val = $sale_val = 0;
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
	<th colspan="10">
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
    <th align="right" width="10%">Purchase Value</th>
    <th width="10%" align="right">Sale Value </th>
    <th align="right" width="10%">Opening Stock</th>
    <th width="10%" align="right">Item Purchased </th>
    <th width="10%" align="right">Purchased Total</th>
    <th width="10%" align="right"> Item Sold </th>
    <th width="10%" align="right">Sold Total</th>
    <th width="10%" align="right">Remaining Stock</th>
    <th width="10%" align="right">Stock Total</th>
    
</tr>
<?php
if( numrows( $rs ) > 0 ) {
	$sn = 1;
    $sold = $total_sale = $remaining_stock = 0;
	$purchase_rice_total = $sale_total = $remaining_stock_total = $remaining_stockt = 0;
	while( $r = dofetch( $rs ) ) {
        $sale = dofetch(doquery( "select sum(quantity) as sold_qty, sum(total) as total_sale from sales_items where item_id='".$r[ "item_id" ]."'", $dblink ));
        $sold = $sale[ "sold_qty" ];
        $total_sale = $sale[ "total_sale" ];
        $remaining_stock = $r["opening_stock"]+$r[ "quantity" ]-$sold;
        $purchase_val += $r["purchase_price"];
        $sale_val += $r["sale_price"];
		$quantity += $r["quantity"];
        $opening_stock += $r["opening_stock"];
		$quantity_sold += $sold;
		$remaining_stockt += $remaining_stock;
        $sale_total += $total_sale;
        $remaining_stock_total += $remaining_stock*$r[ "purchase_price" ];
		?>
		<tr>
        	<td align="center"><?php echo $sn++;?></td>
            <td align="center"><?php echo $r["item_id"]?></td>
            <td><?php echo unslash( $r["supplier_name"] )?></td>
            <td><?php echo unslash($r["title"]); ?></td>
            <td align="right"><?php echo unslash($r["purchase_price"]); ?></td>
            <td align="right"><?php echo unslash($r["sale_price"]); ?></td>
            <td align="right"><?php echo $r["opening_stock"]; ?></td>
            <td align="right"><?php echo $r["quantity"]; ?></td>
            <td align="right"><?php $purchase_rice_total += $r[ "quantity" ]*$r[ "purchase_price" ]; echo curr_format( $r[ "quantity" ]*$r[ "purchase_price" ] )?></td>
            <td align="right"><?php echo $sold; ?></td>
            <td align="right"><?php echo curr_format($total_sale); ?></td>
            <td align="right"><?php echo $remaining_stock; ?></td>
            <td align="right">
            <?php 
                if($remaining_stock>0){
                    echo $remaining_stock*$r[ "purchase_price" ];
                }
                else{
                    echo $remaining_stock;
                }
                ?>
            </td>
            
        </tr>
        
		<?php
	}
	?>
	<tr>
    	<th colspan="4" align="right">Total</th>
        <th align="right"><?php echo curr_format( $purchase_val );?></th>
        <th align="right"><?php echo curr_format( $sale_val );?></th>
        <th align="right"><?php echo curr_format( $opening_stock );?></th>
        <th align="right"><?php echo curr_format( $quantity );?></th>
        <th align="right"><?php echo curr_format( $purchase_rice_total );?></th>
        <th align="right"><?php echo curr_format( $quantity_sold );?></th>
        <th align="right"><?php echo curr_format( $sale_total );?></th>
        <th align="right"><?php echo curr_format( $remaining_stockt );?></th>
        <th align="right"><?php echo curr_format( $remaining_stock_total );?></th>
      
    </tr>
	<?php
}
?>
</table>
<?php
die;