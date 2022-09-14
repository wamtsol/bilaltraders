<?php
if(!defined("APP_START")) die("No Direct Access");
if(isset($_POST["action"])){
	$response = array();
	switch($_POST["action"]){
		case 'get_datetime':
			$response = datetime_convert( date( "Y-m-d H:i:s" ) );
		break;
		case "get_customers":
			$rs = doquery( "select * from customer where status=1 order by customer_name", $dblink );
			$customers = array();
			if( numrows( $rs ) > 0 ) {
				while( $r = dofetch( $rs ) ) {
					$customers[] = array(
						"id" => $r[ "id" ],
						"name" => unslash($r[ "customer_name" ]),
					);
				}
			}
			$response = $customers;
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
			$rs = doquery( "select * from items where status=1 order by title", $dblink );
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
		// case "get_purchase_items":
		// 	$items = array();
		// 	if( !empty( $_POST[ "id" ] ) ) {
		// 		$rs = doquery( "select purchase_item_id, quantity from sales_items where sales_id = '".slash( $_POST[ "id" ] )."'", $dblink );
		// 		if( numrows( $rs ) > 0 ) {
		// 			while( $r = dofetch( $rs ) ){
		// 				$items[ $r[ "purchase_item_id" ] ] = $r[ "quantity" ];
		// 			}
		// 		}
		// 	}
		// 	$rs = doquery( "SELECT a.*, c.supplier_code, c.supplier_name, d.title as size_title, e.title as color_title FROM `purchase_items` a left join purchase b on a.purchase_id = b.id left join supplier c on b.supplier_id = c.id left join size d on a.size = d.id left join color e on a.color = e.id where b.status=1 order by supplier_code, item_id", $dblink );
		// 	$purchase_items = array();
		// 	if( numrows( $rs ) > 0 ) {
		// 		while( $r = dofetch( $rs ) ) {
		// 			$item_name = (!empty($r[ "supplier_code" ])?unslash($r[ "supplier_code" ])."-":'').unslash($r[ "item_id" ]);
		// 			if( !empty( $r[ "size" ] ) || !empty( $r[ "color" ] ) ) {
		// 				$attributes = array();
		// 				if( !empty( $r[ "size" ] ) ) {
		// 					$attributes[] = 'Size: '.unslash( $r[ "size_title" ] );
		// 				}
		// 				if( !empty( $r[ "color" ] ) ) {
		// 					$attributes[] = 'Color: '.unslash( $r[ "color_title" ] );
		// 				}
		// 				$item_name .= ' ('.implode( ", ", $attributes ).")";
		// 			}
		// 			$quantity = $r[ "quantity" ]-$r[ "quantity_sold" ]-$r[ "quantity_returned" ];
		// 			if( isset( $items[ $r[ "id" ] ] ) ){
		// 				$quantity += $items[ $r[ "id" ] ];
		// 			}
		// 			if( $quantity > 0 ) {
		// 				$purchase_items[] = array(
		// 					"id" => $r[ "id" ],
		// 					"item_name" => $item_name,
		// 					"sale_price" => $r[ "sale_price" ],
		// 					"quantity" => $quantity,
		// 					"total" => $r[ "total" ],
		// 				);
		// 			}
		// 		}
		// 	}
		// 	$response = $purchase_items;
		// break;
		 case "get_sales":
			$id = slash( $_POST[ "id" ] );
			$rs = doquery( "select * from sales where id='".$id."'", $dblink );
			if( numrows( $rs ) > 0 ) {
				$r = dofetch( $rs );
				$sales = array(
					"id" => $r[ "id" ],
					"datetime_added" => datetime_convert( $r[ "datetime_added" ] ),
					"customer_id" => $r[ "customer_id" ],
					"quantity" => $r[ "total_items" ],
					"total" => $r[ "total_price" ],
					"discount" => $r[ "discount" ],
					"net_total" => $r[ "net_price" ]
				);
                $items = array();
				$rs = doquery( "select * from sales_items where sales_id='".$id."' order by id", $dblink );
				if( numrows( $rs ) > 0 ) {
					while( $r = dofetch( $rs ) ) {
						$items[] = array(
                        "id" => $r["id"],
                        "purchase_item_id" => $r[ "purchase_item_id" ],
                        "sales_itemid" => $r["id"],
                        "quantity" => $r[ "quantity" ],
                        "discount" => $r[ "discount" ],
				        "total" => $r[ "total" ],
				        "sale_price" => $r[ "sale_price" ]
					
                            );
					}
				}
				$sales[ "items" ] = $items;
			}
			$response = $sales;
		break;
		case "save_sale":
			$err = array();
			$sales = json_decode( $_POST[ "sales" ] );
			if( empty( $sales->datetime_added ) ) {
				$err[] = "Fields with * are mandatory";
				
			}
			if( count( $sales->items ) == 0 ) {
				$err[] = "Add some items first.";
			}
			else {
				$i=1;
				foreach( $sales->items as $item ) {
					if(empty( $item->purchase_item_id ) || empty( $item->quantity ) ){
						$err[] = (empty( $item->purchase_item_id )?"Select Item":"").(empty( $item->purchase_item_id ) && empty( $item->quantity )?" and ":"").(empty( $item->quantity )?"Enter quantity":"")." at Row#".$i;
					}
					$i++;
				}
			}
			if( count( $err ) == 0 ) {
				if( !empty( $sales->id ) ) {
					doquery( "update sales set `datetime_added`='".slash(datetime_dbconvert(unslash($sales->datetime_added)))."', `customer_id`='".slash($sales->customer_id)."', `total_items`='".slash($sales->quantity)."', `total_price`='".slash($sales->total)."', `discount`='".slash($sales->discount)."', `net_price`='".slash($sales->net_total)."' where id='".$sales->id."'", $dblink );
					$sales_id = $sales->id;
				}
				else {
					doquery( "insert into sales (datetime_added, customer_id, total_items, total_price, discount, net_price, added_by) VALUES ('".slash(datetime_dbconvert($sales->datetime_added))."', '".slash($sales->customer_id)."', '".slash($sales->quantity)."', '".slash($sales->total)."', '".slash($sales->discount)."', '".slash($sales->net_total)."', '".$_SESSION[ "logged_in_admin" ][ "id" ]."')", $dblink );
					$sales_id = inserted_id();
				}
				$item_ids = array();
				foreach( $sales->items as $item ) {
					if( isset( $item->sales_itemid ) && !isset( $item->sales_itemid ) ) {
                        $previous_quantity = dofetch( doquery( "select quantity from sales_items where id='".$item->sales_itemid."'", $dblink ) );
						$previous_quantity = $previous_quantity[ "quantity" ];
						doquery( "update sales_items set `item_id`='".slash( $item->item_id )."',`item_category_id`='".slash( $item->item_category_id )."', `sale_price`='".$item->sale_price."', `discount`='".$item->discount."', `quantity`='".$item->quantity."', `total`='".$item->total."' where id='".$item->sales_itemid."'", $dblink );
						$new_quantity = $item->quantity-$previous_quantity;
						doquery( "update purchase_items set quantity_sold = quantity_sold+".$new_quantity." where id = '".$item->purchase_item_id."'", $dblink );
						$item_ids[] = $item->id;
					}
					else {						
						doquery( "insert into sales_items ( sales_id, item_id,item_category_id, sale_price, discount, quantity, total ) values( '".$sales_id."', '".$item->item_id."','".$item->item_category_id."', '".$item->sale_price."', '".$item->discount."', '".$item->quantity."', '".$item->total."' )", $dblink );
						$item_ids[] = inserted_id();
						doquery( "update purchase_items set quantity_sold = quantity_sold+".$item->quantity." where id = '".$item->purchase_item_id."'", $dblink );						
					}
				}
				if( !empty( $sales->id ) && count( $item_ids ) > 0 ) {
					$rs = doquery( "select * from sales_items where sales_id='".$sales_id."' and id not in( ".implode( ",", $item_ids )." )", $dblink );
					if( numrows( $rs ) > 0 ) {
						while( $r = dofetch( $rs ) ) {
							doquery( "update purchase_items set quantity_sold = quantity_sold-".$r[ "quantity" ]." where id = '".$r[ "purchase_item_id" ]."'", $dblink );
						}
					}
					doquery( "delete from sales_items where sales_id='".$sales_id."' and id not in( ".implode( ",", $item_ids )." )", $dblink );
				}
				$response = array(
					"status" => 1,
					"id" => $sales_id
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
if( isset($_GET[ "tab" ]) && in_array( $_GET[ "tab" ], array("print_receipt")) ) {
	switch( $_GET[ "tab" ] ) {
		case "print_receipt":
			include("modules/dashboard/receipt.php");
			die;
		break;
	}
}