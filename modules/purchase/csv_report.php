<?php
if(!defined("APP_START")) die("No Direct Access");
$rs = doquery( $sql, $dblink );
if(numrows($rs)>0){
    header('Content-Type: text/csv; charset=utf-8');
    header("Content-Disposition: attachment; filename=purchase.csv");
    $fh = fopen( 'php://output', 'w' );
    if( !empty( $supplier_id ) ){
        $supplier_name = get_field($supplier_id, "supplier", "supplier_name");
        fputcsv($fh,array('Supplier:', $supplier_name));
    }
    fputcsv($fh,array('S.no','Date','Supplier Name','Items','Total Items','Total Price','Discount','Net Price'));
    $sn=1;
    $total = 0;
    while($r=dofetch($rs)){
        $total_items += $r["total_items"];
        $total_price += $r["total_price"];
        $discount += $r["discount"];
        $net_price += $r["net_price"];
        $total_qty = 0;
        fputcsv($fh,array(
            $sn++,
            datetime_convert($r["datetime_added"]),
            unslash($r["supplier_name"]),
            get_field($item["item_id"], "items", "title")." X ".unslash($item["quantity"]),
            unslash($r["total_items"]),
            curr_format(unslash($r["total_price"])),
            curr_format(unslash($r["discount"])),
            curr_format(unslash($r["net_price"]))
        ));
    }
    fputcsv($fh,array('','','Total:',curr_format($total)));
    fclose($fh);
}
die;
?>
