<?php
if(!defined("APP_START")) die("No Direct Access");
if( count( $_POST ) > 0 ) {
	$response = array();
	extract( $_POST );
	if( isset( $action ) && in_array( $action, array( "get_customers", "get_suppliers", "get_orders", "get_expense", "add_expense", "get_accounts", "get_expense_category", "get_customer_payment", "add_customer_payment", "get_supplier_payment", "add_supplier_payment", "get_transaction", "add_transaction", "get_orders_return") ) ) {
		switch( $action ) {
			case "get_customers":
				$rs = doquery( "select * from customer where status=1 order by customer_name", $dblink );
				$customers = array();
				if( numrows( $rs ) > 0 ) {
					while( $r = dofetch( $rs ) ) {
						$customers[] = array(
							"id" => $r[ "id" ],
							"name" => unslash($r[ "customer_name" ]),
							"phone" => unslash($r[ "phone" ]),
							"address" => unslash($r[ "address" ]),
						);
					}
				}
				$response = $customers;
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
			case "get_orders":
				$dt = get_last_closing_date();
				$rs = doquery( "select a.id from sales a left join admin b on a.added_by = b.id where datetime_added>='".$dt."' and a.status=1 order by datetime_added desc", $dblink );
				$orders = array();
				if( numrows( $rs ) > 0 ) {
					while( $r = dofetch( $rs ) ) {
						$orders[] = get_order( $r[ "id" ]);
					}
				}
				$response = $orders;
			break;
			case "get_orders_return":
				$dt = get_last_closing_date();
				$rs = doquery( "select a.id from sales_return a left join admin b on a.added_by = b.id where datetime_added>='".$dt."' and a.status=1 order by datetime_added desc", $dblink );
				$orders_return = array();
				if( numrows( $rs ) > 0 ) {
					while( $r = dofetch( $rs ) ) {
						$orders_return[] = get_order_return( $r[ "id" ]);
					}
				}
				$response = $orders_return;
			break;
			case "get_expense":
				$dt = get_last_closing_date();
				$rs = doquery( "select * from expense where status=1 and datetime_added>='".$dt."' order by datetime_added desc", $dblink );
				$expense = array();
				if( numrows( $rs ) > 0 ) {
					while( $r = dofetch( $rs ) ) {
						$expense[] = array(
							"id" => $r[ "id" ],
							"datetime_added" => date("h:i A", strtotime($r[ "datetime_added" ])),
							"expense_category_id" => get_field( unslash($r["expense_category_id"]), "expense_category", "title" ),
							"details" => unslash($r[ "details" ]),
							"amount" => unslash($r[ "amount" ]),
							"account_id" =>$r["account_id"],
							"account" => get_field( unslash($r["account_id"]), "account", "title" )
						);
					}
				}
				$response = $expense;
			break;
			case "add_expense":
				$expense = json_decode( $expense );
				if( !empty( $expense->expense_category_id ) && !empty( $expense->account_id ) && !empty( $expense->amount ) ) {
					doquery("insert into expense(datetime_added, expense_category_id, details, amount, account_id, added_by) values(NOW(), '".slash($expense->expense_category_id)."', '".slash($expense->details)."', '".slash($expense->amount)."', '".slash($expense->account_id)."', '".$_SESSION["logged_in_admin"]["id"]."')", $dblink);
					$id = inserted_id();
					$r = dofetch(doquery("select * from expense where id ='".$id."'", $dblink));
					$expense = array(
						"id" => $r[ "id" ],
						"datetime_added" => date("h:i A", strtotime($r[ "datetime_added" ])),
						"expense_category_id" => get_field( unslash($r["expense_category_id"]), "expense_category", "title" ),
						"details" => unslash($r[ "details" ]),
						"amount" => unslash($r[ "amount" ]),
						"account_id" => $r["account_id"],
						"account" => get_field( unslash($r["account_id"]), "account", "title" )
					);
					$response = array(
						"status" => 1,
						"expense" => $expense
					);
				}
				else{
					$response = array(
						"status" => 0,
						"message" => "Enter Category, Account and Amount"
					);
				}				
			break;
			case "get_customer_payment":
				$dt = get_last_closing_date();
				$rs = doquery( "select * from customer_payment where status=1 and datetime_added>='".$dt."' order by datetime_added desc", $dblink );
				$customer_payment = array();
				if( numrows( $rs ) > 0 ) {
					while( $r = dofetch( $rs ) ) {
						$customer_payment[] = array(
							"id" => $r[ "id" ],
							"datetime_added" => date("h:i A", strtotime($r[ "datetime_added" ])),
							"customer_id" => get_field( unslash($r["customer_id"]), "customer", "customer_name" ),
							"amount" => unslash($r[ "amount" ]),
							"account_id" => $r["account_id"],
							"account" => get_field( unslash($r["account_id"]), "account", "title" ),
							"details" => unslash($r[ "details" ])
						);
					}
				}
				$response = $customer_payment;
			break;
			case "add_customer_payment":
				$customer_payment = json_decode( $customer_payment );
				if( !empty( $customer_payment->customer_id ) && !empty( $customer_payment->account_id ) && !empty( $customer_payment->amount ) ) {
					doquery("insert into customer_payment(customer_id, datetime_added, amount, account_id, details) values('".slash($customer_payment->customer_id)."',NOW(), '".slash($customer_payment->amount)."', '".slash($customer_payment->account_id)."', '".slash($customer_payment->details)."')", $dblink);
					$id = inserted_id();
					$r = dofetch(doquery("select * from customer_payment where id ='".$id."'", $dblink));
					$customer_payment = array(
						"id" => $r[ "id" ],
						"datetime_added" => date("h:i A", strtotime($r[ "datetime_added" ])),
						"customer_id" => get_field( unslash($r["customer_id"]), "customer", "customer_name" ),
						"amount" => unslash($r[ "amount" ]),
						"account_id" => $r[ "account_id" ],
						"account" => get_field( unslash($r["account_id"]), "account", "title" ),
						"details" => unslash($r[ "details" ])
					);
					$response = array(
						"status" => 1,
						"customer_payment" => $customer_payment
					);
				}
				else{
					$response = array(
						"status" => 0,
						"message" => "Enter Customer, Account and Amount"
					);
				}				
			break;
			case "get_supplier_payment":
				$dt = get_last_closing_date();
				$rs = doquery( "select * from supplier_payment where status=1 and datetime_added>='".$dt."' order by datetime_added desc", $dblink );
				$supplier_payment = array();
				if( numrows( $rs ) > 0 ) {
					while( $r = dofetch( $rs ) ) {
						$supplier_payment[] = array(
							"id" => $r[ "id" ],
							"datetime_added" => date("h:i A", strtotime($r[ "datetime_added" ])),
							"supplier_id" => get_field( unslash($r["supplier_id"]), "supplier", "supplier_name" ),
							"amount" => unslash($r[ "amount" ]),
							"account_id" => $r[ "account_id" ],
							"account" => get_field( unslash($r["account_id"]), "account", "title" ),
							"details" => unslash($r[ "details" ])
						);
					}
				}
				$response = $supplier_payment;
			break;
			case "add_supplier_payment":
				$supplier_payment = json_decode( $supplier_payment );
				if( !empty( $supplier_payment->supplier_id ) && !empty( $supplier_payment->account_id ) && !empty( $supplier_payment->amount ) ) {
					doquery("insert into supplier_payment(supplier_id, datetime_added, amount, account_id, details) values('".slash($supplier_payment->supplier_id)."',NOW(), '".slash($supplier_payment->amount)."', '".slash($supplier_payment->account_id)."', '".slash($supplier_payment->details)."')", $dblink);
					$id = inserted_id();
					$r = dofetch(doquery("select * from supplier_payment where id ='".$id."'", $dblink));
					$supplier_payment = array(
						"id" => $r[ "id" ],
						"datetime_added" => date("h:i A", strtotime($r[ "datetime_added" ])),
						"supplier_id" => get_field( unslash($r["supplier_id"]), "supplier", "supplier_name" ),
						"amount" => unslash($r[ "amount" ]),
						"account_id" => $r[ "account_id" ],
						"account" => get_field( unslash($r["account_id"]), "account", "title" ),
						"details" => unslash($r[ "details" ])
					);
					$response = array(
						"status" => 1,
						"supplier_payment" => $supplier_payment
					);
				}
				else{
					$response = array(
						"status" => 0,
						"message" => "Enter Supplier, Account and Amount"
					);
				}				
			break;
			case "get_accounts":
				$dt = get_last_closing_date();
				$rs = doquery( "select * from account where status=1 order by title", $dblink );
				$accounts = array();
				if( numrows( $rs ) > 0 ) {
					while( $r = dofetch( $rs ) ) {
						$accounts[] = array(
							"id" => $r[ "id" ],
							"title" => unslash($r[ "title" ]),
							"is_petty_cash" => $r[ "is_petty_cash" ],
							"balance" => get_account_balance( $r[ "id" ], $dt )
						);
					}
				}
				$response = $accounts;
			break;
			case "get_expense_category":
				$rs = doquery( "select * from expense_category where status=1 order by title", $dblink );
				$expense_categories = array();
				if( numrows( $rs ) > 0 ) {
					while( $r = dofetch( $rs ) ) {
						$expense_categories[] = array(
							"id" => $r[ "id" ],
							"title" => unslash($r[ "title" ]),
						);
					}
				}
				$response = $expense_categories;
			break;
			case "get_transaction":
				$dt = get_last_closing_date();
				$rs = doquery( "select * from transaction where status=1 and datetime_added>='".$dt."' order by datetime_added desc", $dblink );
				$transaction = array();
				if( numrows( $rs ) > 0 ) {
					while( $r = dofetch( $rs ) ) {
						$transaction[] = array(
							"id" => $r[ "id" ],
							"account_id" => $r["account_id"],
							"account" => get_field( unslash($r["account_id"]), "account", "title" ),
							"reference_id" => $r["reference_id"],
							"reference" => get_field( unslash($r["reference_id"]), "account", "title" ),
							"datetime_added" => date("h:i A", strtotime($r[ "datetime_added" ])),
							"amount" => unslash($r[ "amount" ]),
							"details" => unslash($r[ "details" ])
						);
					}
				}
				$response = $transaction;
			break;
			case "add_transaction":
				$transaction = json_decode( $transaction );
				if( !empty( $transaction->account_id ) && !empty( $transaction->amount ) ) {
					doquery("insert into transaction(account_id, reference_id, datetime_added, amount, details) values('".slash($transaction->account_id)."', '".slash($transaction->reference_id)."', NOW(), '".slash($transaction->amount)."', '".slash($transaction->details)."')", $dblink);
					$id = inserted_id();
					$r = dofetch(doquery("select * from transaction where id ='".$id."'", $dblink));
					$transaction = array(
						"id" => $r[ "id" ],
						"account_id" => $r["account_id"],
						"account" => get_field( unslash($r["account_id"]), "account", "title" ),
						"reference_id" => $r["reference_id"],
						"reference" => get_field( unslash($r["reference_id"]), "account", "title" ),
						"datetime_added" => unslash($r[ "datetime_added" ]),
						"amount" => unslash($r[ "amount" ]),
						"details" => unslash($r[ "details" ])
					);
					$response = array(
						"status" => 1,
						"transaction" => $transaction
					);
				}
				else{
					$response = array(
						"status" => 0,
						"message" => "Select Accounts and Amount"
					);
				}				
			break;
		}
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
