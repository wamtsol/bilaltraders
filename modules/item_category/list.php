<?php
if(!defined("APP_START")) die("No Direct Access");
$q="";
$extra='';
$is_search=false;
if(isset($_GET["q"])){
	$q=slash($_GET["q"]);
	$_SESSION["item_category_manage"]["q"]=$q;
}
if(isset($_SESSION["item_category_manage"]["q"]))
	$q=$_SESSION["item_category_manage"]["q"];
else
	$q="";
if(!empty($q)){
	$extra.=" and title like '%".$q."%'";
	$is_search=true;
}
?>
<div class="page-header">
	<h1 class="title">Manage Item Category</h1>
  	<ol class="breadcrumb">
    	<li class="active">All Item Category</li>
  	</ol>
  	<div class="right">
    	<div class="btn-group" role="group" aria-label="..."> 
        	<a href="item_category_manage.php?tab=add" class="btn btn-light editproject">Add New Record</a> 
            <a id="topstats" class="btn btn-light" href="#"><i class="fa fa-search"></i></a>
        </div>
  	</div>
</div>
<ul class="topstats clearfix search_filter"<?php if($is_search) echo ' style="display: block"';?>>
	<li class="col-xs-12 col-lg-12 col-sm-12">
        <div>
        	<form class="form-horizontal" action="" method="get">
                <div class="col-sm-10 col-xs-8">
                  <input type="text" title="Enter String" value="<?php echo $q;?>" name="q" id="search" class="form-control" >  
                </div>
                <div class="col-sm-1 col-xs-2">
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
                <th width="50%">Title</th>
                <th width="10%" class="text-center">Sortorder</th>
                <th width="5%" class="text-center">Status</th>
                <th width="10%" class="text-center">Actions</th>
            </tr>
    	</thead>
    	<tbody>
			<?php 
            $sql="select * from item_category where parent_id=0 $extra order by sortorder";
            $rs=doquery($sql, $dblink);
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
                        <td><?php echo unslash($r["title"]); ?></td>
                        <td class="text-center"><?php echo unslash($r["sortorder"]); ?></td>
                        <td class="text-center"><a href="item_category_manage.php?id=<?php echo $r['id'];?>&tab=status&s=<?php echo ($r["status"]==0)?1:0;?>">
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
                            <a href="item_category_manage.php?tab=edit&id=<?php echo $r['id'];?>"><img title="Edit Record" alt="Edit" src="images/edit.png"></a>&nbsp;&nbsp;
                            <a onclick="return confirm('Are you sure you want to delete')" href="item_category_manage.php?id=<?php echo $r['id'];?>&amp;tab=delete"><img title="Delete Record" alt="Delete" src="images/delete.png"></a>
                        </td>
                    </tr>
                    <?php
					$sql="select * from item_category where parent_id='".$r["id"]."' $extra order by sortorder";
					$rs2=doquery($sql, $dblink);
					if(numrows($rs2)>0){
						while($r2=dofetch($rs2)){
							?>
							<tr>
								<td class="text-center"><?php echo $sn;?></td>
								<td class="text-center"><div class="checkbox margin-t-0 checkbox-primary">
									<input type="checkbox" name="id[]" id="<?php echo "rec_".$sn?>"  value="<?php echo $r2["id"]?>" title="Select Record" />
									<label for="<?php echo "rec_".$sn?>"></label></div>
								</td>
								<td><?php echo unslash($r["title"])." &gt; ".unslash($r2["title"]); ?></td>
								<td class="text-center"><?php echo unslash($r2["sortorder"]); ?></td>
								<td class="text-center"><a href="item_category_manage.php?id=<?php echo $r2['id'];?>&tab=status&s=<?php echo ($r2["status"]==0)?1:0;?>">
									<?php
									if($r2["status"]==0){
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
									<a href="item_category_manage.php?tab=edit&id=<?php echo $r2['id'];?>"><img title="Edit Record" alt="Edit" src="images/edit.png"></a>&nbsp;&nbsp;
									<a onclick="return confirm('Are you sure you want to delete')" href="item_category_manage.php?id=<?php echo $r2['id'];?>&amp;tab=delete"><img title="Delete Record" alt="Delete" src="images/delete.png"></a>
								</td>
							</tr>
							<?php
							$sql="select * from item_category where parent_id='".$r2["id"]."' $extra order by sortorder";
							$rs3=doquery($sql, $dblink);
							if(numrows($rs3)>0){
								while($r3=dofetch($rs3)){
									?>
									<tr>
										<td class="text-center"><?php echo $sn;?></td>
										<td class="text-center"><div class="checkbox margin-t-0 checkbox-primary">
											<input type="checkbox" name="id[]" id="<?php echo "rec_".$sn?>"  value="<?php echo $r3["id"]?>" title="Select Record" />
											<label for="<?php echo "rec_".$sn?>"></label></div>
										</td>
										<td><?php echo unslash($r["title"])." &gt; ".unslash($r2["title"])." &gt; ".unslash($r3["title"]); ?></td>
										<td class="text-center"><?php echo unslash($r3["sortorder"]); ?></td>
										<td class="text-center"><a href="item_category_manage.php?id=<?php echo $r3['id'];?>&tab=status&s=<?php echo ($r3["status"]==0)?1:0;?>">
											<?php
											if($r3["status"]==0){
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
											<a href="item_category_manage.php?tab=edit&id=<?php echo $r3['id'];?>"><img title="Edit Record" alt="Edit" src="images/edit.png"></a>&nbsp;&nbsp;
											<a onclick="return confirm('Are you sure you want to delete')" href="item_category_manage.php?id=<?php echo $r3['id'];?>&amp;tab=delete"><img title="Delete Record" alt="Delete" src="images/delete.png"></a>
										</td>
									</tr>
									<?php
									$sn++;
								}
							}
							$sn++;
						}
                    	$sn++;
					}
                }
            }
            else{	
                ?>
                <tr>
                    <td colspan="7"  class="no-record">No Result Found</td>
                </tr>
                <?php
            }
            ?>
    	</tbody>
  	</table>
</div>
