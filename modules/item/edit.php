<?php
if(!defined("APP_START")) die("No Direct Access");
?>
    <div class="page-header">
        <h1 class="title">Update Item </h1>
        <ol class="breadcrumb">
            <li class="active">Manage Items</li>
        </ol>
        <div class="right">
            <div class="btn-group" role="group" aria-label="..."> <a href="items_manage.php" class="btn btn-light editproject">Back to List</a> </div>
        </div>
       
    </div><!-- /.page-header -->


            <form class="form-horizontal" role="form" action="items_manage.php?tab=edit" method="post" enctype="multipart/form-data" name="frmAdd"  onSubmit="return checkFields();">
                <input type="hidden" name="id" value="<?php echo $id;?>">
                <?php

                $i=0;

                ?>

                <div class="form-group">

                    <div class="row">

                        <label class="col-sm-3 control-label no-padding-right" for="title">Item Category <span class="red">*</span> </label>

                        <div class="col-sm-9">

                            <select name="item_category_id" id="item_category_id" title="Choose Option">-->
                                <option value="0">Select Item Category</option>
                                    <?php
                                    $res=doquery("Select * from item_category ",$dblink);
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

                <label class="col-sm-3 control-label no-padding-right" for="">Unit</label>

                <div class="col-sm-9">

                    <input type="text" value="<?php echo $unit; ?>" name="unit" id="unit" class="form-control" title="Enter Unit">

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

                    <label class="col-sm-3 control-label no-padding-right" for="">Sort Order</label>

                    <div class="col-sm-9">

                        <input type="text" value="<?php echo $sortorder; ?>" name="sortorder" id="sortorder" class="form-control" title="Enter Sort Order">

                    </div>

                </div>

                </div>

                <div class="clearfix form-actions">

                    <div class="row">

                        <div class="col-md-offset-3 col-md-9">

                            <button class="btn btn-info" type="submit" name="items_edit" title="Submit Record">

                                <i class="ace-icon fa fa-check bigger-110"></i>

                                Submit

                            </button>

                        </div>

                    </div>

                </div>

            </form>

            <!-- PAGE CONTENT ENDS -->