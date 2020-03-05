<?php 
  require_once "../coreDB/init.php";
  $prodid = $_POST['id'];
  $rating = $_POST['rating'];
  $rating = (int)$rating;

  
  //var_dump($ratingValue);
  $prodid = (int)$prodid;

  
   // echo $_POST['hiddenreview'];
  $review = $_POST['review'];
  $postreview = "INSERT INTO productreview(product_id, customer_username, order_id, product_rating, product_review) VALUES('$prodid', 'kirannoolvi', '1', '$rating', '$review')";

  if(!mysqli_query($con,$postreview)){
    echo mysqli_error($con);
  }
  else{
    echo "Thanks for reviewing the product!";
  }




  
 ?>