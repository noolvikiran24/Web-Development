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

    <title>User Login Form | ABAX </title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
   <!-- <link href="css/animate.min.css" rel="stylesheet"> -->
    
</head>

<br>

<div class="col-lg-12 text-center ">
    <h1 class="text-light" style="font-family:Lucida Console">Welcome to ABAX Online Store</h1>
</div>

<br>

<body class="login bg-secondary">


<div class="login_wrapper card bg-light" style="width: 300px; height: 300px; margin-top: 10%; margin-left: 40%;">

    <section class="login_content" style="padding-top: 25%;">
         <h4 class="text-secondary text-center" style="margin-top: -50px;">User Login Form</h4>
        <form name="form1" action="" method="post" class="text-center">
           

            <div>
                <input type="text" name="username" class="form-group" placeholder="Username" required=""/>
            </div>
            <div>
                <input type="password" name="password" class="form-group" placeholder="Password" required=""/>
            </div>
            <div>

                <input class="btn btn-success" type="submit" name="login" value="Login">
                <a class="btn btn-success" href="#">Lost your password?</a>
            </div>

            <div class="clearfix"></div>

            <div class="separator" class="btn btn-success">
                <p class="change_link">New to site?
                    <a href="registration.php"> Create Account </a>
                </p>

                <div class="clearfix"></div>
                <br/>


            </div>
        </form>
    </section>


</div>

<?php 
    if(isset($_POST['login'])){

    $fetchCred = "SELECT * from customers where username='$_POST[username]' ";
    $credRes = mysqli_query($con,$fetchCred);
    $row=mysqli_fetch_assoc($credRes);
    $hash = $row['password'];
    $enteredpassword = $_POST['password'];

    if(password_verify($enteredpassword, $hash)){
        //echo "successful login";
        $_SESSION["borrusername"] = $_POST["username"];
        $_SESSION["firstname"] = $row["first_name"];
        $_SESSION["lastname"] = $row["last_name"];
        $fn = $_SESSION['firstname'];

        if($_SESSION['borrusername']!=admin){
        ?>


        <script type="text/javascript">
            alert("Successfully logged in as <?php echo $fn; ?>");
            window.location="index.php?maincategory=fashion";
        </script>
        <?php }
        else{
            ?> 
        <script type="text/javascript">
            alert("Successfully logged in as admin");
            window.location="admin/index.php?maincategory=fashion";
        </script><?php
        }
    }
    
    
    else{
        echo '<div class="alert alert-danger bg-danger col-lg-6 col-lg-push-3" style="margin-left: 40%; width: 300px;">
        <strong style="color:white">Wrong Credentials.</strong> Try again.
        </div>';
    }
}
?>




</body>
</html>
