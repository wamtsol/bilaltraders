<?php

if(!defined("APP_START")) die("No Direct Access");
$q="";
$extra='';
$is_search=false;
if(isset($_GET["q"])){
    $q=slash($_GET["q"]);
    $_SESSION["item_manage"]["q"]=$q;
}
if(isset($_SESSION["item_manage"]["q"]))
    $q=$_SESSION["item_manage"]["q"];
else
    $q="";
if(!empty($q)){
    $extra.=" and title like '%".$q."%'";
    $is_search=true;
}
if(isset($_GET["item_category_id"])){
	$item_category_id=slash($_GET["item_category_id"]);
	$_SESSION["item_manage"]["item_category_id"]=$item_category_id;
}
if(isset($_SESSION["item_manage"]["item_category_id"]))
	$item_category_id=$_SESSION["item_manage"]["item_category_id"];
else
	$item_category_id="";
if($item_category_id!=""){
	$extra.=" and item_category_id='".$item_category_id."'";
    $is_search=true;
}


?>

    <div class="page-header">
        <h1 class="title">Manage Items</h1>
        <ol class="breadcrumb">
            <li class="active">All Items</li>
        </ol>
        <div class="right">
            <div class="btn-group" role="group" aria-label="..."> 
                <a href="items_manage.php?tab=add" class="btn btn-light editproject">Add New Record</a> <a id="topstats" class="btn btn-light" href="#"><i class="fa fa-search"></i></a>
            </div>
        </div>
    </div>
    <ul class="topstats clearfix search_filter"<?php if($is_search) echo ' style="display: block"';?>>
	<li class="col-xs-12 col-lg-12 col-sm-12">
        <div>
        	<form class="form-horizontal" action="" method="GET">
                <span  class="col-sm-10 text-to"></span>
                <div class="col-sm-3">
                 <select name="item_category_id" id="item_category_id" class="form-control">
                <option value=""<?php echo ($item_category_id=="")? " selected":"";?>>
                Select Items Category</option>
                <?php

                    $res=doquery("select * from item_category order by title",$dblink);
                    if(numrows($res)>=0){
                        while($rec=dofetch($res)){
                        ?>
                        <option value="<?php echo $rec["id"]?>" <?php echo($item_category_id==$rec["id"])?"selected":"";?>><?php echo unslash($rec["title"])?></option>
                        <?php
                        }
                    }	
                ?>
                </select>
                </div>
                <div class="col-sm-4">
                  <input type="text" title="Enter String" value="<?php echo $q;?>" name="q" id="search" class="form-control" >  
                </div>
                <div class="col-sm-3 text-left">
                    <input type="submit" class="btn btn-danger btn-l reset_search" value="Reset" alt="Reset Record" title="Reset Record" />
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
                    <th width="5%" class="text-center">S.no</th>
                    <th class="text-center" width="5%"><div class="checkbox checkbox-primary">
                        <input type="checkbox" id="select_all" value="0" title="Select All Records">
                        <label for="select_all"></label></div></th>
                        <th>Items Category Type</th>
                    <th>Title</th>
                    <th>Unit</th>
                    <th>Unit Price</th>
                    <th>Quaintity</th>
                    <th class="text-center">Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $sql="select * from items where 1 $extra";
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
                            
                            <td><?php if($r["item_category_id"]==0) echo ""; else echo get_field($r["item_category_id"], "item_category");?></td>
                            <td><?php echo unslash($r["title"]); ?></td>
                            <td><?php echo unslash($r["unit"]); ?></td>
                            <td><?php echo unslash($r["unit_price"]); ?></td>
                            <td><?php echo unslash($r["quantity"]); ?></td>
                            <td class="text-center"><a href="items_manage.php?id=<?php echo $r['id'];?>&tab=status&s=<?php echo ($r["status"]==0)?1:0;?>">
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
                            <td>
                                <a href="items_manage.php?tab=edit&id=<?php echo $r['id'];?>"><img title="Edit Record" alt="Edit" src="images/edit.png"></a>&nbsp;&nbsp;
                                <a onclick="return confirm('Are you sure you want to delete')" href="items_manage.php?id=<?php echo $r['id'];?>&amp;tab=delete"><img title="Delete Record" alt="Delete" src="images/delete.png"></a>
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
                        <td colspan="3" class="paging" title="Paging" align="right"><?php echo pages_list($rows, "admin", $sql, $pageNum)?></td>
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

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>