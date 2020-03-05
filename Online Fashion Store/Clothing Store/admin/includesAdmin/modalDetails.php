 <?php 
  require_once "../coreDB/init.php";
  $id = $_POST['id'];
  $id = (int)$id;
  $sql = "SELECT * FROM products where id ='$id'";
  //var_dump($sql);
  $result = mysqli_query($con,$sql);
  $product = mysqli_fetch_assoc($result);
  $brandid = $product['brand'];

  $query = "SELECT brand from brand where id='$brandid'";
  $brand1 = mysqli_query($con,$query);
  $brand = mysqli_fetch_assoc($brand1);
  $brand = $brand['brand'];


 $size_prod = $product['sizes'];
 $sizes_array = explode(',',$size_prod);





  
 ?>



 <!-- Modal Details -->

 <?php ob_start(); ?>
  <div class="modal fade details-1" id="details-modal" tabindex="-1" role="dialog" aria-labelledby="Details">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title text-center"><?php echo $product['title'];
          //var_dump($product);
        ?></h4>
        <button class="close" type="button" onclick ="closemodal()" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-6">
              <div id="modal-errors"></div>
              <div class="center-block">
                <img src= "../<?php echo $product['image']; ?>" alt="<?php echo $product['title'];?>" class="details img-responsive"/>
              </div>

            </div>
            <div class="col-sm-6">
              <h4>Details</h4>
              <p><?php echo $product['description'];?></p>
              <hr>
              <p>Price: $<?php echo $product['price'];?></p>
              <p>Brand: <?php echo $brand; ?>
              </p>
              <form action="add_cart.php" method="POST" id="add_product_form">
                <input type="hidden" name="product_id" value="<?php echo $id;?>"> <!-- This is to take the value of the size selected -->
                 <!--This is to have a value of the available count, This is updated as and when size is changed in the event capturing function below $(#size).change -->

                <div class="form-group">
                  <div class="row">
                    <div class="col-xs-6" style="padding-right: 2px;">
                      <label for="quantity" style="padding-right:10px;">Quantity</label>
                      <input type="text" id="quantity" class="form-control" style="padding-right: 10px; width: 100px;" name="quantity">
                    </div>
                    <div class="col-xs-6">
                    <label for="size">Size </label>
                  <select id="size" class="form-control name="size">
                    <option value=''></option>
                    <?php 

                    foreach($sizes_array as $string){

                      $string_array = explode(':', $string);

                      $size = $string_array[0];
                      $available = $string_array[1];
                      echo '<option value="'.$size.'" data-size="'.$size.'" data-available="'.$available.'">'.$size.'</option>';

                    } ?>
                   
                  </select>
                    
                    <input type="hidden" name="available" id="available" value="">
                     <input type="hidden" name="size1" id="size1" value="">
                    </div>
                    
                  </div>
                  <div class="row" style="margin-top:3px;">
                    <div class="col-xs-3">
                      <label for="#avail1">Available</label>
                      <input class="form-control" type="text" value="" name="avai" id="avail1" style="width:50px;"readonly>
                    </div>
                    </div>
                </div>
            <!--    <div class="form-group">
                  <label for="size">Size: </label>
                  <select id="size" class="form-control name="size">
                    <?php 

                    //foreach($sizes_array as $string){

                      //$string_array = explode(':', $string);

                     // $size = $string_array[0];
                      //$quantity = $string_array[1];
                    //  echo '<option value="'.$size.'">'.$size.' (Available: '.$quantity.')</option>';

                   // } ?>
                   
                  </select>

                </div> -->
              </form>

            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-warning" onclick="closemodal()">Close</button>
        
        <button type="submit" class="btn btn-warning" onclick="addcart()"><span style="padding: 2px;"><i class="fas fa-shopping-cart"></i></span>Add</button>
      
      </div>
    </div>
    </div>
    
  </div>
  <div></div>
  <script>

    $("#size").change(function(){
      var size1 = $("#size option:selected").data("size");
      var available = $("#size option:selected").data("available"); // The value of available size quantity is selected.
      $("#available").val(available); 
       $("#avail1").val(available); 
       $("#size1").val(size1);// The input field available is updated.
    
    });
    function closemodal(){
      $("#details-modal").modal('hide');
      setTimeout(function(){
        $("#details-modal").remove();
        $(".modal-backdrop").remove();
      },500)
    }


  </script>
  <?php echo ob_get_clean(); ?>
