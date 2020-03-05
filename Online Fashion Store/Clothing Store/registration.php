<?php 
    require_once "coreDB/init.php";

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>User Sign up Form | ABAX </title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
   <!-- <link href="css/animate.min.css" rel="stylesheet"> -->
    
    <style type="text/css">
        .login_content div{
            padding: 3px;
        }
        
    </style>
</head>


<br>

<div class="col-lg-12 text-center ">
    <h1 class="text-light" style="font-family:Lucida Console">Welcome to ABAX Online Store</h1>
</div>

<br>

<body class="login bg-secondary">


<div class="login_wrapper card bg-light" style="width: 500px; height: 550px; margin-top: 2%; margin-left: 35%;">

     <section class="login_content" style="margin-top: 5%;">
                <form name="form1" action="" method="post">
                    <h2 class="text-center">Customer Registration Form</h2><br>

                    <div>
                        <input type="text" class="form-control" placeholder="First Name" id="firstname" name="firstname" required=""/>
                    </div>
                    <div>
                        <input type="text" class="form-control" placeholder="Last Name" id="lastname" name="lastname" required=""/>
                    </div>

                    <div>
                        <input type="text" class="form-control" placeholder="Username" id="username" name="username" required=""/>
                    </div>
                    <div>
                        <input type="password" class="form-control" placeholder="Password" id="password" name="password" required=""  onkeyup="passwordChecker($(this).val())"/>
                        <input class="container-fluid bg-danger text-light" type="hidden" value="Password strength very low" name="passerr" id="passerr" readonly />
                    </div>
                    <div>
                        <input type="text" class="form-control" placeholder="Address" name="address" />
                    </div>
                    <div>
                        <input type="text" class="form-control" placeholder="City" name="city" />
                    </div>
                    <div>
                        <input type="text" class="form-control" placeholder="State" name="state" />
                    </div>
                    <div>
                        <input type="text" class="form-control" placeholder="Pin Code" name="pincode"/>
                    </div>
                    <div class="">
                        <input class="btn btn-default bg-success" type="submit" name="submit1" onclick="errorFunction()" value="Register">
                    </div>

                </form>
                <div class="">
                        <a href = "login.php" class="tex-primary">Return back to Login</a>
                    </div>
            </section>


</div>

 <script type="text/javascript">
    function errorFunction(){
    var err = "<div class='bg-danger' style='width: 500px; margin-left: 35%;'><ul>";
    if($("#firstname").val()==""){
        err+="<li class='text-light'>First Name cannot be empty</li>";
    }
    if($("#lastname").val()==""){
        err+="<li class='text-light'>Last Name cannot be empty</li>";
    }
    if($("#username").val()==""){
        err+="<li class='text-light'>Username cannot be empty</li>";
    }
    if($("#password").val()==""){
        err+="<li class='text-light'>Password cannot be empty</li>";
    }
    var username = $("#username").val();
    $.ajax({
          url: '/Clothing Store/parser/checkusername.php',
          method: 'POST',
          data: {"username": username},
          success: function(data){
            //location.reload();
            if(data.length!=0){
            alert(data); }
           
             //location.reload();
          },
          error: function(){
            alert("Something went wrong");
          }
        });


    err+="</ul></div>";

    $("body").append(err);




}

function passwordChecker(pass){
    if(pass.length==0){
        return;
    }
    var regex = new Array();
        regex.push("[A-Z]"); //Uppercase Alphabet.
        regex.push("[a-z]"); //Lowercase Alphabet.
        regex.push("[0-9]"); //Digit.
        regex.push("[$@$!%*#?&]"); //Special Character.

        var passed = 0;
 
        //Validate for each Regular Expression.
        for (var i = 0; i < regex.length; i++) {
            if (new RegExp(regex[i]).test(pass)) {
                passed++;
            }
        }
        if (passed > 2 && password.length > 8) {
            passed++;
        }

        console.log(passed);

        if(passed<4){
           $("#passerr").prop('type','text');
        }
        else{
            $("#passerr").prop('type','hidden');
        }



}

    
    </script>

<?php 
      if(isset($_POST['submit1'])){ 
       

        

        $p = $_POST['password'];
       $pass= password_hash("$p", PASSWORD_DEFAULT);
        //var_dump($con);
        $insertSql = "INSERT INTO customers(first_name, last_name, username, password, address, city, state, pincode) VALUES('$_POST[firstname]','$_POST[lastname]','$_POST[username]','$pass','$_POST[address]','$_POST[city]','$_POST[state]','$_POST[pincode]')" ;
        if(mysqli_query($con,$insertSql)){
            echo  '<div class="alert alert-success col-lg-6 col-lg-push-3" style="width: 500px; margin-left: 35%">
                    Registration successful.
                        </div>';
        }
        else{
            echo '<div class="alert alert-danger col-lg-6 col-lg-push-3 bg-danger" style="width: 500px; margin-left: 35%;">
                <strong style="color:white">Error: </strong>'.mysqli_error($con).'</div>';
            }

    }
?>




</body>
</html>
