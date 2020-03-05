<?php require_once "coreDB/init.php";
include "includesAdmin/head.php";
include "includesAdmin/navigation.php";
//include "includesAdmin/header.php";
//include "includesAdmin/leftbar.php"; 
$prodid = $_GET['prodid'];
$maincategory = $_GET['maincategory'];
$sql = "SELECT * FROM products where id = '$prodid'";
$product = mysqli_query($con,$sql);
$product = mysqli_fetch_assoc($product);
if(isset($_POST['uploadimage'])){
    $img = $_FILES['fileupload']['name'];
    $img_loc = $_FILES['fileupload']['tmp_name'];
    $img_folder = "../images/".$maincategory.'/';
    if(move_uploaded_file($img_loc, $img_folder.$img)){ 
        //echo $img;

    } else{
        ?> <script>
            alert("File not uploaded");
        </script> <?php
    }
}

if(isset($_POST['addproduct'])){
    $img = $_FILES['fileupload']['name'];
    $img_loc = $_FILES['fileupload']['tmp_name'];
    $img_folder = "../images/".$maincategory.'/';
    if(move_uploaded_file($img_loc, $img_folder.$img)){ 
        //echo $img;

    } else{
        ?> <script>
            alert("File not uploaded");
        </script> <?php
    }

    $title = $_POST['title'];
    $price = $_POST['price'];
    $list_price =  $_POST['list_price'];
    $categories = $_POST['categories'];
    $description = $_POST['description'];
    $featured = $_POST['featured'];
    $categoryname = $_POST['categoryname'];
    $subcategoryname = $_POST['subcategoryname'];
    $imageurl = 'images/'.$maincategory.'/'.$img;
    $sizes = $_POST['sizes'];
    $productavailable = (int)$_POST['productavailable'];
    $query = "INSERT INTO  products (title,price,list_price, categories ,featured, description,categoryName, subcategoryName,  image, sizes, product_available ) VALUES('$title', '$price',  '$list_price', '$categories', '$featured',  '$description', '$categoryname',  '$subcategoryname','$imageurl', '$sizes', '$productavailable')";

    if(!mysqli_query($con, $query)){
        ?>
        <script>
            alert("<?php echo mysqli_error($con);?>");
        </script>
        <?php 
    }
    else{
        ?> 
        <script>
            alert("Added the product");
            window.location = "index.php?maincategory=fashion";
        </script>

        <?php
    }


}



?>

<div class="container-fluid row">
    <div class="col-md-2 card"></div>
    <div class="col-md-8 card" style="margin-top: 5%;">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
            <label for= "title">Product Title: </label>
            <input type= "text" id="title" name="title" value="<?php echo $product['title'];?>">
            </div>
            <div class="form-group">
            <!--<img src="<?php// echo '../'.$product['image']; ?>" alt="<?php// echo $product['title']; ?>" class="img-class img-thumbnail" /> -->
            <label for="fileupload"> Product Image</label>
            <input type="file" name="fileupload" id="fileupload" style="border: 10px; border-color: coral;">
            <!--<input type="submit" value="Upload Image" id="uploadimage" name="uploadimage" onclick="imageuploaded()"/>

            <input type="text" name="imageurl" value="<?php //echo $product['image']; ?>" id="imageurl"  style="width: 70%;"> 
            <label for="imageurl"> Image URL</label> -->
            </div>
            <div class="form-group">
                <label for= "price">Product Price: </label>
                <input type= "text" id="price" name="price" value="<?php echo $product['price'];?>"/>
            </div>
            <div class="form-group">
                <label for= "list_price">Product List Price: </label>
                <input type= "text" id="list_price" name="list_price" value="<?php echo $product['list_price'];?>"/>
            </div>
            <div class="form-group">
                <label for= "categories">Product Category No: </label>
                <input type= "text" id="categories" name="categories" value="<?php echo $product['categories'];?>"/>
            </div>
            <div class="form-group">
                <label for= "description">Product Description: </label>
                <input class="container-fluid"type= "text" id="description" name="description" value="<?php echo $product['description'];?>"/>
            </div>
            <div class="form-group">
                <label for= "featured">1 for featuring the product: </label>
                <input type= "text" id="featured" name="featured" value="<?php echo $product['featured'];?>"/>
            </div>
            <div class="form-group">
                <label for= "sizes">Sizes: </label>
                <input type= "text" id="sizes" name="sizes" value="<?php echo $product['sizes'];?>"/>
            </div>
            <div class="form-group">
                <label for= "categoryname">Product Category Name: </label>
                <input type= "text" id="categoryname" name="categoryname" value="<?php echo $product['categoryName'];?>"/>
            </div>
            <div class="form-group">
                <label for= "subcategoryname">Product Sub Category Name: </label>
                <input type= "text" id="subcategoryname" name="subcategoryname" value="<?php echo $product['subcategoryName'];?>"/>
            </div>
            <div class="form-group">
                <label for= "productavailable">Product Available?(1 => Yes and 0 => No) </label>
                <input type= "text" id="productavailable" name="productavailable" value="<?php echo $product['product_available'];?>"/>
            </div>
            <div class="form-group">
                
                <input type= "submit" class="btn btn-warning" id="addproduct" name="addproduct" value="Add Item"/>
                
            </div>
        </form>
    </div>
    <div class="col-md-2 card"></div>
</div>
<script>
   function imageuploaded(){
    $("#imageurl").val("images/<?php echo $maincategory.'/'.$img;?>");
   }

</script>

<?php include "includesAdmin/footer.php";?>


