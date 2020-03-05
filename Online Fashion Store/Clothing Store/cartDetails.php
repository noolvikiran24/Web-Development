<?php 
require_once "coreDB/init.php";
//var_dump($_SESSION['cartid']);
$cart_id = $_SESSION['cartid'];

$cartDetailsQuery = "SELECT * FROM cart WHERE id='$cart_id'";
$cartDetailsResult = mysqli_query($con,$cartDetailsQuery);
$cartDetailsResult = mysqli_fetch_assoc($cartDetailsResult);
$cartorderdetails = $cartDetailsResult['items'];
$cartDetailsResult = json_decode($cartorderdetails,true);
//var_dump($cartDetailsResult);
$total=0;

?>

<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Basket</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="css/cartDetails.css">

</head>

<body class="bg-light">
   <?php include "includeFor/navigationBar.php";?>
  <main style="padding-top: 60px;">
    <div class="basket card border border-dark" >
      <div class="basket-module">
        <label for="promo-code">Enter a promotional code</label>
        <input id="promo-code" type="text" name="promo-code" maxlength="5" class="promo-code-field">
        <button class="promo-code-cta bg-success">Apply</button>
      </div>
      <div class="basket-labels">
        <ul>
          <li class="item item-heading">Item</li>
          <li class="price">Price</li>
          <li class="quantity">Quantity</li>
          <li class="subtotal">Subtotal</li>
        </ul>
      </div>
      <form method="POST" action="index.php" id="cartform">
      <?php foreach($cartDetailsResult as $cartItem): 
        $pullid = $cartItem['id'];
        $pullItemQ = "SELECT * FROM products WHERE id='$pullid'";
        $pullItemR = mysqli_query($con,$pullItemQ);
        $pullItemR = mysqli_fetch_assoc($pullItemR);

        ?>
        <div class="basket-product">
          <div class="item">
            <div class="product-image">
              <img src="<?php echo $pullItemR['image']; ?>" alt="Placholder Image 2" class="product-frame img-thumbnail">
            </div>
            <div class="product-details card-body">
              <h1><strong><span class="item-quantity"><?php echo $cartItem['quantity']; ?></span> x <?php echo $pullItemR['title'];?></strong></h1>
              <p><strong>Navy, Size <?php echo $cartItem['size']; ?></strong></p>
              <p>Product Code - 232321939</p>
            </div>
          </div>
          <div class="price"><?php echo $pullItemR['price'];?></div>
          <div class="quantity">
            <input type="number" value="<?php echo $cartItem['quantity'];?>" min="1" class="quantity-field">
          </div>
          <div class="subtotal"><?php $total+=$cartItem['quantity']*$pullItemR['price']; echo $cartItem['quantity']*$pullItemR['price']; ?></div>
          <div class="remove">
            <button>Remove</button>
          </div>
        </div>
    <?php endforeach; ?>
  </form>
    </div>
    <aside>
      <div class="summary card bg-light border border-dark" >
        <div class="summary-total-items"><span class="total-items"></span> Items in your Bag</div>
        <div class="summary-subtotal">
          <div class="subtotal-title">Subtotal</div>
          <div class="subtotal-value final-value" id="basket-subtotal"><?php echo $total;?></div>
          <div class="summary-promo hide">
            <div class="promo-title">Promotion</div>
            <div class="promo-value final-value" id="basket-promo"></div>
          </div>
        </div>
        <!--<div class="summary-delivery">
          <select name="delivery-collection" class="summary-delivery-selection">
             <option value="0" selected="selected">Select Collection or Delivery</option>
             <option value="collection">Collection</option>
             <option value="first-class">Royal Mail 1st Class</option>
             <option value="second-class">Royal Mail 2nd Class</option>
             <option value="signed-for">Royal Mail Special Delivery</option>
          </select>
        </div> -->
        <div class="summary-total">
          <div class="total-title">Total</div>
          <div class="total-value final-value" id="basket-total"><?php echo $total; ?></div>
        </div>
        <div class="card">
          

        </div>
        <form method="POST">
        <div class="card" style="background-color: #00acc1;">
          <div class="card-title text-light text-center" style="margin-top: 1em;">Shipping Address</div>
          <div class="card-body">
            <p class="form-group " style="margin-left: auto; margin-right: auto; margin-top: -30px">

             <label for="fullname" class="text-light">Full Name</label>
              <input type="text" id="fullname" name="fullname" class="card-details" style=" margin-top:-5px; width: 15em; margin-bottom: 2px; " required/>
              <label for="addressline1" class="text-light">Street Address</label>
               
              <input type="text" name= "addressline1" id="addressline1" class="card-details" style=" margin-top:-5px; width: 15em; " placeholder="Street and number, P.O. box" required/>
              <input type="text" name="addressline2" class="card-details" style="width: 15em; margin-top: 1px; " placeholder="Apartment, suite, unit, etc" required/>
              <label for="city" class="text-light">City</label>
              <input type="text" name= "city" id="city" class="card-details" style=" margin-top:-5px; width: 15em; " required/>
              <label for="state" class="text-light">State / Province / Region</label>
              <input type="text" name= "state" id="state" class="card-details" style=" margin-top:-5px; width: 15em;" required/>

              <label for="postcode" class="text-light">Zip Code</label>
              <input type="text" name= "postcode" id="postcode" class="card-details" style=" margin-top:-5px; width: 15em; " required />
              <label for="phone" class="text-light">Phone number</label>
              <input type="text" name= "phone" id="phone" class="card-details" style=" margin-top:-5px; width: 15em; " required/>
              
            </p>
           
  
          </div>

        </div>
        
        <div class="card" style="margin-top: 5px; margin-bottom: 5px; background-color: #00acc1;">
          <div class="card-title text-light text-center" style="margin-top: 1em;">Payment Details</div>
          <div class="card-body">
            <p class="form-group " style="margin-left: auto; margin-right: auto; margin-top: -30px">
              <label for="cardname" class="text-light">Name</label>

              <input type="text" name="cardname" class="card-details" style="margin: 1px; width: 9em; " placeholder="Your name" required>
             
                <input type="text" name="cardexpirymonth" class="card-details" style="margin: 1px; width: 2.5em;" placeholder="MM" required/>
              
                <input type="text" name="cardexpiryyear" class="card-details" style="margin: 1px; width: 2.5em;" placeholder="YY" required/>
              
              
            </p>
            <p class="form-group" style="margin-left: auto; margin-right: auto; margin-top: 3px;">
              <label for="cardnumber" class="text-light" style="margin-top: 10px;">Card Number</label>
              <input type="text" name="cardnumber" style="margin-left: 1px; margin-right: 1px; width: 9em;" placeholder="4111 1111 1111 1111">
              <input type="text" style=" margin-left: 1px; margin-right: 1px; width: 2.5em;" placeholder="CVC">
            </p>
  
          </div>

        </div>
        <div class="bg-secondary">
        
          <input type ="submit" name="placeorder" value ="Place Order" id="checkoutbutton" class="checkout-cta bg-warning" onclick="clickCheckOut()">
        
        </div>
        </form>
      </div>
    </aside>
  </main>
</body>

</html>
<script src="js/cartDetails.js" type="text/javascript"></script>
<script>
  
  function logoutfunction(){
    window.location = "logout.php";
  }
</script>


<?php 
 if(isset($_POST['placeorder'])){
  $setpaid = "UPDATE cart set paid = 1 where id= '$cart_id'";
  mysqli_query($con, $setpaid);

  $fullname = $_POST['fullname'];
  $address = $_POST['addressline1'].', '.$_POST['addressline2'].$_POST['city'].', '.$_POST['state'].', '.$_POST['postcode'];
  $phone = $_POST['phone'];
  $date = date('Y-m-d H:i:s');


  $customeridquery = "SELECT customerid FROM customers WHERE username = '$_SESSION[borrusername]'";
  $customeridquery = mysqli_query($con,  $customeridquery);
  $customeridquery = mysqli_fetch_assoc($customeridquery);
  $customeridquery =  $customeridquery['customerid'];


  

  $orderUpdate = "INSERT INTO orders (customer_id, items, price, date_ordered, customer_username, address, contact_number, paid) VALUES('1','$cartorderdetails', '$total', '$date', '$_SESSION[borrusername]',  '$address', '$phone','1')";

  if(!mysqli_query($con, $orderUpdate)){
    echo mysqli_error($con);
  }




  unset($_SESSION['cartid']);

  
   
?>
<script>
  
    
      alert("Order successfully placed");
      window.location ="index.php?maincategory=fashion"; 
     
    
  
</script>
<?php 


}
?>
