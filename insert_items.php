<?php 
include("include/db.php");
include("include/utility.php");
include("include/session.php");
if (($handle = fopen("customer.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle)) !== FALSE) {
       // print_r($data);
       $balance = str_replace(",","",$data[3]);
       $sql="Update customer set `balance`='".$balance."' where id='".$data[0]."'";
       doquery($sql,$dblink);
    }
}
// $row = 1;
// if (($handle = fopen("customer.csv", "r")) !== FALSE) {
//     while (($data = fgetcsv($handle)) !== FALSE) {
//         $num = count($data);
//         $row++;
//         $sql="INSERT INTO customer (business_name, customer_name, address, phone, balance) VALUES ('".slash($data[""])."', '".slash($data)."','".slash($name)."','".slash($email)."','".slash($password)."')";
// 		doquery($sql,$dblink);
//     }
//     fclose($handle);
// }
?>
	