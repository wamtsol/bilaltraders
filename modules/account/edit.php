<?php
if(!defined("APP_START")) die("No Direct Access");
?>
<div class="page-header">
	<h1 class="title">Edit Account</h1>
  	<ol class="breadcrumb">
    	<li class="active">Manage Account</li>
  	</ol>
  	<div class="right">
    	<div class="btn-group" role="group" aria-label="..."> <a href="account_manage.php" class="btn btn-light editproject">Back to List</a> </div>
  	</div>
</div>        	
<form class="form-horizontal form-horizontal-left" role="form" action="account_manage.php?tab=edit" method="post" enctype="multipart/form-data" name="frmAdd">
    <input type="hidden" name="id" value="<?php echo $id;?>">
    <div class="form-group">
        <div class="row">
        	<div class="col-sm-2 control-label">
            	<label class="form-label" for="title">Title </label>
            </div>
            <div class="col-sm-10">
                <input type="text" title="Enter Title" value="<?php echo $title; ?>" name="title" id="title" class="form-control" />
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-sm-2 control-label">
                <label for="account_type" class="form-label">Account Type </label>
            </div>
            <div class="col-sm-10">
                <select name="type" id="type" title="Choose Option">
                    <option value="">Select Account Type</option>
                    <?php
                    foreach ($account_types as $key=>$value) {
                        ?>
                        <option value="<?php echo $key?>"<?php echo $key==$type?' selected="selected"':""?>><?php echo $value ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
        	<div class="col-sm-2 control-label">
            	<label class="form-label" for="is_petty_cash">Petty Cash </label>
            </div>
            <div class="col-sm-10">
                <select name="is_petty_cash" id="is_petty_cash" title="Choose Option">
                    <option value="">Select Petty Cash</option>

                    <option value="1"<?=$is_petty_cash == '1' ? ' selected="selected"' : '';?>" >Yes</option>
                    <option value="0"<?=$is_petty_cash == '0' ? ' selected="selected"' : '';?>" >No</option>
                    
                    </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
        	<div class="col-sm-2 control-label">
            	<label class="form-label" for="balance">Balance </label>
            </div>
            <div class="col-sm-10">
                <input type="text" title="Enter Balance" value="<?php echo $balance; ?>" name="balance" id="balance" class="form-control" />
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
        	<div class="col-sm-2 control-label">
            	<label class="form-label" for="description">Description </label>
            </div>
            <div class="col-sm-10">
                <textarea title="Enter Description" name="description" id="description" class="form-control"><?php echo $description; ?></textarea>
            </div>
        </div>
    </div>
    <div class="form-group">
    	<div class="row">
            <div class="col-sm-2 control-label">
                <label for="company" class="form-label"></label>
            </div>
            <div class="col-sm-10">
                <input type="submit" value="Update" class="btn btn-default btn-l" name="account_edit" title="Update Record" />
            </div>
        </div>
  	</div>
</form>