<?php 
require_once "coreDB/init.php";
include "includesAdmin/head.php";
include "includesAdmin/navigation.php";
include "includesAdmin/header.php";
include "includesAdmin/leftbar.php";
$mainCategory = $_GET['maincategory'];

//var_dump($mainCategory);

$sql = "SELECT * FROM products as p INNER JOIN categories as c ON c.category = p.categoryName where c.maincategory='$mainCategory' and p.featured='1'";

if($_GET['category'] && $_GET['subcategory']){
  $category = $_GET['category'];
  $subcategory = $_GET['subcategory'];

  $fetchMaincategory = "SELECT maincategory from categories where category = '$category'";
  $fetchMaincategory = mysqli_query($con, $fetchMaincategory);
  $fetchMaincategory = mysqli_fetch_assoc($fetchMaincategory);
  $mainCategory = $fetchMaincategory['maincategory'];

  $sql = "SELECT * FROM products where categoryName='$category' AND subcategoryName='$subcategory'";
}
if($_POST['searchbutton']){
  $searchtext = $_POST['searchbox'];
  $sql.=" AND title LIKE '%$searchtext%'";
}

$featuredProd = mysqli_query($con, $sql);
if(!mysqli_query($con, $sql)){
  echo mysqli_error($con);
}
if($_SESSION["borrusername"]!="admin"){
  session_unset();
  ?>
  <script>
    window.location = "/Clothing Store/login.php";
  </script>
  <?php
}
$username =  $_SESSION["borrusername"];

//echo $username;
?>
    <!-- MIDDLE BAR -->


    <div class="col-md-8">
      <h2 class="text-center">
      <?php if($_GET['category'] && $_GET['subcategory']){ echo $_GET['category'].' -> '.$_GET['subcategory'];} else{echo 'Featured Products'; }?>

      </h2>
      <div class="row">
        <?php while($row = mysqli_fetch_assoc($featuredProd)): ?>
          <?php 
            $getId = "SELECT id FROM products WHERE title = '$row[title]'";
            $getId = mysqli_query($con, $getId);
            $getId = mysqli_fetch_assoc($getId);
            $getId = $getId['id'];

          ?>
          <div class="col-md-3 card bg-light" style="margin: 0px;"> 
            <h4 class="card-title text-center"><?php echo $row['title'];?></h4>
            <img src="<?php echo '../'.$row['image']; ?>" alt="<?php echo $row['title']; ?>" class="img-class img-thumbnail" />
           <?php if(((int)$row['list_price'])>0  && ((int)($row['product_available'])!=0)){?>
            <p class="list-price text-danger">List price: $<s><?php echo $row['list_price']; ?></s></p>
            <?php }else if((int)($row['product_available'])!=0){?>
              <p class="list-price text-danger" style="padding-top: 25px;"></p>
            <?php }?>
            
            <?php if((int)($row['product_available'])==0):?>
                 <p class="text-danger">{Out of stock}</p>
            <?php endif?>
            <p class="price">Our price: $ <?php echo $row['price']; ?></p>

            <p class="text-center"><a href="editproduct.php?maincategory=<?php echo $mainCategory;?>&prodid=<?php echo $getId;?>" class="text-primary">Edit Product</a></p> 
            <button type="button" class="btn btn-sm btn-success" onclick="modalDetails(<?php echo $getId; ?>)">Details</button>
          </div>
      <?php endwhile; ?>
      </div>
  </div>
  <?php 
    //include "includes/modalDetails.php";
    include "includesAdmin/rightbar.php";
    include "includesAdmin/footer.php";
   ?>


 
   