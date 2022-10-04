<?php
if(!defined("APP_START")) die("No Direct Access");
if(isset($_POST["action"])){
	$response = array();
	switch($_POST["action"]){
		case 'get_datetime':
			$response = datetime_convert( date( "Y-m-d H:i:s" ) );
		break;
		case "get_accounts":
			$rs = doquery( "select * from account where status=1 order by id", $dblink );
			$accounts = array();
			if( numrows( $rs ) > 0 ) {
				while( $r = dofetch( $rs ) ) {
					$accounts[] = array(
						"id" => $r[ "id" ],
						"title" => unslash($r[ "title" ])
					);
				}
			}
			$response = $accounts;
		break;
		case "get_categories":
			$rs = doquery( "select * from item_category where status=1 order by title", $dblink );
			$categories = array();
			if( numrows( $rs ) > 0 ) {
				while( $r = dofetch( $rs ) ) {
					$categories[] = array(
						"id" => $r[ "id" ],
						"title" => unslash($r[ "title" ]),
					);
				}
			}
			$response = $categories;
		break;
		case "get_items":
			$rs = doquery( "select a.*, b.title as category from items a inner join item_category b on a.item_category_id = b.id where a.item_category_id=b.id and a.status=1 order by a.title", $dblink );
			$items = array();
			if( numrows( $rs ) > 0 ) {
				while( $r = dofetch( $rs ) ) {
					$items[] = array(
						"id" => $r[ "id" ],
						"category" => $r[ "category" ],
						"item_category_id" => (int)$r[ "item_category_id" ],
						"title" => unslash($r[ "title" ]),
					);
				}
			}
			$response = $items;
		break;
		case "get_suppliers":
			$rs = doquery( "select * from supplier where status=1 order by supplier_name", $dblink );
			$suppliers = array();
			if( numrows( $rs ) > 0 ) {
				while( $r = dofetch( $rs ) ) {
					$suppliers[] = array(
						"id" => $r[ "id" ],
						"supplier_code" => unslash($r[ "supplier_code" ]),
						"name" => unslash($r[ "supplier_name" ]),
						"phone" => unslash($r[ "phone" ]),
						"address" => unslash($r[ "address" ]),
					);
				}
			}
			$response = $suppliers;
		break;
		
		case "get_purchase":
			$id = slash( $_POST[ "id" ] );
			$rs = doquery( "select a.*, b.supplier_code, b.supplier_name, b.phone, b.address from purchase a left join supplier b on a.supplier_id = b.id where a.id='".$id."'", $dblink );
			if( numrows( $rs ) > 0 ) {
				$r = dofetch( $rs );
				$purchase = array(
					"id" => $r[ "id" ],
					"datetime_added" => datetime_convert( $r[ "datetime_added" ] ),
					"supplier" => array(
						"id" => $r[ "supplier_id" ],
						"supplier_code" => $r[ "supplier_code" ],
						"supplier_name" => $r[ "supplier_name" ],
						"phone" => $r[ "phone" ],
						"address" => $r[ "address" ],
					),
					"quantity" => $r[ "total_items" ],
					"total" => $r[ "total_price" ],
					"discount" => $r[ "discount" ],
					"net_total" => $r[ "net_price" ],
					"notes" => unslash($r[ "notes" ])
				);
				$items = array();
				$rs = doquery( "select * from purchase_items where purchase_id='".$id."' order by id", $dblink );
				if( numrows( $rs ) > 0 ) {
					while( $r = dofetch( $rs ) ) {
						$items[] = $r;
					}
				}
				$purchase[ "items" ] = $items;
			}
			$response = $purchase;
		break;
		case "save_purchase":
			$err = array();
			$purchase = json_decode( $_POST[ "purchase" ] );
			if( empty( $purchase->datetime_added ) || empty( $purchase->supplier->supplier_code ) ) {
				$err[] = "Fields with * are mandatory";
				
			}
			if( count( $purchase->items ) == 0 ) {
				$err[] = "Add some items first.";
			}
			else {
				$i=1;
				foreach( $purchase->items as $item ) {
					if( empty( $item->item_category_id ) || empty( $item->item_id ) || empty( $item->purchase_price ) || empty( $item->sale_price ) || empty( $item->quantity ) ){
						$err[] = "Fill all the required fields on Row#".$i;
					}
					$i++;
				}
			}
			if( count( $err ) == 0 ) {
				if( empty( $purchase->supplier->id ) ) {
					doquery( "insert into supplier (supplier_code, supplier_name, phone, address) VALUES ('".slash($purchase->supplier->supplier_code)."', '".slash($purchase->supplier->name)."', '".slash($purchase->supplier->phone)."', '".slash($purchase->supplier->address)."') ", $dblink );
					$supplier_id = inserted_id();
				}
				else {
					doquery("update supplier set `supplier_code`='".slash($purchase->supplier->supplier_code)."', `supplier_name`='".slash($purchase->supplier->name)."', `phone`='".slash($purchase->supplier->phone)."', `address`='".slash($purchase->supplier->address)."' where id='".$purchase->supplier->id."'", $dblink);
					$supplier_id = $purchase->supplier->id;
				}
				if( !empty( $purchase->id ) ) {
					doquery( "update purchase set `datetime_added`='".slash(datetime_dbconvert(unslash($purchase->datetime_added)))."', `supplier_id`='".slash($supplier_id)."', `total_items`='".slash($purchase->quantity)."', `total_price`='".slash($purchase->total)."', `discount`='".slash($purchase->discount)."', `net_price`='".slash($purchase->net_total)."', `notes`='".slash($purchase->notes)."' where id='".$purchase->id."'", $dblink );
					$purchase_id = $purchase->id;
				}
				else {
					doquery( "insert into purchase (datetime_added, supplier_id, total_items, total_price, discount, net_price, notes, added_by) VALUES ('".slash(datetime_dbconvert($purchase->datetime_added))."', '".slash($supplier_id)."', '".slash($purchase->quantity)."', '".slash($purchase->total)."', '".slash($purchase->discount)."', '".slash($purchase->net_total)."', '".slash($purchase->notes)."', '".$_SESSION[ "logged_in_admin" ][ "id" ]."')", $dblink );
					$purchase_id = inserted_id();
				}
				
				$item_ids = array();
				foreach( $purchase->items as $item ) {
					if( empty( $item->id ) ) {
						doquery( "insert into purchase_items( purchase_id, item_category_id, item_id, purchase_price, sale_price, quantity, total, is_return ) values( '".$purchase_id."', '".$item->item_category_id."', '".slash( $item->item_id )."',  '".$item->purchase_price."', '".$item->sale_price."', '".$item->quantity."', '".$item->total."', '".$item->return."' )", $dblink );
						$item_ids[] = inserted_id();
						$quantity = $item->quantity;
					}
					else {
						doquery( "update purchase_items set `purchase_id`='".$purchase_id."', `item_category_id`='".$item->item_category_id."', `item_id`='".slash( $item->item_id )."',`purchase_price`='".$item->purchase_price."', `sale_price`='".$item->sale_price."', `quantity`='".$item->quantity."', `total`='".$item->total."', `is_return`='".$item->return."' where id='".$item->id."'", $dblink );
						$item_ids[] = $item->id;
					}
					
					doquery( "update items set quantity = quantity+".$quantity." where id = '".$item->item_id."'", $dblink );
				}
				if( !empty( $purchase->id ) && count( $item_ids ) > 0 ) {
					doquery( "delete from purchase_items where purchase_id='".$purchase_id."' and id not in( ".implode( ",", $item_ids )." )", $dblink );
				}
				$response = array(
					"status" => 1,
					"id" => $purchase_id
				);
			}
			else {
				$response = array(
					"status" => 0,
					"error" => $err
				);
			}
		break;
	}
	echo json_encode( $response );
	die;
}