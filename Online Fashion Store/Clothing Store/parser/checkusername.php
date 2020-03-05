<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/Clothing Store/coreDB/init.php';
$username = $_POST['username'];
$sql = "SELECT * FROM customers WHERE username='$username'";
$res = mysqli_query($con,$sql);
$row = mysqli_num_rows($res);
//var_dump($row);
if($row!=0){
	echo "Username already exists";
}
else{
	echo "Username is valid";
}

?>