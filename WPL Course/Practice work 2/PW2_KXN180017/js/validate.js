var span1 = document.createElement("span");
span1.setAttribute("id","span1");
span1.innerHTML = "span1";
span1.className = "ok";
span1.style.display = "none";

var username = document.getElementById("username");
username.parentNode.insertBefore(span1, username.nextSibling);

var span2 = document.createElement("span");
span2.setAttribute("id", "span2");
span2.innerHTML = "span2";
span2.className = "ok";
span2.style.display = "none";

var password = document.getElementById("password");
password.parentNode.insertBefore(span2, password.nextSibling);


var span3 = document.createElement("span");
span3.setAttribute("id", "span3");
span3.innerHTML = "span3";
span3.className = "ok";
span3.style.display = "none";

var email = document.getElementById("email");
email.parentNode.insertBefore(span3, email.nextSibling);

document.getElementById("username").addEventListener("focus", function(){
function infoEntry(){
	span1.innerHTML = "Username must contain only alphanumeric characters";
	span1.style.display = "inline";
	span1.className = "info";
}

function corrEntry(){
	span1.innerHTML = "OK";
	span1.style.display = "inline";
	
	span1.className = "ok";
}
function errEntry(){
	span1.innerHTML = "Error";
	span1.style.display = "error";
	
	span1.className = "error";
}

var val = this.value;
var allowed = /^[0-9a-zA-Z]+$/;
if(val===""){
	infoEntry();
}
else if(val.match(allowed)){
	corrEntry();
}
else{
	errEntry();
}

});
document.getElementById("username").addEventListener("blur", function(){


function corrEntry(){
	span1.innerHTML = "OK";
	span1.style.display = "inline";
	
	span1.className = "ok";
}
function errEntry(){
	span1.innerHTML = "Error";
	span1.style.display = "error";
	
	span1.className = "error";
}

var val = this.value;
var allowed = /^[0-9a-zA-Z]+$/;
if(val===""){
	span1.style.display = "none";
}
else if(val.match(allowed)){
	corrEntry();
}
else{
	errEntry();
}

});


document.getElementById("password").addEventListener("focus", function(){
function infoEntry(){
	span2.innerHTML = "Password must be atleast six characters long";
	span2.style.display = "inline";
	span2.className = "info";
}

function corrEntry(){
	span2.innerHTML = "OK";
	span2.style.display = "inline";
	
	span2.className = "ok";
}
function errEntry(){
	span2.innerHTML = "Error";
	span2.style.display = "error";
	
	span2.className = "error";
}

var val = this.value;
//var allowed = /^[0-9a-zA-Z]+$/;
if(val===""){
	infoEntry();
}
else if(val.length>=6){
	corrEntry();
}
else{
	errEntry();
}

});
document.getElementById("password").addEventListener("blur", function(){


function corrEntry(){
	span2.innerHTML = "OK";
	span2.style.display = "inline";
	
	span2.className = "ok";
}
function errEntry(){
	span2.innerHTML = "Error";
	span2.style.display = "error";
	
	span2.className = "error";
}

var val = this.value;
//var allowed = /^[0-9a-zA-Z]+$/;
if(val===""){
	span2.style.display = "none";
}
else if(val.length>=6){
	corrEntry();
}
else{
	errEntry();
}

});
document.getElementById("email").addEventListener("focus", function(){
function infoEntry(){
	span3.innerHTML = "Enter a valid email id, Example: abc@example.com";
	span3.style.display = "inline";
	span3.className = "info";
}

function corrEntry(){
	span3.innerHTML = "OK";
	span3.style.display = "inline";
	
	span3.className = "ok";
}
function errEntry(){
	span3.innerHTML = "Error";
	span3.style.display = "error";
	
	span3.className = "error";
}

var val = this.value;
//var allowed = /^[0-9a-zA-Z]+$/;
if(val===""){
	infoEntry();
}
else if(val.length>=6){
	corrEntry();
}
else{
	errEntry();
}

});
document.getElementById("email").addEventListener("blur", function(){

function corrEntry(){
	span3.innerHTML = "OK";
	span3.style.display = "inline";
	
	span3.className = "ok";
}
function errEntry(){
	span3.innerHTML = "Error";
	span3.style.display = "error";
	
	span3.className = "error";
}

var val = this.value;
var eVal = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
if(val===""){
	span3.style.display = "none";
}
else if(eVal.test(val)){
	corrEntry();
}
else{
	errEntry();
}

});


//document.getElementById("username").addEventListener("focus", myFunction);

