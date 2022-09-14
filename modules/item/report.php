<?php
if(!defined("APP_START")) die("No Direct Access");
$rs = doquery( $sql, $dblink );
$unit_price = 0;
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
			echo "List of: ";
			if( !empty( $q ) ){
				echo $q;
			}
			if( !empty( $category ) ){
				echo " Category: ".get_field($category, "item_category","title");
			}
			?>
        </p>
    </th>
</tr>
<tr>
	<th width="5%" align="center">S.no</th>
    <th width="15%">Item Category</th>
    <th width="15%">Kitchen</th>
    <th width="20%">Title</th>
    <th width="15%">Unit </th>
    <th width="15%" align="right"> Unit Price </th>
</tr>
<?php
if( numrows( $rs ) > 0 ) {
	$sn = 1;
	while( $r = dofetch( $rs ) ) {
		$unit_price += $r["unit_price"];
		?>
		<tr>
        	<td align="center"><?php echo $sn++;?></td>
            <td><?php if($r["item_category_id"]==0) echo ""; else echo get_field($r["item_category_id"], "item_category");?></td>
            <td><?php if($r["kitchen_id"]==0) echo ""; else echo get_field($r["kitchen_id"], "kitchen");?></td>
            <td><?php echo unslash($r["title"]); ?></td>
            <td><?php echo getUnitType(unslash($r["unit"])); ?></td>
            <td align="right"><?php echo curr_format(unslash($r["unit_price"])); ?></td>
        </tr>
		<?php
	}
	?>
	<tr>
    	<th colspan="5" align="right">Total</th>
        <th align="right"><?php echo $unit_price;?></th>
    </tr>
	<?php
}
?>
</table>
<?php
die;