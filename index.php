<?php 
include("include/db.php");
include("include/utility.php");
include("include/session.php");
define("APP_START", 1);
if( isset( $_GET[ "close" ] ) ) {
	doquery( "insert into closing_activity values('', NOW(), '".$_SESSION[ "logged_in_admin" ][ "id" ]."')", $dblink );
	header( "Location: index.php" );
	die;
}
include("modules/dashboard/ajax.php");
$page="index";
?>
<?php include("include/header.php");?>		
   	<div class="page-header">
        <h1 class="title">Dashboard</h1>
        <ol class="breadcrumb">
            <li class="active">Welcome to <?php echo $site_title?> Dashboard.</li>
        </ol>
    </div>
    <div ng-app="dashboard" ng-controller="dashboardController" id="dashboardController">
    	<div ng-if="errors.length > 0" class="errors">
        	<div ng-repeat="error in errors" class="alert alert-danger">{{error}}</div>
        </div>
    	<!--<div class="item_number">
        	<label for="item_number">
            	Enter Item Number
            </label>
            <input type="text" name="item_number" id="item_number2" ng-model="item_number" ng-enter="add_item_with_id()" />
        </div>-->
        <div class="row clearfix">
        	<div class="col-md-3">
            	<table class="table table-hover list">
                	<tr>
                    	<th colspan="2">Summary <a style="float:right" href="index.php?close" class="btn btn-small btn-danger" onClick="return confirm('Are you sure you want to slose this session?')">Close Session</a></th>
                    </tr>
                    <tr>
                        <th class="text-right">Total Items Sold Today:</th>
                        <th class="text-right">{{ orders_total_items(orders) }}</th>
                    </tr>
                    <tr ng-repeat="category in categories">
                        <td colspan="2">
                        	<table class="table table-hover list" style="margin-bottom:0;">
                				<tr>
                                	<th class="text-right" width="60%">{{category.title}}:</th>
                        			<th class="text-right">{{ orders_total_kg(orders, category.id) }}</th>
                              	</tr>
                                <tr ng-repeat="product in category.products">
                                	<th class="text-right">{{product.title}}:</th>
                        			<th class="text-right">{{ orders_total_product_kg(orders, product.id) }} {{ product.type=="2"?"Kg":"Nos."}}</th>
                              	</tr>
                          	</table>
                       	</td>
                    </tr>
                    <tr>
                        <th class="text-right">Total Sale:</th>
                        <th class="text-right">{{ orders_total(orders)|currency:'Rs. ':0 }}</th>
                    </tr>
                    <tr>
                        <th class="text-right">Total Sale Return:</th>
                        <th class="text-right">{{ orders_return_total(orders_return)|currency:'Rs. ':0 }}</th>
                    </tr>
                    <tr>
                        <th class="text-right">Cash Sale:</th>
                        <th class="text-right">{{ orders_total(orders, 0)|currency:'Rs. ':0 }}</th>
                    </tr>
                    <tr>
                        <th class="text-right">Customer's Sale:</th>
                        <th class="text-right">{{ orders_total(orders, 1)|currency:'Rs. ':0 }}</th>
                    </tr>
                    <tr>
                        <th class="text-right">Customer's Payments:</th>
                        <th class="text-right">{{ customer_payment_total(0)|currency:'Rs. ':0 }}</th>
                    </tr>
                    <tr>
                        <th class="text-right">Supplier's Payments:</th>
                        <th class="text-right">{{ supplier_payment_total(0)|currency:'Rs. ':0 }}</th>
                    </tr>
                    <tr>
                        <th class="text-right">Total Expense:</th>
                        <th class="text-right">{{ expense_total()|currency:'Rs. ':0 }}</th>
                    </tr>
                    <tr>
                        <th class="text-right">Cash in Hand:</th>
                        <th class="text-right">{{ cash_in_hand()|currency:'Rs. ':0 }}</th>
                    </tr>
                </table>
            </div>
            <div class="col-md-9">
            	<div class="tabs">
                	<ul>
                    	<li><a href="#sales">Sales</a></li>
                        <li><a href="#sales_return">Sales Return</a></li>
                    </ul>
                    <div id="sales">
            			<div class=""><a href="sales_manage.php?tab=addedit" class="btn btn-default btn-l fancybox_iframe">Add New Sale</a></div>
                        <div id="total-sale">
                            <h2 class="total-heading">Total Sales</h2>
                            <div id="cart" class="panel-body table-responsive">
                                <table width="100%" class="table table-hover list">
                                    <thead>
                                        <tr>
                                            <th width="5%">S.N</th>
                                            <th width="20%">Time</th>
                                            <th width="40%">Items</th>
                                            <th width="10%" class="text-right">Total Items</th>
                                            <th width="10%" class="text-right">Discount</th>
                                            <th width="10%" class="text-right">Price</th>
                                            <th width="15%" class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tr ng-repeat="order in orders">
                                        <td>{{ $index+1 }}</td>
                                        <td>{{ order.datetime_added }}</td>
                                        <td>
                                        <ul>
                                            <li ng-repeat="item in order.items">{{ item.quantity }} x {{ item.item_name }}</li>
                                        </ul>
                                        </td>
                                        <td class="text-right">{{ order_total_items(order) }}</td>
                                        <td class="text-right">{{ order.discount }}</td>
                                        <td class="text-right">{{ order_total(order)|currency:'Rs. ':0 }}</td>
                                        <td class="text-center">
                                            <a href="" title="Print" ng-click="print_receipt(order.id)"><i class="fa fa-print" aria-hidden="true"></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="5" class="text-right">Total Items Sold Today:</th>
                                        <th colspan="2" class="text-right">{{ orders_total_items(orders) }}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="5" class="text-right">Total Amount:</th>
                                        <th colspan="2" class="text-right">{{ orders_total(orders)|currency:'Rs. ':0 }}</th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                    <div id="sales_return">
                        <div class=""><a href="sales_return_manage.php?tab=addedit" class="btn btn-default btn-l fancybox_iframe">Add New Sale Return</a></div>
                        <div id="total-sale">
                            <h2 class="total-heading">Total Sales Return</h2>
                            <div id="cart" class="panel-body table-responsive">
                                <table width="100%" class="table table-hover list">
                                    <thead>
                                        <tr>
                                            <th width="5%">S.N</th>
                                            <th width="20%">Time</th>
                                            <th width="40%">Items</th>
                                            <th width="10%" class="text-right">Total Items</th>
                                            <th width="10%" class="text-right">Discount</th>
                                            <th width="10%" class="text-right">Price</th>
                                        </tr>
                                    </thead>
                                    <tr ng-repeat="order_return in orders_return">
                                        <td>{{ $index+1 }}</td>
                                        <td>{{ order_return.datetime_added }}</td>
                                        <td>
                                        <ul>
                                            <li ng-repeat="item in order_return.items">{{ item.quantity }} x {{ item.item_name }}</li>
                                        </ul>
                                        </td>
                                        <td class="text-right">{{ order_return_total_items(order_return) }}</td>
                                        <td class="text-right">{{ order_return.discount }}</td>
                                        <td class="text-right">{{ order_return_total(order_return)|currency:'Rs. ':0 }}</td>
                                    </tr>
                                    <tr>
                                        <th colspan="4" class="text-right">Total Items Return Today:</th>
                                        <th colspan="2" class="text-right">{{ orders_return_total_items(orders_return) }}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="4" class="text-right">Total Amount:</th>
                                        <th colspan="2" class="text-right">{{ orders_return_total(orders_return)|currency:'Rs. ':0 }}</th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        <div class="fancybox-btn">
            <a href="#total-expense" class="btn btn-default btn-l">Expenses</a>
            <a href="#customer-payment" class="btn btn-default btn-l">Customer's Payments</a>
            <a href="#supplier-payment" class="btn btn-default btn-l">Supplier's Payments</a>
            <a href="#fund-transfer" class="btn btn-default btn-l">Fund Transfers</a>
        </div>
        <div id="total-expense" class="fancybox-frame">
        	<h2 class="total-heading">Expenses</h2>
            <table width="100%" class="table table-hover list">
            	<thead>
            	<tr>
                    <td colspan="6">
                        <form class="form-horizontal expense-form">
                            <div class="row clearfix">
                                <div class="col-md-3">
                                    <label>Select Expense Category</label>
                                    <select ng-model="new_expense.expense_category_id" style="font-size: 14px; color:#000">
                                        <option value="">Select Expense Category</option>
                                        <option ng-repeat="expense_cat in expense_categories" value="{{expense_cat.id}}">{{expense_cat.title}}</option>
                                    </select>
                                </div>
                                <div class="col-md-3 padding-none">
                                    <label>Enter Details</label>
                                    <textarea class="form-control" placeholder="Details" ng-model="new_expense.details"></textarea>
                                </div>
                                <div class="col-md-2">
                                    <label>Enter Amount</label>
                                    <input type="text" ng-model="new_expense.amount" id="amount" class="form-control text-right" placeholder="Amount">
                                </div>
                                <div class="col-md-3">
                                    <label>Paid By</label>
                                    <select ng-model="new_expense.account_id" style="font-size: 14px; color:#000">
                                        <option value="">Select Account</option>
                                        <option ng-repeat="account in accounts" value="{{account.id}}">{{account.title}}</option>
                                    </select>
                                </div>
                                <div class="col-md-1 text-right padding-none">
                                    <label>&nbsp;</label>
                                    <input type="button" class="btn btn-default btn-l" value="Save" ng-click="add_expense()">
                                </div>
                            </div>
                        </form>
                    </td>
                </tr>
                </thead>
                <tr>
                    <th width="5%">S.N</th>
                    <th width="20%">Time</th>
                    <th width="20%">Expense Category</th>
                    <th width="35%">Details</th>
                    <th width="10%" class="text-right">Amount</th>
                    <th width="10%">Paid By</th>
                </tr>
                <tr ng-repeat="expense in expenses">
                    <td>{{ $index+1 }}</td>
                    <td>{{ expense.datetime_added }}</td>
                    <td>{{ expense.expense_category_id }}</td>
                    <td>{{ expense.details }}</td>
                    <td class="text-right">{{ expense.amount|currency:'Rs. ':0 }}</td>
                    <td>{{ expense.account }}</td>
                </tr>
                <tr bgcolor="#EFF7FF">
                    <th colspan="5" class="text-right">Total Expense Today:</th>
                    <th colspan="1" class="text-right">{{ expense_total()|currency:'Rs. ':0 }}</th>
                </tr>
                <tr bgcolor="#EFF7FF">
                    <th colspan="5" class="text-right">Total Cash:</th>
                    <th colspan="1" class="text-right">{{  expense_total(0)|currency:'Rs. ':0 }}</th>
                </tr>
            </table>
        </div>
        <div id="customer-payment" class="fancybox-frame">
        	<h2 class="total-heading">Customer's Payments</h2>
            <table width="100%" class="table table-hover list">
                <thead>
                	<tr>
                        <td colspan="6">
                            <form class="form-horizontal expense-form">
                                <div class="row clearfix">
                                    <div class="col-md-3">
                                        <label>Select Customer</label>
                                        <select ng-model="new_customer_payment.customer_id" style="font-size: 14px; color:#000">
                                            <option value="">Select Customer</option>
                                            <option value="0">Cash</option>
                                            <option ng-repeat="customer in customers" value="{{customer.id}}">{{customer.name}}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 padding-none">
                                        <label>Enter Details</label>
                                        <textarea class="form-control" placeholder="Details" ng-model="new_customer_payment.details"></textarea>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Enter Amount</label>
                                        <input type="text" ng-model="new_customer_payment.amount" id="amount" class="form-control text-right" placeholder="Amount">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Paid to</label>
                                        <select ng-model="new_customer_payment.account_id" style="font-size: 14px; color:#000">
                                            <option value="">Select Account</option>
                                            <option ng-repeat="account in accounts" value="{{account.id}}">{{account.title}}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-1 text-right padding-none">
                                        <label>&nbsp;</label>
                                        <input type="button" class="btn btn-default btn-l" value="Save" ng-click="add_customer_payment()">
                                    </div>
                                </div>
                            </form>
                        </td>
                	</tr>
                </thead>
                <tr>
                    <th width="5%">S.N</th>
                    <th width="20%">Time</th>
                    <th width="20%">Customer Name</th>
                    <th width="25%">Details</th>
                    <th width="15%" class="text-right">Amount</th>
                    <th width="15">Paid to</th>
                </tr>
                <tr ng-repeat="customer_payment in customer_payments">
                    <td>{{ $index+1 }}</td>
                    <td>{{ customer_payment.datetime_added }}</td>
                    <td>{{ customer_payment.customer_id }}</td>
                    <td>{{ customer_payment.details }}</td>
                    <td class="text-right">{{ customer_payment.amount|currency:'Rs. ':0 }}</td>
                    <td>{{ customer_payment.account }}</td>
                    
                </tr>
                <tr bgcolor="#EFF7FF">
                    <th colspan="5" class="text-right">Total Payments Today:</th>
                    <th colspan="1" class="text-right">{{ customer_payment_total()|currency:'Rs. ':0 }}</th>
                </tr>
                <tr bgcolor="#EFF7FF">
                    <th colspan="5" class="text-right">Total Cash:</th>
                    <th colspan="1" class="text-right">{{  customer_payment_total(0)|currency:'Rs. ':0 }}</th>
                </tr>
            </table>
        </div>
        <div id="supplier-payment" class="fancybox-frame">
        	<h2 class="total-heading">Supplier's Payments</h2>
            <table width="100%" class="table table-hover list">
                <thead>
                	<tr>
                        <td colspan="6">
                            <form class="form-horizontal expense-form">
                                <div class="row clearfix">
                                    <div class="col-md-3">
                                        <label>Select Supplier</label>
                                        <select ng-model="new_supplier_payment.supplier_id" style="font-size: 14px; color:#000">
                                            <option value="">Select Supplier</option>
                                            <option ng-repeat="supplier in suppliers" value="{{supplier.id}}">{{supplier.name}}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Enter Details</label>
                                        <textarea class="form-control" placeholder="Details" ng-model="new_supplier_payment.details"></textarea>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Enter Amount</label>
                                        <input type="text" ng-model="new_supplier_payment.amount" id="amount" class="form-control text-right" placeholder="Amount">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Paid By</label>
                                        <select ng-model="new_supplier_payment.account_id" style="font-size: 14px; color:#000">
                                            <option value="">Select Account</option>
                                            <option ng-repeat="account in accounts" value="{{account.id}}">{{account.title}}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-1 text-right padding-none">
                                        <label>&nbsp;</label>
                                        <input type="button" class="btn btn-default btn-l" value="Save" ng-click="add_supplier_payment()">
                                    </div>
                                </div>
                            </form>
                        </td>
                	</tr>
                </thead>
                <tr>
                    <th width="5%">S.N</th>
                    <th width="20%">Time</th>
                    <th width="20%">Supplier Name</th>
                    <th width="25%">Details</th>
                    <th width="15%" class="text-right">Amount</th>
                    <th width="15">Paid By</th>                    
                </tr>
                <tr ng-repeat="supplier_payment in supplier_payments">
                    <td>{{ $index+1 }}</td>
                    <td>{{ supplier_payment.datetime_added }}</td>
                    <td>{{ supplier_payment.supplier_id }}</td>
                    <td>{{ supplier_payment.details }}</td>
                    <td class="text-right">{{ supplier_payment.amount|currency:'Rs. ':0  }}</td>
                    <td>{{ supplier_payment.account }}</td>                    
                </tr>
                <tr bgcolor="#EFF7FF">
                    <th colspan="5" class="text-right">Total Payments Today:</th>
                    <th colspan="1" class="text-right">{{ supplier_payment_total()|currency:'Rs. ':0 }}</th>
                </tr>
                <tr bgcolor="#EFF7FF">
                    <th colspan="5" class="text-right">Total Cash:</th>
                    <th colspan="1" class="text-right">{{  supplier_payment_total(0)|currency:'Rs. ':0 }}</th>
                </tr>
            </table>
        </div>
        <div id="fund-transfer" class="fancybox-frame">
        	<h2 class="total-heading">Fund Transfers</h2>
            <table width="100%" class="table table-hover list">
                <thead>
                	<tr>
                        <td colspan="6">
                            <form class="form-horizontal expense-form">
                                <div class="row clearfix">
                                    <div class="col-md-3">
                                        <label>From Account</label>
                                        <select ng-model="new_transaction.account_id" style="font-size: 14px; color:#000">
                                            <option value="">Select Account</option>
                                            <option ng-repeat="account in accounts" value="{{account.id}}">{{account.title}}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>To Account</label>
                                        <select ng-model="new_transaction.reference_id" style="font-size: 14px; color:#000">
                                            <option value="">Select Account</option>
                                            <option ng-repeat="account in accounts" value="{{account.id}}">{{account.title}}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Enter Amount</label>
                                        <input type="text" ng-model="new_transaction.amount" id="amount" class="form-control text-right" placeholder="Amount">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Enter Details</label>
                                        <textarea class="form-control" placeholder="Details" ng-model="new_transaction.details"></textarea>
                                    </div>
                                    <div class="col-md-1 text-right padding-none">
                                        <label>&nbsp;</label>
                                        <input type="button" class="btn btn-default btn-l" value="Save" ng-click="add_transaction()">
                                    </div>
                                </div>
                            </form>
                        </td>
                	</tr>
                </thead>
                <tr>
                    <th width="5%">S.N</th>
                    <th width="20%">Time</th>
                    <th width="20%">From Account</th>
                    <th width="20%">To Account</th>
                    <th width="10%" class="text-right">Amount</th>
                    <th width="25%">Details</th>
                </tr>
                <tr ng-repeat="transaction in transactions">
                    <td>{{ $index+1 }}</td>
                    <td>{{ transaction.datetime_added }}</td>
                    <td>{{ transaction.account }}</td>
                    <td>{{ transaction.reference }}</td>
                    <td class="text-right">{{ transaction.amount|currency:'Rs. ':0 }}</td>
                    <td>{{ transaction.details }}</td>
                </tr>
                <tr bgcolor="#EFF7FF" ng-repeat="account in accounts">
                    <th colspan="5" class="text-right">{{account.title}}:</th>
                    <th colspan="1" class="text-right">{{ transaction_total(account.id, account.balance)|currency:'Rs. ':0 }}</th>
                </tr>
            </table>
        </div>
    </div>
</div>
<style>

.items_variations {
    background-color: #fff;
    left: 50%;
    max-height: 95%;
    overflow-y: auto;
    position: absolute;
    top: 50%;
    transform: translate(-50%, -50%);
    width: 320px;
}
.items_variation {
    border-bottom: 1px solid;
    padding: 10px 40px;
    position: relative;
}
.items_variation:nth-child(2n) {
    background-color: #efe;
}
.items_variation:hover {
    background-color: #eee;
}
.items_variation .cart-btn {
	cursor:pointer;
    height: 100%;
    position: absolute;
    text-align: center;
    top: 0;
    width: 32px;
	cursor:pointer;
}
.items_variation .cart-btn.dec{
	background-color: #FF9;
	color:#f00;
	left: 0;
}
.items_variation .cart-btn.inc{
	background-color: #9F9;
	color: #00f;
	right: 0;
}
.items_variations_container {
    background-color: rgba(0, 0, 0, 0.9);
    height: 100%;
    position: fixed;
    width: 100%;
	left:0;
	top:0;
	z-index:9999;
}
.items_variations h2 {
    background-color: #352B6F;
	color:#fff;
    font-size: 16px;
    line-height: 24px;
    margin: 0;
    padding: 10px;
	color:#fff;
}
.items_variations .close-btn {
    border-radius: 50%;
    color: #f00;
    display: block;
    height: 30px;
    line-height: 30px;
    position: absolute;
    right: 10px;
    text-align: center;
    top: 5px;
    width: 30px;
	font-size:20px;
	cursor:pointer;
}
.cart-btn .fa {
    left: 50%;
    position: absolute;
    top: 50%;
    transform: translate(-50%, -50%);
}

.item-img-hover span.select-variation {
    color: #fff;
    font-size: 18px !important;
    font-weight: bold;
}

.items-margin input {
    color: #000;
    padding: 0;
    text-align: center;
    width: 80px;
}

</style>
<?php include("include/footer.php");?>