<?php 
 session_start();
 unset($_SESSION["borrusername"]);
 unset($_SESSION['cartid']);

?>
<script type="text/javascript">
	alert("Successfully Logged Out");
	window.location = "login.php";


</script>