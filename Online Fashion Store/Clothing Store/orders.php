<?php 
require_once "coreDB/init.php";
//var_dump($_SESSION['cartid']);
$cart_id = 42;

$username = $_SESSION["borrusername"];

$cartDetailsQuery = "SELECT * FROM orders WHERE customer_username='$username'";
$cartDetailsResult = mysqli_query($con,$cartDetailsQuery);
//$num_rows = mysqli_num_rows($cartDetailsResult);
//var_dump($num_rows);
//var_dump(cartDetailsResult);
//var_dump($cartDetailsResult);

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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="css/orderDetails.css">



</head>

<body class="bg-light">
  <?php include "includeFor/navigationBar.php";?>
  
  <main style="padding-top: 60px">

    <div class="basket card border border-dark" >
      
      <div class="basket-labels">
        <ul>
          <li class="item item-heading">Item</li>
          <li class="price">Price</li>
          <li class="quantity">Quantity</li>
          <li class="subtotal">Subtotal</li>
        </ul>
      </div>
      <form method="POST" action="" id="cartform">
      <?php 
        while($row = mysqli_fetch_assoc($cartDetailsResult)):
          //var_dump($row['items']);
          $ordersJSON = $row['items'];
          $ordersJSON = json_decode($ordersJSON,true);
          //var_dump($cartDetailsResult);

          foreach($ordersJSON as $cartItem): 
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
              <p id="productCode">Product Code - <?php echo $cartItem['id'];?></p>
            </div>
           
          </div>
          <div class="price"><?php echo $pullItemR['price'];?></div>
          <div class="quantity">
            <input type="number" value="<?php echo $cartItem['quantity'];?>" min="1" class="quantity-field" readonly>
          </div>
          <div class="subtotal"><?php $total+=$cartItem['quantity']*$pullItemR['price']; echo $cartItem['quantity']*$pullItemR['price']; ?></div>

           <div class="rating rating-stars text-center">
              <ul id='stars'>
                <li class='star' title='Poor' data-value='1'>
                  <i class='fa fa-star fa-fw'></i>
                </li>
                <li class='star' title='Fair' data-value='2'>
                  <i class='fa fa-star fa-fw'></i>
                </li>
                <li class='star' title='Good' data-value='3'>
                  <i class='fa fa-star fa-fw'></i>
                </li>
                <li class='star' title='Excellent' data-value='4'>
                  <i class='fa fa-star fa-fw'></i>
                </li>
                <li class='star' title='WOW!!!' data-value='5'>
                  <i class='fa fa-star fa-fw'></i>
                </li>
              </ul>
            </div>
        
            <input type="hidden" name="starsvalue" id="starsvalue" value="0"/>
            <?php //var_dump($_POST['starsvalue']);?>
            <div class="review">
              <button type="button" onclick="addReviewModal(<?php echo $cartItem['id'];?>)">Write Review</button>
            </div>

           
            


        </div>
        
        
    <?php 
      endforeach; 
    endwhile;

    ?>

  </form>
    </div>
   
    <aside >
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

      </div>
    </aside>
 
  </main>
 
</body>


</html>
<script src="js/cartDetails.js" type="text/javascript"></script>
<script>
  $(document).ready(function(){
  
  /* 1. Visualizing things on Hover - See next part for action on click */
  $('#stars li').on('mouseover', function(){
    var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on
   
    // Now highlight all the stars that's not after the current hovered star
    $(this).parent().children('li.star').each(function(e){
      if (e < onStar) {
        $(this).addClass('hover');
      }
      else {
        $(this).removeClass('hover');
      }
    });
    
  }).on('mouseout', function(){
    $(this).parent().children('li.star').each(function(e){
      $(this).removeClass('hover');
    });
  });
  
  
  $('#stars li').on('click', function(){
    var onStar = parseInt($(this).data('value'), 10); // The star currently selected
    var stars = $(this).parent().children('li.star');
    
    for (i = 0; i < stars.length; i++) {
      $(stars[i]).removeClass('selected');
    }
    
    for (i = 0; i < onStar; i++) {
      $(stars[i]).addClass('selected');
    }
    
    // JUST RESPONSE (Not needed)
    var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
    var productID = $("#productNumber").val();

    
    saveproductRating(ratingValue);
    
  });
  
 
  
});

  function logoutfunction(){
    window.location = "logout.php";
  }


function saveproductRating(ratingValue) {


  $("#starsvalue").val(ratingValue);
  //alert($("#starsvalue").val());

}


function addReviewModal(id){
    //var inc = id.split("+");
    var rating = $("#starsvalue").val();

    
    data = {"id" : id, "rating": rating}; //JSON Data Format
    $.ajax({
      url : '/Clothing Store/includes/addReviewModal.php',
      method : "post",
      data : data,
      success : function(data){
        $('body').append(data);
        $("#details-modal").modal('toggle');

      },
      error : function(){
        alert("Something went wrong");
      }
    });
  }

</script>
