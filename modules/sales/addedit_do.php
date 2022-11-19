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
		case "get_customers":
			$rs = doquery( "select * from customer where status=1 order by business_name", $dblink );
			$customers = array();
			if( numrows( $rs ) > 0 ) {
				while( $r = dofetch( $rs ) ) {
					$customers[] = array(
						"id" => $r[ "id" ],
						"name" => unslash($r[ "customer_name" ]),
						"business_name" => unslash($r[ "business_name" ]),
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
			$rs = doquery( "select a.*, b.title as category from items a inner join item_category b on a.item_category_id = b.id where a.item_category_id=b.id and a.status=1 order by a.title", $dblink );
			$items = array();
			if( numrows( $rs ) > 0 ) {
				while( $r = dofetch( $rs ) ) {
					$items[] = array(
						"id" => (int)$r[ "id" ],
						"category" => $r[ "category" ],
						"item_category_id" => (int)$r[ "item_category_id" ],
						"title" => unslash($r[ "title" ]),
						"unit_price" => unslash($r[ "unit_price" ]),
						"sale_price" => unslash($r[ "sale_price" ]),
						"quantity" => unslash($r[ "quantity" ]),
					);
				}
			}
			$response = $items;
		break;
		case "get_sales":
			$id = slash( $_POST[ "id" ] );
			$rs = doquery( "select * from sales where id='".$id."'", $dblink );
			if( numrows( $rs ) > 0 ) {
				$r = dofetch( $rs );
				$sales = array(
					"id" => $r[ "id" ],
					"datetime_added" => datetime_convert( $r[ "datetime_added" ] ),
					"customer_id" => (int)$r[ "customer_id" ],
					"quantity" => $r[ "total_items" ],
					"total" => $r[ "total_price" ],
					"discount" => $r[ "discount" ],
					"net_total" => $r[ "net_price" ],
					"notes" => unslash($r[ "notes" ]),
					"shipping_charges" => $r[ "shipping_charges" ],
					"customer_payment_id" => 0,
					"payment_account_id" => "",
					"payment_amount" => 0,
				);
				if( !empty( $r[ "customer_payment_id" ] ) ) {
					$customer_payment = doquery( "select * from customer_payment where id = '".$r[ "customer_payment_id" ]."'", $dblink );
					if( numrows( $customer_payment ) > 0 ) {
						$customer_payment = dofetch( $customer_payment );
						$sales[ "customer_payment_id" ] = $customer_payment[ "id" ];
						$sales[ "payment_account_id" ] = $customer_payment[ "account_id" ];
						$sales[ "payment_amount" ] = $customer_payment[ "amount" ];
					}
				}
                $items = array();
				$rs = doquery( "select * from sales_items where sales_id='".$id."' order by id", $dblink );
				if( numrows( $rs ) > 0 ) {
					while( $r = dofetch( $rs ) ) {
						$items[] = array(
                        "id" => $r["id"],
                        "item_category_id" => (int)$r[ "item_category_id" ],
                        "item_id" => (int)$r["item_id"],
                        "quantity" => $r[ "quantity" ],
                        "discount" => $r[ "discount" ],
				        "total" => $r[ "total" ],
				        "sale_price" => $r[ "sale_price" ],
						"return" => (int)$r[ "is_return" ],
						"stock_type" => (int)$r[ "stock_type" ],
						
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
				//if(empty( $sales->id ) ) {
					foreach( $sales->items as $item ) {
						if(empty( $item->item_id ) || empty( $item->quantity ) ){
							$err[] = (empty( $item->item_id )?"Select Item":"").(empty( $item->item_id ) && empty( $item->quantity )?" and ":"").(empty( $item->quantity )?"Enter quantity":"")." at Row#".$i;
						}
						$i++;
						if( $item->id==0 ) {
							$rqq=doquery("select title, quantity from items where id='".$item->item_id."'", $dblink);
							if(numrows($rqq)>0){
								$rq = dofetch( $rqq );
								// echo $rq['quantity'];
								if($rq['quantity']<$item->quantity){
									$err[]=unslash($rq["title"]). "is out of stock. Quantity available:" .$rq['quantity']."<br />";
								}
							}
						}
					}
				//}
			}
			if( count( $err ) == 0 ) {
				if( !empty( $sales->id ) ) {
					doquery( "update sales set `datetime_added`='".slash(datetime_dbconvert(unslash($sales->datetime_added)))."', `customer_id`='".slash($sales->customer_id)."', `total_items`='".slash($sales->quantity)."', `total_price`='".slash($sales->total)."', `discount`='".slash($sales->discount)."', `net_price`='".slash($sales->net_total)."', `notes`='".slash($sales->notes)."', `shipping_charges`='".slash($sales->shipping_charges)."' where id='".$sales->id."'", $dblink );
					$sales_id = $sales->id;
				}
				else {
					doquery( "insert into sales (datetime_added, customer_id, total_items, total_price, discount, net_price, notes, shipping_charges, added_by) VALUES ('".slash(datetime_dbconvert($sales->datetime_added))."', '".slash($sales->customer_id)."', '".slash($sales->quantity)."', '".slash($sales->total)."', '".slash($sales->discount)."', '".slash($sales->net_total)."', '".slash($sales->notes)."', '".slash($sales->shipping_charges)."', '".$_SESSION[ "logged_in_admin" ][ "id" ]."')", $dblink );
					$sales_id = inserted_id();
				}
				if( !empty( $sales->payment_account_id ) ) {
					$update = false;
					if( !empty( $sales->customer_payment_id ) ) {
						$customer_payment = doquery( "select id from customer_payment where id='".$sales->customer_payment_id."'", $dblink );
						if( numrows( $customer_payment ) > 0 ) {
							$update = true;
						}
					}
					if( $update ) {
						doquery( "update customer_payment set customer_id = '".slash( $sales->customer_id )."', amount = '".slash( $sales->payment_amount )."', account_id = '".slash( $sales->payment_account_id )."' where id = '".$sales->customer_payment_id."'", $dblink );
					}
					else {
						doquery( "insert into customer_payment(customer_id, datetime_added, amount, account_id, details) values( '".slash( $sales->customer_id )."', NOW(), '".slash( $sales->payment_amount )."', '".slash( $sales->payment_account_id )."', 'Payment against Sales #".$sales_id."' )", $dblink );
						$sales->customer_payment_id = inserted_id();
						doquery( "update sales set customer_payment_id = '".$sales->customer_payment_id."' where id='".$sales_id."'", $dblink );
					}
				}
				$item_ids = array();
				foreach( $sales->items as $item ) {
					if( !empty( $item->id ) ) {  
						$prev_item = dofetch( doquery( "select quantity from sales_items where id = '".$item->id."'", $dblink ) );
						$quantity = $item->quantity-$prev_item[ "quantity" ]; 
						doquery( "update sales_items set `item_id`='".slash( $item->item_id )."', `sale_price`='".$item->sale_price."', `quantity`='".$item->quantity."', `discount`='".$item->discount."', `total`='".$item->total."', `is_return`='".$item->return."', `stock_type`='".$item->stock_type."' where id='".$item->id."'", $dblink );
						//doquery( "update purchase_items set quantity_sold = quantity_sold+".$quantity." where item_id = '".$item->item_id."'", $dblink );
						$item_ids[] = $item->id;
					}
					else {						
						doquery( "insert into sales_items ( sales_id, item_id, sale_price, quantity, discount, total, is_return, stock_type ) values( '".$sales_id."', '".$item->item_id."', '".$item->sale_price."', '".$item->quantity."', '".$item->discount."','".$item->total."', '".$item->return."', '".$item->stock_type."' )", $dblink );
						$item->id = inserted_id();
						$item_ids[] = $item->id;
						$quantity = $item->quantity;
						//doquery( "update purchase_items set quantity_sold = quantity_sold+".$item->quantity." where item_id = '".$item->item_id."'", $dblink );
					}
					if($item->return && $item->stock_type==1){
						doquery( "update items set quantity = quantity-".$quantity." where id = '".$item->item_id."'", $dblink );
					}
					elseif(!$item->return){
						doquery( "update items set quantity = quantity-".$quantity." where id = '".$item->item_id."'", $dblink );
					}
				}
				if( !empty( $sales_id ) && count( $item_ids ) > 0 ) {
					$rs = doquery( "select * from sales_items where sales_id='".$sales_id."' and id not in( ".implode( ",", $item_ids )." )", $dblink );
					$deleted_items = doquery( "select * from sales_items where sales_id='".$sales_id."' and id not in( ".implode( ",", $item_ids )." )", $dblink );
					if( numrows( $deleted_items ) > 0 ) {
						while( $deleted_item = dofetch( $deleted_items ) ){
							//doquery( "update purchase_items set quantity_sold = quantity_sold-".$deleted_item[ "quantity" ]." where item_id = '".$deleted_item[ "item_id" ]."'", $dblink );
							doquery( "update items set quantity = quantity+".$deleted_item[ "quantity" ]." where id = '".$deleted_item[ "item_id" ]."'", $dblink );
							
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