<?php
if(!defined("APP_START")) die("No Direct Access");
if( isset( $_GET[ "id" ] ) ) {
	$id = slash( $_GET[ "id" ] );
}
else {
	$id = 0;
}
?>
<div ng-app="purchase" ng-controller="purchaseController" id="purchaseController">
    <div style="display:none">{{purchase_id=<?php echo $id?>}}</div>
    <div class="page-header">
        <h1 class="title">{{get_action()}} Purchase</h1>
        <ol class="breadcrumb">
            <li class="active">Manage Purchase</li>
        </ol>
        <div class="right">
            <div class="btn-group" role="group" aria-label="..."> <a href="purchase_manage.php" class="btn btn-light editproject">Back to List</a> </div>
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
            	<input ng-model="purchase.datetime_added" data-controllerid="purchaseController" class="form-control date-timepicker angular-datetimepicker" />
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-sm-2 control-label">
                <label class="form-label" for="supplier_id">Supplier Name <span class="manadatory">*</span></label>
            </div>
            <div class="col-sm-10">
                <select class="margin-btm-5" ng-model="purchase.supplier.id">
                    <option value="">Select Supplier</option>
                   	<option ng-repeat="supplier in suppliers" value="{{ supplier.id }}">{{ supplier.name }}</option>
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
            	<textarea ng-model="purchase.notes" class="form-control">{{purchase.notes}}</textarea>
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
                                <!-- <th width="25%">Item Category</th> -->
                                <th width="25%">Items</th>
                                <th width="5%">Return</th>
                                <th class="text-right" width="13%">Purchase Price</th>
                                <!-- <th class="text-right" width="10%">Sale Price</th> -->
                                <th class="text-right" width="10%">Total Items</th>
                                <th class="text-right" width="10%">Total Price</th>
                                <th class="text-center" width="10%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="item in purchase.items">
                                <td class="text-center serial_number">{{ $index+1 }}</td>
                                <!-- <td>
                                    <select title="Choose Option" ng-model="purchase.items[ $index ].item_category_id" data-ng-options="category.id as category.title for category in categories" chosen convert-to-number>
                                        <option value="">Select Category</option>
                                        <option ng-repeat="category in categories" value="{{ category.id }}">{{ category.title }}</option>
                                    </select>
                                </td> -->
                                <td>
                                    <select title="Choose Option" ng-model="purchase.items[ $index ].item_id" data-ng-options="item.id as item.title for item in items" ng-change="getItems(purchase.items[ $index ].item_id, item)" chosen convert-to-number>
                                        <!-- <option value="">Select Items</option> -->
                                        <!-- <option ng-repeat="item in items|filter:{item_category_id: sales.items[ $index ].item_category_id}:1" value="{{ item.id }}">{{ item.title }}</option> -->
                                    </select>
                                </td>
                                <td><input type="checkbox" ng-model="purchase.items[ $index ].return" ng-click="purchase_return($index)" /></td>
                                <td class="text-right"><input type="text" ng-model="purchase.items[ $index ].purchase_price" ng-change="update_total( $index )" /></td>
                                <!-- <td class="text-right"><input type="text" ng-model="purchase.items[ $index ].sale_price" ui-mask="{{numberMask}}" /></td> -->
                                <td class="text-right"><input type="text" ng-change="update_total( $index )" ng-model="purchase.items[ $index ].quantity" /></td>
                                <td class="text-right"><input type="text" ng-model="purchase.items[ $index ].total" /></td>                        
                                <td class="text-center"><a href="" ng-click="add( $index )">Add</a> - <a href="" ng-click="remove( $index )">Delete</a><span ng-show="purchase.items[ $index ].id>0"> - <a href="purchase_manage.php?tab=single_print_item&id={{purchase.items[ $index ].id}}&count={{purchase.items[ $index ].quantity}}" target="_blank">Print</a></span></td>
                            </tr>
                            <tr>
                                <th colspan="5" class="text-right">Total Items</th>
                                <th class="text-right">{{ purchase.quantity }}</th>
                                <th class="text-right">&nbsp;</th>
                            </tr>
                            <tr>
                                <th colspan="5" class="text-right">Total</th>
                                <th class="text-right"><input type="text" style="text-align:right" ng-model="purchase.total" ng-change='update_net_total()' /></th>
                                <th class="text-right">&nbsp;</th>
                            </tr>
                            <tr>
                                <th colspan="5" class="text-right">Discount</th>
                                <th class="text-right"><input type="text" id="discount" style="text-align:right" ng-model="purchase.discount" ng-change='update_net_total()' /></th>
                                <th class="text-right">&nbsp;</th>
                            </tr>
                            <tr>
                                <th colspan="5" class="text-right">Net Total</th>
                                <th class="text-right"><input type="text" id="total" style="text-align:right" ng-model="purchase.net_total" /></th>
                                <th class="text-right">&nbsp;</th>
                            </tr>
                            <tr>
                                <th class="text-right" colspan="1">Notes</th>
                                <th class="text-right" colspan="6"><textarea ng-model="purchase.notes" class="form-control">{{sales.notes}}</textarea></th>
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
                <button type="submit" ng-disabled="processing" class="btn btn-default btn-l" ng-click="save_purchase()" title="Submit Record"><i class="fa fa-spin fa-gear" ng-show="processing"></i> SUBMIT</button>
            </div>
        </div>
    </div>
</div>