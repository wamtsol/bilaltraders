<?php
if(!defined("APP_START")) die("No Direct Access");
if(isset($_GET["id"]) && !empty($_GET["id"])){
	$id=slash($_GET["id"]);
	$sales = doquery( "select * from sales where id = '".$id."' ", $dblink );
	if( numrows( $sales ) > 0 ) {
		$sales = dofetch( $sales );
		if( $sales[ "status" ]==1 ) {
			$rs=doquery("select * from sales_items where sales_id='".$id."'", $dblink);
			if(numrows($rs)){
				while($r=dofetch($rs)){
					$quantity=$r["quantity"];
					doquery("update purchase_items set quantity_sold=quantity_sold-".$quantity." where id='".slash($r["purchase_item_id"])."'", $dblink);
				}
			}
		}
		doquery("delete from sales_items where sales_id='".$id."'",$dblink);
		doquery("delete from sales where id='".$id."'",$dblink);
	}
	header("Location: sales_manage.php?msg=".url_encode( "Record deleted successfully." ));
	die;
}