<?php
if(!defined("APP_START")) die("No Direct Access");
$rs = doquery( $sql, $dblink );
$total_items = $total_price = $discount = $net_price = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Purchase List</title>
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
	max-width:1000px;
	margin:0 auto;
}
</style>
</head>
<body>
<div class="print-list">
<table width="100%" cellspacing="0" cellpadding="0">
    <tr class="head">
        <th colspan="8">
            <h1>Purchase List</h1>
            <p>
                <?php
                echo "List of";
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
                    echo " Supplier: ".get_field($supplier_id, "supplier","supplier_name")."<br>";
                }
                ?>
            </p>
        </th>
    </tr>
    <tr>
        <th width="3%" style="text-align:center">S#</th>
        <th style="text-align:center">ID</th>
        <th width="12%">Date</th>
        <th width="20%">Supplier Name</th>
        <th>Items</th>
        <th width="10%" style="text-align:right;">Total Items</th>
        <th width="10%" style="text-align:right;">Total Price</th>
        <th width="10%" style="text-align:right;">Discount</th>
        <th width="10%" style="text-align:right;">Net Price</th>
    </tr>
    <?php
    if(numrows($rs)>0){
        $sn=1;
        while($r=dofetch($rs)){
            $total_items += $r["total_items"];
            $total_price += $r["total_price"];
            $discount += $r["discount"];
            $net_price += $r["net_price"];
            $total_qty = 0;
            ?>
            <tr>
                <td style="text-align:center"><?php echo $sn++?></td>
                <td class="text-center"><?php echo $r["id"]?></td>
                <td style="text-align:left;"><?php echo datetime_convert($r["datetime_added"]); ?></td>
                <td style="text-align:left;"><?php echo unslash($r["supplier_name"])." (".unslash($r["supplier_code"]).")".unslash($r["phone"]); ?></td>
                <td>
                    <?php 
                    $items = doquery("select * from purchase_items where purchase_id = '".$r["id"]."'", $dblink);
                    if(numrows($items)>0){
                        ?>
                        <table width="100%" class="items_col">
                            <?php 
                            while($item=dofetch($items)){
                                $total_qty += $item["quantity"];
                                ?>
                                <tr>
                                    <td width="50%"><?php echo unslash($item["quantity"])." X ".get_field($item["item_id"], "items", "title")?></td>
                                </tr>
                                <?php 
                            }
                            ?>
                            <tr>
                                <th>Total: <?php echo $total_qty?></th>
                            </tr>
                        </table>
                        <?php
                    }
                    ?>
                </td>
                <td style="text-align:right;"><?php echo unslash($r["total_items"]); ?></td>
                <td style="text-align:right;"><?php echo curr_format(unslash($r["total_price"])); ?></td>
                <td style="text-align:right;"><?php echo curr_format(unslash($r["discount"])); ?></td>
                <td style="text-align:right;"><?php echo curr_format(unslash($r["net_price"])); ?></td>
            </tr>
            <?php
        }
    }
    ?>
    <tr>
        <th colspan="5" style="text-align:right;">Total</th>
        <th style="text-align:right;"><?php echo $total_items;?></th>
        <th style="text-align:right;"><?php echo curr_format($total_price);?></th>
        <th style="text-align:right;"><?php echo curr_format($discount);?></th>
        <th style="text-align:right;"><?php echo curr_format($net_price);?></th>
    </tr>
</table>
</div>
</body>
</html>
<?php
die;
//}