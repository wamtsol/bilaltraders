<?php
if(!defined("APP_START")) die("No Direct Access");
$q="";
$extra='';
$is_search=false;
if( isset($_GET["date"]) ){
	$_SESSION["transaction"]["list"]["date"] = $_GET["date"];
}
if(isset($_SESSION["transaction"]["list"]["date"]) && !empty($_SESSION["transaction"]["list"]["date"])){
	$date = $_SESSION["transaction"]["list"]["date"];
}
else{
	$date = "";
}
if( !empty($date) ){
	$extra=" and datetime_added>='".date("Y/m/d H:i:s", strtotime(date_dbconvert($date)))."' and datetime_added<'".date("Y/m/d H:i:s", strtotime(date_dbconvert($date))+3600*24)."'";
	$is_search=true;
}
if(isset($_GET["reference_id"])){
	$reference_id=slash($_GET["reference_id"]);
	$_SESSION["transaction"]["list"]["reference_id"]=$reference_id;
}
if(isset($_SESSION["transaction"]["list"]["reference_id"]))
	$reference_id=$_SESSION["transaction"]["list"]["reference_id"];
else
	$reference_id="";
if($reference_id!=""){
	$extra.=" and reference_id='".$reference_id."'";
	$is_search=true;
}
if(isset($_GET["account_id"])){
	$account_id=slash($_GET["account_id"]);
	$_SESSION["transaction"]["list"]["account_id"]=$account_id;
}
if(isset($_SESSION["transaction"]["list"]["account_id"]))
	$account_id=$_SESSION["transaction"]["list"]["account_id"];
else
	$account_id="";
if($account_id!=""){
	$extra.=" and account_id='".$account_id."'";
	$is_search=true;
}
?>
<div class="page-header">
	<h1 class="title">Transaction</h1>
  	<ol class="breadcrumb">
    	<li class="active">Manage Transactions</li>
  	</ol>
  	<div class="right">
    	<div class="btn-group" role="group" aria-label="..."> 
        	<a href="transaction_manage.php?tab=add" class="btn btn-light editproject">Add New Transaction</a> 
            <a id="topstats" class="btn btn-light" href="#"><i class="fa fa-search"></i></a> 
    	</div> 
    </div> 
</div>
<ul class="topstats clearfix search_filter"<?php if($is_search) echo ' style="display: block"';?>>
    <li class="col-xs-12 col-lg-12 col-sm-12">
    	<div>
        	<form class="form-horizontal" action="" method="get">
            	<div class="col-sm-3 margin-btm-5">
                	<select name="account_id" id="account_id" class="custom_select">
                        <option value=""<?php echo ($account_id=="")? " selected":"";?>>Select Account To</option>
                        <?php
                            $res=doquery("select * from account order by title",$dblink);
                            if(numrows($res)>=0){
                                while($rec=dofetch($res)){
                                ?>
                                <option value="<?php echo $rec["id"]?>" <?php echo($account_id==$rec["id"])?"selected":"";?>><?php echo unslash($rec["title"])?></option>
                            	<?php
                                }
                            }	
                        ?>
                    </select>
                </div>
            	<div class="col-sm-3 margin-btm-5">
                	<select name="reference_id" id="reference_id" title="Choose Option">
                        <option value=""<?php echo ($reference_id=="")? " selected":"";?>>Select Account From</option>
                        <?php
                            $res=doquery("select * from account order by title",$dblink);
                            if(numrows($res)>=0){
                                while($rec=dofetch($res)){
                                ?>
                                <option value="<?php echo $rec["id"]?>" <?php echo($reference_id==$rec["id"])?"selected":"";?>><?php echo unslash($rec["title"])?></option>
                            	<?php
                                }
                            }	
                        ?>
                    </select>
                </div>
                <div class="col-sm-3 margin-btm-5">
                  <input type="text" title="Enter String" value="<?php echo $date;?>" name="date" id="search" class="form-control date-picker" >  
                </div>
                <div class="col-sm-3 text-left">
                    <input type="button" class="btn btn-danger btn-l reset_search" value="Reset" alt="Reset Record" title="Reset Record" />
                    <input type="submit" class="btn btn-default btn-l" value="Search" alt="Search Record" title="Search Record" />
                </div>
            </form>
        </div>
  	</li>
</ul>
<div class="panel-body table-responsive">
	<table class="table table-hover list">
    	<thead>
            <tr>
                <th width="5%">S.No</th>
                <th class="text-center" width="5%"><div class="checkbox checkbox-primary">
                    <input type="checkbox" id="select_all" value="0" title="Select All Records">
                    <label for="select_all"></label></div></th>
                <th width="20%">Account To</th>
                <th width="20%">Account From</th>
                <th width="15%">Date/Time</th>
                <th width="15%">Ammount</th>
                <th width="10%" class="text-center">Status</th>
                <th width="10%" class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $sql="select * from transaction where 1 $extra";
            $rs=show_page($rows, $pageNum, $sql);
            if(numrows($rs)>0){
                $sn=1;
                while($r=dofetch($rs)){             
                    ?>
                    <tr>
                        <td><?php echo $sn;?></td>
                        <td class="text-center"><div class="checkbox margin-t-0 checkbox-primary">
                            <input type="checkbox" name="id[]" id="<?php echo "rec_".$sn?>"  value="<?php echo $r["id"]?>" title="Select Record" />
                            <label for="<?php echo "rec_".$sn?>"></label></div>
                        </td>
                        <td><?php if($r["account_id"]==0) echo "Cash"; else echo get_field($r["account_id"], "account","title");?></td>
                        <td><?php if($r["reference_id"]==0) echo "Default"; else echo get_field($r["reference_id"], "account","title");?></td>
                        <td><?php echo datetime_convert($r["datetime_added"]); ?></td>
                        <td><?php echo curr_format(unslash($r["amount"])); ?></td>
                        <td class="text-center">
                            <a href="transaction_manage.php?id=<?php echo $r['id'];?>&tab=status&s=<?php echo ($r["status"]==0)?1:0;?>">
                                <?php
                                if($r["status"]==0){
                                    ?>
                                    <img src="images/offstatus.png" alt="Off" title="Set Status On">
                                    <?php
                                }
                                else{
                                    ?>
                                    <img src="images/onstatus.png" alt="On" title="Set Status Off">
                                    <?php
                                }
                                ?>
                            </a>
                        </td>
                        <td class="text-center">
                            	<a href="transaction_manage.php?tab=edit&id=<?php echo $r['id'];?>"><img title="Edit Record" alt="Edit" src="images/edit.png"></a>&nbsp;&nbsp;
                            	<a onclick="return confirm('Are you sure you want to delete')" href="transaction_manage.php?id=<?php echo $r['id'];?>&amp;tab=delete"><img title="Delete Record" alt="Delete" src="images/delete.png"></a>
                        </td>
                    </tr>  
                    <?php 
                    $sn++;
                }
                ?>
                <tr>
                    <td colspan="5" class="actions">
                        <select name="bulk_action" class="" id="bulk_action" title="Choose Action">
                            <option value="null">Bulk Action</option>
                            <option value="delete">Delete</option>
                            <option value="statuson">Set Status On</option>
                            <option value="statusof">Set Status Off</option>
                        </select>
                        <input type="button" name="apply" value="Apply" id="apply_bulk_action" class="btn btn-light" title="Apply Action"  />
                    </td>
                    <td colspan="3" class="paging" title="Paging" align="right"><?php echo pages_list($rows, "transaction", $sql, $pageNum)?></td>
                </tr>
                <?php	
            }
            else{	
                ?>
                <tr>
                    <td colspan="8"  class="no-record">No Result Found</td>
                </tr>
                <?php
            }
            ?>
        </tbody>
     </table>
</div>