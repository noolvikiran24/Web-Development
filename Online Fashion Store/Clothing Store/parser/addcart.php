<?php
//session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/Clothing Store/coreDB/init.php';
$product_id = sanitize($_POST['product_id']);
$size = sanitize($_POST['size1']);
$available = sanitize($_POST['available']);
$quantity = sanitize($_POST['quantity']);

$items = array();
$item[] = array(
	'id' => $product_id,
	'size' =>  $size,
	'quantity' => $quantity,

); 

$domain = ($_SERVER['HTTP_HOST']!='localhost')?'.'.$_SERVER['HTTP_HOST']:false; // appending . infront of the host name to make sure that cookies work on local host and the browser
$query = "SELECT * FROM products where id='$product_id'";
$product =mysqli_query($con,$query);
$product = mysqli_fetch_assoc($product);


//Check to see if the cookie is set
if($_SESSION["cartid"]!=''){
	$cart_id = $_SESSION["cartid"];
	//var_dump($cart_id);
	$cartQ = "SELECT * FROM cart where id = '$cart_id'";
	$cartR = mysqli_query($con, $cartQ);
	if(!$cartR){
		echo mysqli_errors($con);
	}
	$cartR = mysqli_fetch_assoc($cartR);
	//var_dump($cartR);
	$prev_items = json_decode($cartR['items'], true);
	//echo $prev_items;
	$item_match=0;
	$newitem = array();
	foreach((array)$prev_items as $pitem){
		if($item[0]['id']==$pitem['id']&&$item['0']['size']==$pitem['size']){
			$pitem['quantity']+=$item[0]['quantity'];
			if($pitem['quantity']>$available){
				$pitem['quantity']=$available; 
			}
			$item_match = 1;
		}
		$newitem[] = $pitem;

}
if($item_match!=1){
	 $newitem = array_merge($item, (array)$prev_items);
}

$items_json = json_encode($newitem);
$cart_exp  = date('Y-m-d H:i:s', strtotime("+30 days"));
$query = "UPDATE cart SET items = '$items_json' , expire_date='$cart_exp' WHERE id='$cart_id '";

	if(!mysqli_query($con, $query)){ 
		ob_start(); 
		echo mysqli_error($con);
		?>
		<p>ERROR</p>
		<?php echo ob_get_clean();
	}
	else{
		echo "The item has been added to cart successfully!";
	}
	
	//$cart_id = $con->insert_id;
	$_SESSION["cartid"] = $cart_id;
	setcookie(CART_COOKIE,'', 1,"/",$domain,false);
	setcookie(CART_COOKIE,$cart_id, CART_COOKIE_EXPIRE,'/',$domain,false);

}
else{
 //Add product to the cart and set the cookie
	$items_json = json_encode($item);
	$cart_exp  = date('Y-m-d H:i:s', strtotime("+30 days")); 
	$query1 = "INSERT INTO cart (items, expire_date, paid) VALUES('$items_json','$cart_exp','0')";
	if(!mysqli_query($con, $query1)){ 
		ob_start(); 
		echo mysqli_errors($con);
		?>
		<p>ERROR</p>
		<?php echo ob_get_clean();
	}
	else{
		echo "The item has been added to cart successfully!";
	}
	$cart_id = $con->insert_id;
	//echo "CART".$cart_id;
	$_SESSION["cartid"] = $cart_id;
	setcookie(CART_COOKIE,$cart_id,CART_COOKIE_EXPIRE,'/',$domain,false,true);
	
  
}

?>
