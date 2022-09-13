<?php
if(!defined("APP_START")) die("No Direct Access");
if(isset($_POST["sales_edit"])){
	extract($_POST);
	print_r($_POST);
	$err="";
	if(empty($date) || empty($customer_name) || count($items)==0){
		$err="Fields with (*) are Mandatory.<br />";
	}
	$items_array=array();
	$i=0;
	$total_quantity=0;
	foreach($items as $item){
		if(!empty($item)){
			if(array_key_exists($item, $items_array)){
				$items_array[ $item ][ "quantity" ] += $quantity[$i];
			}
			else{
				$items_array[$item]=array(
				    "unit_price" => $unit_price[$i],
					"quantity" => $quantity[$i]
				);
			}
		}
		$i++;
	}
	foreach($items_array as $item_id=>$item){
		$quantity=$item['quantity'];
		$sale_ItemQty = doquery("select quantity from sales_items where sales_id='".slash($id)."' AND item_id='".slash($item_id)."'", $dblink);
		if( numrows( $sale_ItemQty ) > 0 ){
			$sale_ItemQty = dofetch( $sale_ItemQty );
			$ItemQty = $sale_ItemQty["quantity"];
		}
		else{
			$ItemQty=0;
		}
        $r=dofetch(doquery("select title, quantity from items where id='".slash($item_id)."'", $dblink));
		if(($r["quantity"] + $ItemQty)<$quantity){
			$err.= unslash($r["title"]).' is out of stock. Quantity available: '.$r["quantity"].'<br />';
		}
	}
	if($err==""){
		$sql="Update sales set `date`='".slash(datetime_dbconvert(unslash($date)))."',`customer_name`='".slash($customer_name)."', phone='".slash($phone)."', address='".slash($address)."', customer_id='".slash($customer_id)."' where id='".$id."'";
		doquery($sql,$dblink);
		$grand_total_price=$total_quantity=0;
		$item_ids = array();
		foreach($items_array as $item_id=>$item){
			$item_ids[] = $item_id;
			$total_quantity += $item[ "quantity" ];
			$item_price = $item[ "quantity" ] * $item['unit_price'];
			$grand_total_price += $item_price;
			$quantity_to_update = $item[ "quantity" ];
			$sale_item = doquery( "select id, quantity from sales_items where sales_id='".slash($id)."' and item_id='".$item_id."'", $dblink );
			if( numrows($sale_item) > 0 ) {
				$sale_item = dofetch( $sale_item );
				$quantity_to_update -= $sale_item[ "quantity" ];
				doquery( "update sales_items set quantity='".$item[ "quantity" ]."', unit_price='".$item['unit_price']."', total_price='".($item_price)."' where id='".$sale_item[ "id" ]."'", $dblink );
			}
			else {
				doquery("insert into sales_items(sales_id, item_id, unit_price, quantity, total_price) values('".$id."', '".$item_id."', '".$item['unit_price']."', '".$item['quantity']."', '".$item_price."')", $dblink);
			}
			doquery("update items set quantity=quantity-".$quantity_to_update." where id='".slash($item_id)."'", $dblink);
		}
		doquery("update sales set total_items=".$total_quantity.",total_price='".$grand_total_price."', discount='".$discount."', net_price='".($grand_total_price-$discount)."' where id='".$id."'", $dblink);
		$deleted_items = doquery("select * from sales_items where sales_id='".$id."' and item_id not in (".implode($item_ids, ",").")", $dblink );
		if( numrows( $deleted_items ) > 0 ) {
			while( $deleted_item = dofetch( $deleted_items ) ) {
				doquery("update items set quantity=quantity+".$deleted_item[ "quantity" ]." where id='".slash($deleted_item["item_id"])."'", $dblink);
				doquery( "delete from sales_items where id='".$deleted_item[ "id" ]."'", $dblink );
			}
		}
		unset($_SESSION["sales_manage"]["edit"]);
		header('Location: sales_manage.php?tab=list&msg='.url_encode("Sucessfully Updated"));
		die;
	}
	else{
		foreach($_POST as $key=>$value)
			$_SESSION["sales_manage"]["edit"][$key]=$value;
		header('Location: sales_manage.php?tab=edit&err='.url_encode($err));
		die;
	}
}
/*----------------------------------------------------------------------------------*/
if(isset($_GET["id"]) && $_GET["id"]!=""){
	$rs=doquery("select * from sales where id='".slash($_GET["id"])."'",$dblink);
	if(numrows($rs)>0){
		$r=dofetch($rs);
		foreach($r as $key=>$value)
			$$key=htmlspecialchars(unslash($value));
		$date=datetime_convert($date);
		$items=$quantity=array();
		$rs=doquery("select * from sales_items where sales_id='".$id."'", $dblink);
		if(numrows($rs)){
			while($r=dofetch($rs)){
				$items[]=$r["item_id"];
				$quantity[]=$r["quantity"];
			}
		}
		if(isset($_SESSION["sales_manage"]["edit"]))
			extract($_SESSION["sales_manage"]["edit"]);
	}
	else{
		header("Location: sales_manage.php?tab=list");
		die;
	}
}
else{
	header("Location: sales_manage.php?tab=list");
	die;
}