  <!-- Navbar -->

  <?php 

  $maincategory = $_GET['maincategory'];
  if($_GET['category']){
    $sql = "SELECT maincategory from categories where category = '$_GET[category]'";
    $maincategory = mysqli_query($con,  $sql);
    $maincategory = mysqli_fetch_assoc($maincategory);
    $maincategory = $maincategory['maincategory'];
  }
  
  $categoryQuery = "SELECT * FROM categories where maincategory='$maincategory'";
  $categories =mysqli_query($con, $categoryQuery);
  //var_dump($_SESSION['cartid']);
  if($_SESSION['cartid']){
  $cartid = $_SESSION['cartid'];
  //echo($cartid );
  $cartQuery = "SELECT * FROM cart WHERE id='$cartid'";
  $cartResult = mysqli_query($con, $cartQuery);
  $cartResult = mysqli_fetch_assoc($cartResult);
  $cartResultItems = $cartResult['items'];
  $cartResultItem = json_decode($cartResultItems,true);
  //echo $cartResultItems;
  //echo $cartResultItems;
  
  $cartResultArray = explode('},',$cartResultItems);

   $c=count($cartResultArray); }
   else{
    $c=0;
   }


 

  ?>
   <nav class="navbar navbar-expand-lg navbar-light bg-secondary navbar-fixed-top" style="margin-top: -10px; position: fixed; z-index: 99;">
  <a class="navbar-brand" href="index.php?maincategory=fashion">ABAX</a>
 <?php 

 while($category = mysqli_fetch_assoc($categories)) : ?>
  <?php
    
    $parent_id = $category['id']; 
    $subcatquery="SELECT * FROM categories where parent = '$parent_id'";
    $subcat = mysqli_query($con, $subcatquery);


  ?>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      
      <li class="nav-item dropdown active">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php echo $category['category'];?>
        </a>
      

        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
         <?php while($sub = mysqli_fetch_assoc($subcat)) : ?>
          <a class="dropdown-item" href="index.php?category=<?php echo $category['category']?>&subcategory=<?php echo $sub['category'];?>"><?php echo $sub['category']; ?></a>
          <?php endwhile; ?>
        </div>
      </li>
    <?php endwhile; ?>
     
    </ul>
  
  <div  style="margin-left: 490px;">
  <form method="POST" class="form-inline my-2 my-lg-0" >
      <input name="searchbox" id="searchbox" class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <input name="searchbutton" id="searchbutton" class="btn btn-outline-success my-2 my-sm-0" type="submit" value="Search"/>
    </form>
   </div>
  <!--<div class="justify-content-end navbar-right ml-auto">
    <ul class="navbar-nav ml-auto">
       <li class="nav-item active">
        <button class="btn btn-outline-warning my-2 my-sm-0" type="submit"><i class="fas fa-shopping-cart"></i>Cart</button>
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span style="padding: 2px;"><i class="fas fa-shopping-cart"></i></span>Cart(<?php //echo $c;?>)</a>
      </li>


    </ul>

  </div> -->
  <div class="navbar-right" style="padding-left: 5px;">
     <button id ="cartdetailsbutton" class="btn btn-outline-dark my-2 my-sm-0" type="submit" onclick="cartFunction()"><i class="fas fa-shopping-cart"></i>Cart(<?php echo $c;?>)</button>
  </div>
  <?php 
    if(!$_SESSION["borrusername"]){
  ?>
  <div class="navbar-right" style="padding-left: 5px;">
     <button id ="loginbutton" class="btn btn-outline-dark my-2 my-sm-0" type="submit" onclick="loginfunction()">Log in</button>
  </div>
<?php } 
 
   else{
  ?>
  <div class="navbar-right" style="padding-left: 5px;">
     <button id ="loginbutton" class="btn btn-outline-dark my-2 my-sm-0" type="submit" onclick="logoutfunction()">Log Out</button>
  </div>

<?php } ?>

 <div class="navbar-right" style="padding-left: 5px;">
     <button id ="myorders" class="btn btn-outline-dark my-2 my-sm-0" type="submit" onclick="clickorders()">Orders</button>
  </div>


    
  </div>
</nav>

