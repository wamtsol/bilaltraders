<?php
if(!defined("APP_START")) die("No Direct Access");
$q="";
$extra='';
$is_search=false;
if(isset($_GET["date_from"])){
	$date_from=slash($_GET["date_from"]);
	$_SESSION["purchase"]["list"]["date_from"]=$date_from;
}
if(isset($_SESSION["purchase"]["list"]["date_from"]))
	$date_from=$_SESSION["purchase"]["list"]["date_from"];
else
	$date_from="";
if($date_from != ""){
	$extra.=" and datetime_added>='".date_dbconvert($date_from)."'";
	$is_search=true;
}
if(isset($_GET["date_to"])){
	$date_to=slash($_GET["date_to"]);
	$_SESSION["purchase"]["list"]["date_to"]=$date_to;
}
if(isset($_SESSION["purchase"]["list"]["date_to"]))
	$date_to=$_SESSION["purchase"]["list"]["date_to"];
else
	$date_to="";
if($date_to != ""){
	$extra.=" and datetime_added<='".date_dbconvert($date_to)."'";
	$is_search=true;
}
if(isset($_GET["q"])){
	$q=slash($_GET["q"]);
	$_SESSION["purchase"]["list"]["q"]=$q;
}
if(isset($_SESSION["purchase"]["list"]["q"]))
	$q=$_SESSION["purchase"]["list"]["q"];
else
	$q="";
if(!empty($q)){
	$extra.=" and (supplier_name like '%".$q."%' or supplier_code like '%".$q."%')";
	$is_search=true;
}
$order_by = "datetime_added";
$order = "desc";
if( isset($_GET["order_by"]) ){
	$_SESSION["purchase"]["list"]["order_by"]=slash($_GET["order_by"]);
}
if( isset( $_SESSION["purchase"]["list"]["order_by"] ) ){
	$order_by = $_SESSION["purchase"]["list"]["order_by"];
}
if( isset($_GET["order"]) ){
	$_SESSION["purchase"]["list"]["order"]=slash($_GET["order"]);
}
if( isset( $_SESSION["purchase"]["list"]["order"] ) ){
	$order = $_SESSION["purchase"]["list"]["order"];
}
$orderby = $order_by." ".$order;
?>
<div class="page-header">
	<h1 class="title">Manage Purchase</h1>
  	<ol class="breadcrumb">
    	<li class="active">Purchase and Billing</li>
  	</ol>
  	<div class="right">
    	<div class="btn-group" role="group" aria-label="..."> 
        	<a href="purchase_manage.php?tab=addedit" class="btn btn-light editproject">Add New Record</a> 
            <a id="topstats" class="btn btn-light" href="#"><i class="fa fa-search"></i></a>
            <a class="btn print-btn" href="purchase_manage.php?tab=report"><i class="fa fa-print" aria-hidden="true"></i></a>
        </div>
  	</div>
</div>
<ul class="topstats clearfix search_filter"<?php if($is_search) echo ' style="display: block"';?>>
	<li class="col-xs-12 col-lg-12 col-sm-12">
        <div>
        	<form class="form-horizontal" action="" method="get">
            	<span class="col-sm-1 text-to">From</span>
                <div class="col-sm-2">
                    <input type="text" title="Enter Date From" name="date_from" id="date_from" placeholder="" class="form-control date-picker"  value="<?php echo $date_from?>" >
                </div>
                <span class="col-sm-1 text-to">To</span>
                <div class="col-sm-2">
                    <input type="text" title="Enter Date To" name="date_to" id="date_to" placeholder="" class="form-control date-picker" value="<?php echo $date_to?>" >
                </div>
                <div class="col-sm-4">
                  <input type="text" title="Enter String" value="<?php echo $q;?>" name="q" id="search" class="form-control" >  
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
                <th width="2%" class="text-center">S.no</th>
                <th class="text-center" width="3%"><div class="checkbox checkbox-primary">
                    <input type="checkbox" id="select_all" value="0" title="Select All Records">
                    <label for="select_all"></label></div></th>
                <th class="text-center" width="5%">ID</th>
                <th width="15%"><a href="purchase_manage.php?order_by=datetime_added&order=<?php echo $order=="asc"?"desc":"asc"?>" class="sorting">
                        Date
                        <?php
                            if( $order_by == "datetime_added" ) {
                                ?>
                                <span class="sort-icon">
                                    <i class="fa fa-angle-<?php echo $order=="asc"?"up":"down"?>" data-hover_in="<?php echo $order=="asc"?"down":"up"?>" data-hover_out="<?php echo $order=="desc"?"down":"up"?>" aria-hidden="true"></i>
                                </span>
                                <?php
                            }
                            ?>
 					</a></th>
                <th width="20%">Supplier</th>
                <th class="text-right" width="10%"><a href="purchase_manage.php?order_by=net_price&order=<?php echo $order=="asc"?"desc":"asc"?>" class="sorting">
                        Total Amount
                        <?php
                            if( $order_by == "net_price" ) {
                                ?>
                                <span class="sort-icon">
                                    <i class="fa fa-angle-<?php echo $order=="asc"?"up":"down"?>" data-hover_in="<?php echo $order=="asc"?"down":"up"?>" data-hover_out="<?php echo $order=="desc"?"down":"up"?>" aria-hidden="true"></i>
                                </span>
                                <?php
                            }
                            ?>
 					</a></th>
                <th class="text-right" width="10%"><a href="purchase_manage.php?order_by=total_items&order=<?php echo $order=="asc"?"desc":"asc"?>" class="sorting">
                        Total Items
                        <?php
                            if( $order_by == "total_items" ) {
                                ?>
                                <span class="sort-icon">
                                    <i class="fa fa-angle-<?php echo $order=="asc"?"up":"down"?>" data-hover_in="<?php echo $order=="asc"?"down":"up"?>" data-hover_out="<?php echo $order=="desc"?"down":"up"?>" aria-hidden="true"></i>
                                </span>
                                <?php
                            }
                            ?>
 					</a></th>
                <th class="text-right" width="10%"><a href="purchase_manage.php?order_by=quantity_sold&order=<?php echo $order=="asc"?"desc":"asc"?>" class="sorting">
                        Items Sold
                        <?php
                            if( $order_by == "quantity_sold" ) {
                                ?>
                                <span class="sort-icon">
                                    <i class="fa fa-angle-<?php echo $order=="asc"?"up":"down"?>" data-hover_in="<?php echo $order=="asc"?"down":"up"?>" data-hover_out="<?php echo $order=="desc"?"down":"up"?>" aria-hidden="true"></i>
                                </span>
                                <?php
                            }
                            ?>
 					</a></th>
                <th class="text-right" width="10%"><a href="purchase_manage.php?order_by=remaining_stock&order=<?php echo $order=="asc"?"desc":"asc"?>" class="sorting">
                        Remaining Stock
                        <?php
                            if( $order_by == "remaining_stock" ) {
                                ?>
                                <span class="sort-icon">
                                    <i class="fa fa-angle-<?php echo $order=="asc"?"up":"down"?>" data-hover_in="<?php echo $order=="asc"?"down":"up"?>" data-hover_out="<?php echo $order=="desc"?"down":"up"?>" aria-hidden="true"></i>
                                </span>
                                <?php
                            }
                            ?>
 					</a></th>
                <th class="text-center" width="5%">Status</th>
                <th class="text-center" width="15%">Actions</th>
            </tr>
    	</thead>
    	<tbody>
			<?php 
            $sql="select a.*, b.supplier_name, b.supplier_code, phone, address, sum(quantity_sold) as quantity_sold, total_items-sum(quantity_sold) as remaining_stock from purchase a left join supplier b on a.supplier_id = b.id left join purchase_items c on a.id = c.purchase_id where 1 $extra group by purchase_id order by $orderby";
            $rs=show_page($rows, $pageNum, $sql);
            if(numrows($rs)>0){
                $sn=1;
                while($r=dofetch($rs)){             
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $sn;?></td>
                        <td class="text-center"><div class="checkbox margin-t-0 checkbox-primary">
                            <input type="checkbox" name="id[]" id="<?php echo "rec_".$sn?>"  value="<?php echo $r["id"]?>" title="Select Record" />
                            <label for="<?php echo "rec_".$sn?>"></label></div>
                        </td>
                        <td class="text-center"><?php echo $r["id"]?></td>
                        <td><?php echo datetime_convert($r["datetime_added"]); ?></td>
                        <td><?php echo unslash($r["supplier_name"])." (".unslash($r["supplier_code"]).")<br />".unslash($r["phone"]); ?></td>
                        <td class="text-right"><?php echo curr_format(unslash($r["net_price"])); ?></td>
                        <td class="text-right"><?php echo $r["total_items"]; ?></td>
                        <td class="text-right"><?php echo $r["quantity_sold"]; ?></td>
                        <td class="text-right"><?php echo $r["remaining_stock"]; ?></td>
                        <td class="text-center"><a href="purchase_manage.php?id=<?php echo $r['id'];?>&tab=status&s=<?php echo ($r["status"]==0)?1:0;?>">
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
                        </a></td>
                        <td class="text-center">
                            <a href="purchase_manage.php?tab=addedit&id=<?php echo $r['id'];?>"><img title="Edit Record" alt="Edit" src="images/edit.png"></a>&nbsp;&nbsp;
                            <a href="purchase_manage.php?tab=print&id=<?php echo $r['id'];?>" class=""><img title="Print Label" alt="Print" src="images/view.png"></a>&nbsp;&nbsp;
                            <a onclick="return confirm('Are you sure you want to delete')" href="purchase_manage.php?id=<?php echo $r['id'];?>&amp;tab=delete"><img title="Delete Record" alt="Delete" src="images/delete.png"></a>
                        </td>
                    </tr>
                    <?php 
                    $sn++;
                }
                ?>
                <tr>
                    <td colspan="5" class="actions">
                        <select name="bulk_action" id="bulk_action" title="Choose Action">
                            <option value="null">Bulk Action</option>
                            <option value="delete">Delete</option>
                            <option value="statuson">Set Status On</option>
                            <option value="statusof">Set Status Off</option>
                        </select>
                        <input type="button" name="apply" value="Apply" id="apply_bulk_action" class="btn btn-light" title="Apply Action"  />
                    </td>
                    <td colspan="6" class="paging" title="Paging" align="right"><?php echo pages_list($rows, "purchase", $sql, $pageNum)?></td>
                </tr>
                <?php	
            }
            else{	
                ?>
                <tr>
                    <td colspan="11"  class="no-record">No Result Found</td>
                </tr>
                <?php
            }
            ?>
    	</tbody>
  	</table>
</div>
