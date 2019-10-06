
$("ul").on("click", "li", function() {
	
	$(this).toggleClass("done");
});

$("#addtodobutton").click(function(){
	$("#newtodo").fadeToggle()
});

$("ul").on("click", ".deleteIcon", function(event){
	$(this).parent().fadeOut(500, function(){
		$(this).remove();
	});
	event.stopPropagation();
});

$("#newtodo").keypress(function(event){
	if(event.which === 13) {
		var newtodotext = $("#newtodo").val();
		console.log(newtodotext);
		$("#newtodo").val("");

		$("ul").append("<li><span class='deleteIcon'><i class='fa fa-trash'></i></span> " + newtodotext + "</li>");

			
	}
});


