<?php 
require_once "coreDB/init.php";
//var_dump($_SESSION['cartid']);


$prodid = $_GET['prodid'];
//var_dump($prodid);
$prodid = (int)$prodid;

$cartDetailsQuery = "SELECT * FROM productreview WHERE product_id='$prodid'";
$cartDetailsResult = mysqli_query($con,$cartDetailsQuery);

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
        </ul>
      </div>
     
      <?php 
      $count = 0;
        while($cartItem = mysqli_fetch_assoc($cartDetailsResult)):
          //var_dump($row['items']);
         // $ordersJSON = $row['items'];
        //  $ordersJSON = json_decode($ordersJSON,true);
          //var_dump($cartDetailsResult);

          //foreach($ordersJSON as $cartItem): 
          $pullid = $cartItem['product_id'];
          //var_dump($pullid);
          $pullItemQ = "SELECT * FROM products WHERE id='$pullid'";
          $pullItemR = mysqli_query($con,$pullItemQ);
          $pullItemR = mysqli_fetch_assoc($pullItemR);

        ?>
        <div class="basket-product card" style="border: 0px;">
          <?php if($count==0){ ?>
          <div class="item">
            <div class="product-image">
              <img src="<?php echo $pullItemR['image']; ?>" alt="Placholder Image 2" class="product-frame img-thumbnail">
            </div>
            <div class="product-details card-body">
              <h1><strong><?php echo $pullItemR['title'];?></strong></h1>
              <p id="productCode">Product Code - <?php echo $cartItem['product_id'];?></p>
            </div>
           
          </div>
          
       

         <div class="card" style="padding: 11px; border: 0px;"><h6>Customer Reviews</h6></div> <?php }?>
          <div class="card" style="padding: 12px;">
           <div class="rating-stars">
              <ul id='stars'>
                <?php for($x=0; $x<$cartItem['product_rating']; $x++): ?>
                <li class='star selected'>
                  <i class='fa fa-star fa-fw'></i>
                </li>
                <?php endfor;?>
                 <?php for($x=0; $x<5-$cartItem['product_rating']; $x++): ?>
                <li class='star'>
                  <i class='fa fa-star fa-fw'></i>
                </li>
                <?php endfor;?>
               
              </ul>
              <div><p><?php echo $cartItem['product_review']; ?> </p> </div>
            </div>
          </div>

            <?php  ?>
            


        </div>
        
        
    <?php 
      $count++;
    endwhile;

    ?>

  
    </div>
   
    
  </main>
 
</body>


</html>
<script src="js/cartDetails.js" type="text/javascript"></script>
<script>


  
  /* 1. Visualizing things on Hover - See next part for action on click */
  
  
  function addrating(starRating){
    var onStar = parseInt(starRating, 10); // The star currently selected
    var stars = $(this).parent().children('li.star');
    
    for (i = 0; i < stars.length; i++) {
      $(stars[i]).removeClass('selected');
    }
    
    for (i = 0; i < onStar; i++) {
      $(stars[i]).addClass('selected');
    }
    
    // JUST RESPONSE (Not needed)
    var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);

    
    
  }
  
 



</script>
