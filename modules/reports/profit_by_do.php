<?php
if(!defined("APP_START")) die("No Direct Access");
$extra='';
$is_search=true;
if(isset($_GET["date_from"])){
	$date_from=slash($_GET["date_from"]);
	$_SESSION["reports"]["profit_by"]["date_from"]=$date_from;
}
if(isset($_SESSION["reports"]["profit_by"]["date_from"]))
	$date_from=$_SESSION["reports"]["profit_by"]["date_from"];
else
	$date_from=date("1/m/Y");
if(isset($_GET["date_to"])){
	$date_to=slash($_GET["date_to"]);
	$_SESSION["reports"]["profit_by"]["date_to"]=$date_to;
}
if(isset($_SESSION["reports"]["profit_by"]["date_to"]))
	$date_to=$_SESSION["reports"]["profit_by"]["date_to"];
else
	$date_to=date("d/m/Y");
$extra.=" and datetime_added BETWEEN '".date('Y-m-d',strtotime(date_dbconvert($date_from)))." 00:00:00' AND '".date('Y-m-d',strtotime(date_dbconvert($date_to)))." 23:59:59'";
$sql = "select * from items where status = 1 order by title";