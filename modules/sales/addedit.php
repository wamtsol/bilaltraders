<?php
if(!defined("APP_START")) die("No Direct Access");
if( isset( $_GET[ "id" ] ) ) {
	$id = slash( $_GET[ "id" ] );
}
else {
	$id = 0;
}
?>
<style>
.popup-content .page-header{
	display:none !important;
}
.popup-content .form-group .col-sm-2{
	display: block;
	float: none;
	text-align: left;
	width: 100%;
}
.popup-content .form-group .col-sm-10{
	width: 100%;
	float: none;
}
.popup-content .content{
	padding-left: 15px;
	padding-right: 15px;
}
.popup-content .col-sm-offset-2{
	margin-left:0;
}
</style>
<div ng-app="sales" ng-controller="salesController" id="salesController">
    <div style="display:none">{{sales_id=<?php echo $id?>}}</div>
    <div class="page-header">
        <h1 class="title">{{get_action()}} Sales</h1>
        <ol class="breadcrumb">
            <li class="active">Manage Sales</li>
        </ol>
        <div class="right">
            <div class="btn-group" role="group" aria-label="..."> <a href="sales_manage.php" class="btn btn-light editproject">Back to List</a> </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-sm-2 control-label">
                <label class="form-label" for="date">Date <span class="manadatory">*</span></label>
            </div>
            <div class="col-sm-10">
            	<input ng-model="sales.datetime_added" data-controllerid="salesController" class="form-control date-timepicker angular-datetimepicker" />
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-sm-2 control-label">
                <label class="form-label" for="customer_id">Customer Name <span class="manadatory">*</span></label>
            </div>
            <div class="col-sm-10">
                <select class="margin-btm-5" ng-model="sales.customer_id" data-ng-options="customer.id as customer.business_name for customer in customers" chosen convert-to-number>
                    <option value="">Select Customer</option>
                </select>
            </div>
        </div>
    </div>
    <!-- <div class="form-group">
        <div class="row">
            <div class="col-sm-2 control-label">
                <label class="form-label" for="notes">Notes</label>
            </div>
            <div class="col-sm-10">
            	<textarea ng-model="sales.notes" class="form-control">{{sales.notes}}</textarea>
            </div>
        </div>
    </div> -->
    <!-- <div class="form-group">
        <div class="row">
            <div class="col-sm-2 control-label">
                <label class="form-label" for="shipping_charges">Shipping Charges</label>
            </div>
            <div class="col-sm-10">
            	<input ng-model="sales.shipping_charges" class="form-control" />
            </div>
        </div>
    </div> -->
    <div class="form-group">
        <div class="row">
            <div class="col-sm-2 control-label">
                <label class="form-label">Items <span class="manadatory">*</span></label>
            </div>
            <div class="col-sm-10">
                <div class="panel-body table-responsive">
                    <table class="table table-hover list">
                        <thead>
                            <tr>
                                <th width="2%" class="text-center">S.no</th>
                                <!-- <th width="25%">Item Category </th> -->
                                <th width="25%">Items </th>
                                <th width="5%">Return</th>
                                <th class="text-right" width="10%">Sale Price</th>
                                <th class="text-right" width="10%">Quantity</th>
                                <th class="text-right" width="10%">Discount</th>
                                <th class="text-right" width="10%">Total Price</th>
                                <th class="text-center" width="10%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="item in sales.items">
                                <td class="text-center serial_number">{{ $index+1 }}</td>
                                <!-- <td>
                                    <select title="Choose Option" ng-model="sales.items[ $index ].item_category_id" data-ng-options="category.id as category.title for category in categories" chosen convert-to-number>
                                        <option value="">Select Category</option>
                                        <option ng-repeat="category in categories" value="{{ category.id }}">{{ category.title }}</option>
                                    </select>
                                </td> -->
                                <td>
                                    <select title="Choose Option" ng-model="sales.items[ $index ].item_id" chosen>
                                        <!-- <option value="">Select Items</option> -->
                                        <option ng-repeat="item in items" value="{{ item.id }}">{{item.title}} ({{item.quantity}}) </option>
                                        <!-- <option ng-repeat="item in items|filter:{item_category_id: sales.items[ $index ].item_category_id}:1" value="{{ item.id }}">{{ item.title }}</option> -->
                                    </select>
                                </td>
                                <td><input type="checkbox" ng-model="sales.items[ $index ].return" ng-click="sale_return($index)" /></td>
                                <td class="text-right"><input type="text" ng-change="update_total( $index )" ng-model="sales.items[$index].sale_price" /></td>
                                <td class="text-right"><input type="text" ng-change="update_total( $index )" ng-model="sales.items[$index].quantity" /></td>
                                <td class="text-right"><input type="text" ng-change="update_total( $index )" ng-model="sales.items[$index].discount" /></td>
                                <td class="text-right">{{ sales.items[$index].total|currency:'Rs. ':0 }}</td>                        
                                <td class="text-center"><a href="" ng-click="add( $index )">Add</a> - <a href="" ng-click="remove( $index )">Delete</a></td>
                            </tr>
                            <tr>
                                <th colspan="5" class="text-right">Total Items</th>
                                <th class="text-right">{{ sales.quantity }}</th>
                                <th class="text-right">&nbsp;</th>
                            </tr>
                            <tr>
                                <th colspan="5" class="text-right">Total</th>
                                <th class="text-right"><input type="text" style="text-align:right" ng-model="sales.total" ng-change='update_net_total()' /></th>
                                <th class="text-right">&nbsp;</th>
                            </tr>
                            <tr>
                                <th colspan="5" class="text-right">Discount</th>
                                <th class="text-right"><input type="text" id="discount" style="text-align:right" ng-model="sales.discount" ng-change='update_net_total()' /></th>
                                <th class="text-right">&nbsp;</th>
                            </tr>
                            <tr>
                                <th colspan="5" class="text-right">Shipping Charges</th>
                                <th class="text-right"><input type="text" id="shipping_charges" style="text-align:right" ng-model="sales.shipping_charges" ng-change='update_net_total()' /></th>
                                <th class="text-right">&nbsp;</th>
                            </tr>
                            <tr>
                                <th colspan="5" class="text-right">Net Total</th>
                                <th class="text-right"><input type="text" id="total" style="text-align:right" ng-model="sales.net_total" /></th>
                                <th class="text-right">&nbsp;</th>
                            </tr>
                            <tr>
                                <th class="text-right" colspan="5"><label>Payment Account </label></th>
                                <th class="text-right" colspan="2">
                                    <select class="margin-btm-5" ng-model="sales.payment_account_id" convert-to-number>
                                        <option value="">Select Account</option>
                                        <option ng-repeat="account in accounts" value="{{account.id}}">{{account.title}}</option>
                                    </select>
                                </th>
                            </tr>
                            <tr>
                                <th class="text-right" colspan="5">Payment Amount</th>
                                <th class="text-right" colspan="2"><input type="text" style="text-align:right" ng-model="sales.payment_amount" /></th>
                            </tr>
                            <tr>
                                <th class="text-right" colspan="1">Notes</th>
                                <th class="text-right" colspan="6"><textarea ng-model="sales.notes" class="form-control">{{sales.notes}}</textarea></th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-sm-offset-2 col-sm-10">
            	<div class="alert alert-danger" ng-show="errors.length > 0">
                	<p ng-repeat="error in errors">{{error}}</p>
                </div>
                <button type="submit" ng-disabled="processing" class="btn btn-default btn-l" ng-click="save_sale()" title="Submit Record"><i class="fa fa-spin fa-gear" ng-show="processing"></i> SUBMIT</button>
            </div>
        </div>
    </div>
</div>