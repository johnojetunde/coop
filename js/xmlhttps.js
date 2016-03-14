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
//alert(serverPage);
var theimg;
xmlhttp = getxmlhttp ();
xmlhttp.open("GET", serverPage);
xmlhttp.onreadystatechange = function() {
if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
document.getElementById(obj).innerHTML = xmlhttp.responseText;
}
}

xmlhttp.send(null);
setTimeout(function(){processajax (obj, serverPage);},30*100);
}

function check_function(nid,obj, serverPage){
var theimg = document.getElementById(nid).value;
serverPage = serverPage+theimg;

xmlhttp = getxmlhttp ();
//alert(serverPage);
xmlhttp.open("GET", serverPage);
xmlhttp.onreadystatechange = function() {
if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

document.getElementById(obj).innerHTML = xmlhttp.responseText;
}
}

xmlhttp.send(null);
}
function third_process_ajax(obj,serverPage){
alert(serverPage);
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


function on_select_here(id,amount_loan,serverPage){

var value = document.getElementById(id).value;
serverPage = serverPage+"?select_drop_down="+value;

//alert(serverPage);
xmlhttp = getxmlhttp ();
xmlhttp.open("GET", serverPage);
xmlhttp.onreadystatechange = function() {
if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
//alert(xmlhttp.responseText);
document.getElementById(amount_loan).innerHTML = xmlhttp.responseText;
}
}

xmlhttp.send(null);
}
function sure_decline(){
var ans = confirm("Are you sure you want to decline this application");
return ans;
}
function pmatch(){
var pass = document.getElementById("pass").value;
var cpass = document.getElementById("cpass").value;
if(pass==cpass){
document.getElementById("submit_button").disabled = false;
document.getElementById("beside_pword").innerHTML = "<span style='color:green;'> <i class='fa fa-check'></i> Password Match </span>";
}else{
document.getElementById("submit_button").disabled = true;
document.getElementById("beside_pword").innerHTML = "<span style='color:red;'> <i class='fa fa-ban'></i> Password does not match </span>";
}
}
function sure_del_cat(){
var ans = confirm("Are you sure you want to delete this category");
return ans;
}


function sure_del_cat_rate(){
var ans = confirm("Are you sure you want to delete this interest rate");
return ans;
}

function submitform (theform, serverPage, objID){
//alert("THe submit button has been clicked");
//alert(serverPage);
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
	//var editMode = document.getElementById("editMode").value;
	 
	if($('#editMode').length){
		
	}else{
$('form').trigger("reset");
		}
obj.innerHTML = xmlhttp.responseText;


}else{
obj.innerHTML = "<img src='img/ajax-loader.gif' />";
}

}
//processajax ('body', 'catacata.php');
xmlhttp.send(str);

}