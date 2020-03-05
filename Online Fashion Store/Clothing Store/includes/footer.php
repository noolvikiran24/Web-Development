 
</div>

 <footer class="text-center page-footer font-small blue" id="footer">&copy; Copyright: 2009 - 2021 ABAX Store</footer>

 <script>
    $(window).scroll(function(){
      var vs = $(this).scrollTop();
      $("#logotext").css({
        "transform": "translate(0px, "+vs/2+"px)"

        });
    });

  function modalDetails(id){
  	data = {"id" : id}; //JSON Data Format
  	$.ajax({
  		url : '/Clothing Store/includes/modalDetails.php',
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

   function addcart(){
     $("#modal-errors").html("");
      var size = $("#size").val();
      var quantity = $("#quantity").val();
      var errors="";
      var available = $("#available").val();
      // console.log(available);
      //alert(available);
      var data = $("#add_product_form").serialize(); //Takes all the form elements and makes it to get elements
      if(size == '' || quantity==''|| quantity==0){
        errors+="<p class='text-danger text-center'>Size and Quantity cannot be blank</p>";
        $("#modal-errors").html(errors);
        return;
      }


      else if(quantity > available){
         errors+="<p class='text-danger text-center'>"+quantity+" quantities of the product are not available</p>";
        $("#modal-errors").html(errors);
         return;
      }

      else{
        $.ajax({
          url: '/Clothing Store/parser/addcart.php',
          method: 'POST',
          data: data,
          success: function(data){
            //location.reload();
            alert(data);
             location.reload();
          },
          error: function(){
            alert("Something went wrong");
          }
        });
      }

    
      
      }

    function cartFunction(){

      window.location ='cartdetails.php';
     /* data = {"id" : id};
        $.ajax({
          url: '/Clothing Store/includes/cartDetails.php',
          method: 'POST',
          data: data,
          success: function(data){
            //location.reload();
             alert(data);
             location.reload();
          },
          error: function(){
            alert("Something went wrong");
          }
        }); 
*/
      } 
      function loginfunction(){
        window.location="login.php";
      }
      function logoutfunction(){
        window.location="logout.php";
      }

      function clickorders(){
        window.location = "orders.php";
      }
     
    
  </script>
   
  </body>
</html>