$(document).ready(function(){
$.getJSON( "js/data.json")
  .done(success)
  .fail(function( jqxhr, status, error ) {

    var er = status + ", " + error;
    console.log( "Request was failed: " + er );
    alert("Request was failed: " + er);
});


});
function success(data){
  $(".gallery").empty();
    $.each(data, function(i, imageData){
        $(".gallery").append("<li>"
                        +"<img src="
                        +"'images/square/"
                        +imageData.path
                        +"' alt='"
                        +imageData.title
                        +"'>"
                        +"</li>"
                    );
    });


$(".gallery").children().mouseenter(function(event){
 	
 	var image = $(this).find("img");
 	var imageTitle = image.attr("alt");
 	var city;
 	var description;
 	var taken;
 	var country;

 	var imagePath = "images/medium/";
      
     image.addClass("gray");
 	$(data).each(function(){
 		if((this.title)==imageTitle){
 			imagePath = imagePath+ this.path;
 			 city = this.city;
 			 description = this.description;
 			 taken = this.taken;
 			 country = this.country;
 			return;
 		}

 	});

 	$("body").append("<div id='"+"preview"+"'>"+"<img src='"+imagePath+"' alt='"+imageTitle +"'>"
                        +"<p>"+description+"</p>"+"<p>"+"<i>"+city+", "+country+" ["+ taken+"]"+"</i>"+"</p>"+"</div>");

        $("#preview").fadeIn("fast");
        $("#preview").css({
            zIndex: 1,
            top: event.pageY+15,
            left: event.pageX+15
        });

});

    $(".gallery").children().mouseleave(function(){
        $("body").find("#preview").remove();
        $(this).find("img").removeClass("gray");
      
    });

    $(".gallery").children().mousemove(function(event){
        $("#preview").css({
            zIndex: 1,
            top: event.pageY+15,
            left: event.pageX+15
        });
    });

}