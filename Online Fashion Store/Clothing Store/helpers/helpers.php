<?php 
function display_error_message($errors){
	$display="<ul class='alert alert-danger'>";
	foreach($errors as $error){
		//echo $error;
		$display.="<li>".$error."</li>";
	}
	$display.="</ul>";
	return $display;
} 

function sanitize($dirty){ //This is to make sure that we do not enter any html tags in the input box
	return htmlentities($dirty,ENT_QUOTES,"UTF-8");

}

 ?>