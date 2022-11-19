<?php
if(!defined("APP_START")) die("No Direct Access");
?>
<div class="page-header">
	<h1 class="title">Manage Sales</h1>
  	<ol class="breadcrumb">
    	<li class="active">Sales and billing</li>
  	</ol>
  	<div class="right">
    	<div class="btn-group" role="group" aria-label="..."> 
        	<a href="sales_manage.php?tab=addedit" class="btn btn-light editproject">Add New Record</a> 
            <a id="topstats" class="btn btn-light" href="#"><i class="fa fa-search"></i></a> 
            <a class="btn print-btn" href="sales_manage.php?tab=report"><i class="fa fa-print" aria-hidden="true"></i></a>  
        </div>
  	</div>
</div>
<ul class="topstats clearfix search_filter"<?php if($is_search) echo ' style="display: block"';?>>
	<li class="col-xs-12 col-lg-12 col-sm-12">
        <div>
        	<form class="form-horizontal" action="" method="get">
				<div class="row">
					
				</div>
				<div class="col-sm-2">
					<select name="customer_id" id="customer_id" class="select_multiple">
						<option value=""<?php echo ($customer_id=="")? " selected":"";?>>
						Select Customers</option>
						<?php
							$res=doquery("select * from customer order by business_name",$dblink);
							if(numrows($res)>=0){
								while($rec=dofetch($res)){
								?>
								<option value="<?php echo $rec["id"]?>" <?php echo($customer_id==$rec["id"])?"selected":"";?>><?php echo unslash($rec["business_name"])?></option>
								<?php
								}
							}	
						?>
					</select>

                </div>
                <div class="col-sm-2">
                    <input type="text" title="Enter Date From" name="date_from" id="date_from" placeholder="From" class="form-control date-picker"  value="<?php echo $date_from?>" >
                </div>
                <div class="col-sm-2">
                    <input type="text" title="Enter Date To" name="date_to" id="date_to" placeholder="To" class="form-control date-picker" value="<?php echo $date_to?>" >
                </div>
                <div class="col-sm-2">
                  <input type="text" title="Enter String" value="<?php echo $q;?>" name="q" id="search" class="form-control" >  
                </div>
                <div class="col-sm-2">
                  <select name="item_id" class="item_select">
                        <option value="">Select Item</option>
                        <?php
                            $res=doquery("select * from items where status = 1 order by title",$dblink);
                            if(numrows($res)>=0){
                                while($rec=dofetch($res)){
                                ?>
                                <option value="<?php echo $rec["id"]?>"<?php echo($item_id==$rec["id"])?"selected":"";?>><?php echo unslash($rec["title"])?></option>
                            	<?php
                                }
                            }	
                        ?>
                    </select>
                </div>
				<div class="col-sm-2">
				  <select name="stock_type">
					<option value=""<?php echo $stock_type==""?" selected":""?>>Select Stock Type</option>
					<option value="1"<?php echo $stock_type=="1"?" selected":""?>>Fresh Stock</option>
					<option value="2"<?php echo $stock_type=="2"?" selected":""?>>Damage Stock</option>                    
				  </select>
				</div>
                <div class="col-sm-2 text-left" style="margin-top: 10px;">
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
                <th width="12%">
                	<a href="sales_manage.php?order_by=datetime_added&order=<?php echo $order=="asc"?"desc":"asc"?>" class="sorting">
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
 					</a>
                </th>
                <th width="15%">Customer Name</th>
                <!-- <th width="18%">Items</th>
                <th class="text-right" width="8%">Total Items</th> -->
                <th class="text-right" width="10%">
                	<a href="sales_manage.php?order_by=total_price&order=<?php echo $order=="asc"?"desc":"asc"?>" class="sorting">
                		Total Price
                        <?php
                            if( $order_by == "total_price" ) {
                                ?>
                                <span class="sort-icon">
                                    <i class="fa fa-angle-<?php echo $order=="asc"?"up":"down"?>" data-hover_in="<?php echo $order=="asc"?"down":"up"?>" data-hover_out="<?php echo $order=="desc"?"down":"up"?>" aria-hidden="true"></i>
                                </span>
                                <?php
                            }
                            ?>
                    </a>
                </th>
                <th width="10%" style="text-align:right;">Shipping Charges</th>
                <th width="8%" style="text-align:right;">Discount</th>
                <th width="8%" style="text-align:right;">Net Price</th>
                <th class="text-center" width="3%">Status</th>
                <th class="text-center" width="12%">Actions</th>
            </tr>
    	</thead>
    	<tbody>
			<?php
            $total_price = $total_discount = $total_net_price = $total_shipping_charges = 0;
            $rs=show_page($rows, $pageNum, $sql);
            if(numrows($rs)>0){
                $sn=1;
                while($r=dofetch($rs)){
                    $total_price += $r["total_price"];
                    $total_discount += $r["discount"];
                    $total_net_price += $r["net_price"];
                    $total_shipping_charges += $r["shipping_charges"];          
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $sn;?></td>
                        <td class="text-center"><div class="checkbox margin-t-0 checkbox-primary">
                            <input type="checkbox" name="id[]" id="<?php echo "rec_".$sn?>"  value="<?php echo $r["id"]?>" title="Select Record" />
                            <label for="<?php echo "rec_".$sn?>"></label></div>
                        </td>
                        <td class="text-center"><?php echo $r["id"]?></td>
                        <td><?php echo datetime_convert($r["datetime_added"]); ?></td>
                        <td><?php echo get_field($r["customer_id"], "customer","business_name");?></td>
                        <!-- <td>
                        	<?php 
								$items=doquery("select * from sales_items where sales_id='".$r["id"]."'",$dblink);
								while($item=dofetch($items)){
									echo unslash($item["quantity"])." x ".get_field($item["item_id"], "items", "title")."<br>";
								}
							?>
                        </td>
                        <td class="text-right"><?php echo unslash($r["total_items"]); ?></td> -->
                        <td class="text-right"><?php echo curr_format(unslash($r["total_price"])); ?></td> 
                        <td style="text-align:right;"><?php echo curr_format(unslash($r["shipping_charges"])); ?></td>
                        <td style="text-align:right;"><?php echo curr_format(unslash($r["discount"])); ?></td>
                        <td style="text-align:right;"><?php echo curr_format(unslash($r["net_price"])); ?></td>                       
                        <td class="text-center"><a href="sales_manage.php?id=<?php echo $r['id'];?>&tab=status&s=<?php echo ($r["status"]==0)?1:0;?>">
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
                            <a href="sales_manage.php?tab=addedit&id=<?php echo $r['id'];?>"><img title="Edit Record" alt="Edit" src="images/edit.png"></a>&nbsp;&nbsp;
                            <a href="sales_manage.php?tab=print&id=<?php echo $r['id'];?>"><img title="Print Record" alt="Print" src="images/view.png"></a>&nbsp;&nbsp;
                            <a onclick="return confirm('Are you sure you want to delete')" href="sales_manage.php?id=<?php echo $r['id'];?>&amp;tab=delete"><img title="Delete Record" alt="Delete" src="images/delete.png"></a>
                        </td>
                    </tr>
                    <?php 
                    $sn++;
                }
                ?>
                <tr>
                    <th class="text-right" colspan="5">Total</th>
                    <th class="text-right"><?php echo curr_format($total_price);?></th>
                    <th class="text-right"><?php echo curr_format($total_shipping_charges);?></th>
                    <th class="text-right"><?php echo curr_format($total_discount);?></th>
                    <th class="text-right"><?php echo curr_format($total_net_price);?></th>
                    <th></th>
                    <th></th>
                </tr>
                <tr>
                    <td colspan="6" class="actions">
                        <select name="bulk_action" id="bulk_action" title="Choose Action">
                            <option value="null">Bulk Action</option>
                            <option value="delete">Delete</option>
                            <option value="statuson">Set Status On</option>
                            <option value="statusof">Set Status Off</option>
                        </select>
                        <input type="button" name="apply" value="Apply" id="apply_bulk_action" class="btn btn-light" title="Apply Action"  />
                    </td>
                    <td colspan="5" class="paging" title="Paging" align="right"><?php echo pages_list($rows, "sales", $sql, $pageNum)?></td>
                </tr>
                <?php	
            }
            else{	
                ?>
                <tr>
                    <td colspan="10"  class="no-record">No Result Found</td>
                </tr>
                <?php
            }
            ?>
    	</tbody>
  	</table>
</div>
