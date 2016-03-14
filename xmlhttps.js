//xmlhttps.js
//Function to create an XMLHttp Object.
function getxmlhttp (){
//Create a boolean variable to check for a valid Microsoft ActiveX instance.
var xmlhttp = false;
//Check if we are using Internet Explorer.
try {
//If the JavaScript version is greater than 5.
xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
} catch (e) {
//If not, then use the older ActiveX object.
try {
//If we are using Internet Explorer.
xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
} catch (E) {
//Else we must be using a non-Internet Explorer browser.
xmlhttp = false;
}
}
// If we are not using IE, create a JavaScript instance of the object.
if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
xmlhttp = new XMLHttpRequest();
}
//processajax ('body', 'catacata.php');
return xmlhttp;
}



function processajax_del (obj, serverPage){
var response = confirm("Are you sure you want to delete this product from cart?");
if(response){
//Get an XMLHttpRequest object for use.
var theimg;
xmlhttp = getxmlhttp ();
xmlhttp.open("GET", serverPage);
xmlhttp.onreadystatechange = function() {
if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
document.getElementById(obj).innerHTML = xmlhttp.responseText;
}
}

xmlhttp.send(null);
}else{

}

}

//Function to process an XMLHttpRequest.
function processajax (obj, serverPage){
//alert(serverPage);
//Get an XMLHttpRequest object for use.
var theimg;
xmlhttp = getxmlhttp ();
xmlhttp.open("GET", serverPage);
xmlhttp.onreadystatechange = function() {
if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
document.getElementById(obj).innerHTML = xmlhttp.responseText;
}
}

xmlhttp.send(null);
}


function third_process_ajax(obj,serverPage,qtyid){
var quantity = document.getElementById(qtyid).value;
//alert(quantity);
serverPage = serverPage+"&&quantity="+quantity;
var theimg;
xmlhttp = getxmlhttp ();
xmlhttp.open("GET", serverPage);
xmlhttp.onreadystatechange = function() {
if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
document.getElementById(obj).innerHTML = xmlhttp.responseText;
}
}

xmlhttp.send(null);

}


function validate(field,obj,id){

var username  = document.getElementById(id).value;
if(field=="username"){
var serverPage = "homepage.php?validate_uname="+username;
}else if(field=="email"){
var serverPage = "homepage.php?validate_email="+username;
}
xmlhttp = getxmlhttp ();
xmlhttp.open("GET", serverPage);
xmlhttp.onreadystatechange = function() {
if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
document.getElementById(obj).innerHTML = xmlhttp.responseText;
}
}
xmlhttp.send(null);
}
function pmatch(){
var pass = document.getElementById("pass").value;
var cpass = document.getElementById("cpass").value;
if(pass==cpass){
document.getElementById("beside_pword").innerHTML = "<span style='color:green;'> <img src='img/accept.png' /> Password Match </span>";
}else{
document.getElementById("beside_pword").innerHTML = "<span style='color:red;'> <img src='img/cancel.png' /> Password does not match </span>";
}
}
function submitform (theform, serverPage, objID){
//alert("THe submit button has been clicked");
xmlhttp = getxmlhttp ();
var file = serverPage;
var fobj = theform;

//alert(fobj);
var str = "";

for(var i = 0; i < fobj.elements.length; i++){
var namer = fobj.elements[i].name;
if(namer=="checkbox[]"){
var checked = fobj.elements[i].checked;
if(checked){
str += fobj.elements[i].name + "=" + escape(fobj.elements[i].value) + "&";
}else{
}
}else{
str += fobj.elements[i].name + "=" + escape(fobj.elements[i].value) + "&";
}


//alert(fobj.elements[i].name + "=" + escape(fobj.elements[i].value) + "&")
}

//alert(objID);
//If the validation is ok.

obj = document.getElementById(objID);

//general_form (serverPage, obj, "post", str);
xmlhttp.open("POST", serverPage, true);
xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8");
//alert(xmlhttp.status);
xmlhttp.onreadystatechange = function() {
if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

obj.innerHTML = xmlhttp.responseText;

}else{
obj.innerHTML = "<img src='img/32.gif' />";
}

}
//processajax ('body', 'catacata.php');
xmlhttp.send(str);

}