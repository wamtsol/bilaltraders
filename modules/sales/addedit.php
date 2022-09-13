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
	<?php
        $i=0;
    ?>
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
                <select class="margin-btm-5" ng-model="sales.customer_id">
                    <option value="0">Cash</option>
                   	<option ng-repeat="customer in customers" value="{{ customer.id }}">{{ customer.name }}</option>
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-sm-2 control-label">
                <label class="form-label" for="phone">Phone</label>
            </div>
            <div class="col-sm-10">
                <input type="text" title="Enter Contact Number" name="phone" id="phone" class="form-control" ng-model="sales.customer.phone" >
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-sm-2 control-label">
                <label class="form-label" for="address">Address</label>
            </div>
            <div class="col-sm-10">
                <input type="text" title="Enter Address" name="address" id="address" class="form-control" ng-model="sales.customer.address">
            </div>
        </div>
    </div>
    
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
                                <th width="25%">Items <input type="text" placeholder="Item ID" style="width: 100px; float:right" ng-model="item_id" ng-keypress="addItemM($event)" /></th>
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
                                <td>
                                    <select title="Choose Option" ng-model="sales.items[$index].purchase_item_id" ng-change='update_sale_item( $index )'>
                                        	<option value="">Select Items</option>
                                        	<option ng-repeat="purchase_item in purchase_items" ng-if="not_listed( purchase_item.id, $parent.$index )" value="{{ purchase_item.id }}">{{ purchase_item.item_name }} (ID# {{ purchase_item.id }})</option>
                                        
                                    </select>
                                </td>
                                <td class="text-right">{{ sales.items[$index].sale_price|currency:'Rs. ':0 }}</td>
                                <td class="text-right"><input type="text" ng-change="update_total( $index )" ng-model="sales.items[$index].quantity" /><br />Available: {{ get_available_quantity( $index ) }} </td>
                                <td class="text-right"><input type="text" ng-model="sales.items[$index].discount" ng-change='update_total( $index )' /></td>
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
                                <th colspan="5" class="text-right">Net Total</th>
                                <th class="text-right"><input type="text" id="total" style="text-align:right" ng-model="sales.net_total" /></th>
                                <th class="text-right">&nbsp;</th>
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