 <?php 
  require_once "../coreDB/init.php";
  $prodid = $_POST['id'];
  $rating = $_POST['rating'];
  $rating = (int)$rating;
  //var_dump($ratingValue);
  $prodid = (int)$prodid;
  $sql = "SELECT * FROM products where id ='$prodid'";
  //var_dump($sql);
  $result = mysqli_query($con,$sql);
  $product = mysqli_fetch_assoc($result);

  
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
              
              <form action="" method="POST" id="product_review_form">
                <input type="text" name="reviewValueText" id="reviewValueText" value="" placeholder="What did you like or dislike about the product?" style="width: 700px;"/>
                <input type="hidden" id="hiddenreview" name="hiddenreview" value=""/>

              </form>

            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-warning" onclick="closemodal()">Close</button>
        <button type="submit" class="btn btn-warning" onclick ="submitreviewfunction(<?php echo $prodid;?>, <?php echo $rating;?>)">Submit</button>
      
      </div>
    </div>
    </div>
    
  </div>
  <div></div>
  <script>
    function closemodal(){
      $("#details-modal").modal('hide');
      setTimeout(function(){
        $("#details-modal").remove();
        $(".modal-backdrop").remove();
      },500)
    }

    function submitreviewfunction(id, rating){
      var review = $("#reviewValueText").val();
      data = {"id" : id, "rating" : rating, "review" : review}; //JSON Data Format

      $.ajax({
      url : '/Clothing Store/parser/updateReview.php',
      method : "post",
      data : data,
      success : function(data){
        alert(data);
        location.reload();

      },
      error : function(){
        alert("Something went wrong");
      }
    });
      
    }


  </script>
  <?php echo ob_get_clean(); ?>
