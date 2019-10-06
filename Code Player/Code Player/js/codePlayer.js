function iframeUpdate(){
	$("iframe").contents().find("html").html("<html><head><style type='text/css'>"+ $("#cssContent").val() +"</style></head><body>"+ $("#htmlContent").val() +"</body></html>");
	document.getElementById("outputContent").contentWindow.eval($("#javascriptContent").val());
}

$(".toggleButton").hover(function(){
	$(this).css("background-color", "#AAAAAA");
}, function(){
	$(this).css("background-color", "#343a40");
});
$(".toggleButton").click(function(){
	$(this).toggleClass("active");
	var codeId = $(this).attr("id") + "Content";
	$("#"+ codeId).toggleClass("hidden");
	var activePanels = 4 - $(".hidden").length;
	$(".panel").width(($(window).width())/activePanels - 30);
});
$(".panel").height($(window).height() - $(".navbar").height());
$(".panel").width($(window).width()/2 - 10);
 iframeUpdate();

$("textarea").on('change keyup paste', function() {
    
   iframeUpdate();
});
