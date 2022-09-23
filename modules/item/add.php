<?php
if(!defined("APP_START")) die("No Direct Access");
if(isset($_SESSION["items_manage"]["add"])){
	extract($_SESSION["items_manage"]["add"]);	
}
else{
	$item_category_id="";
	$title="";
    $unit_id="";
	$unit_price="";
    $quantity="";
	$sortorder="";
    $alert_quantity="";
}
?>
    <div class="page-header">
        <h1 class="title">Add New Item </h1>
        <ol class="breadcrumb">
            <li class="active">Manage Items</li>
        </ol>
        <div class="right">
            <div class="btn-group" role="group" aria-label="..."> <a href="items_manage.php" class="btn btn-light editproject">Back to List</a> </div>
        </div>
    </div>
    <form class="form-horizontal" role="form" action="items_manage.php?tab=add" method="post" enctype="multipart/form-data" name="frmAdd">
        <div class="form-group">
            <div class="row">
                <label class="col-sm-3 control-label no-padding-right" for="item_category_id">Item Category</label>
                <div class="col-sm-9">
                    <select name="item_category_id" title="Choose Option" class="item_select">
                        <option value="0">Select Item Category</option>
                        <?php
                        $res=doquery("Select * from `item_category` order by title",$dblink);
                        if(numrows($res)>0){
                            while($rec=dofetch($res)){
                                ?>
                                <option value="<?php echo $rec["id"]?>"<?php echo($item_category_id==$rec["id"])?"selected":"";?>><?php echo unslash($rec["title"]); ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="col-sm-3 control-label no-padding-right" for="title">Title <span class="red">*</span> </label>
                <div class="col-sm-9">
                    <input type="text" title="Enter Name" value="<?php echo $title; ?>" name="title" id="title" class="form-control" >
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="col-sm-3 control-label no-padding-right" for="unit_id">Unit</label>
                <div class="col-sm-9">
                    <select name="unit_id" title="Choose Option">
                        <option value="0">Select Unit</option>
                        <?php
                        $res=doquery("Select * from `units` order by title",$dblink);
                        if(numrows($res)>0){
                            while($rec=dofetch($res)){
                                ?>
                                <option value="<?php echo $rec["id"]?>"<?php echo($unit_id==$rec["id"])?"selected":"";?>><?php echo unslash($rec["title"]); ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="col-sm-3 control-label no-padding-right" for="">Unit Price</label>
                <div class="col-sm-9">
                    <input type="text" value="<?php echo $unit_price; ?>" name="unit_price" id="unit_price" class="form-control" title="Enter Unit Price">
                </div>
            </div>
        </div>                  
        <div class="form-group">
            <div class="row">
                <label class="col-sm-3 control-label no-padding-right" for="">Quantity</label>
                <div class="col-sm-9">
                    <input type="text" value="<?php echo $quantity; ?>" name="quantity" id="quantity" class="form-control" title="Enter Quantity">
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="col-sm-3 control-label no-padding-right" for="alert_quantity">Alert Quantity</label>
                <div class="col-sm-9">
                    <input type="text" value="<?php echo $alert_quantity; ?>" name="alert_quantity" id="alert_quantity" class="form-control" title="Enter alert quantity">
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="col-sm-3 control-label no-padding-right" for="">Sort Order</label>
                <div class="col-sm-9">
                    <input type="text" value="<?php echo $sortorder; ?>" name="sortorder" id="sortorder" class="form-control" title="Enter Sort Order">
                </div>
            </div>
        </div>
        <div class="clearfix form-actions">
            <div class="row">
                <div class="col-md-offset-3 col-md-9">
                    <button class="btn btn-info" type="submit" name="items_add" title="Submit Record">
                        <i class="ace-icon fa fa-check bigger-110"></i>
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </form>
