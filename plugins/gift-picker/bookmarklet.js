/* 
BumponBoard Bookmarklet
Copyright 2021 
Author: Chris Brown
*/

var theid = 666;
//this 666 will be replaced by the id passed from the button

//open a window
var myWindow = window.open("", "MsgWindow", "left=50%,width=400,height=300");


// display something
var output = "<p>This is 'MsgWindow'. " + theid + "</p>";
output = output + "<p>This is 'sausage'. " + theid + "</p>";
output = output + "<p id='right'>This is change</p>";
var data_from_ajax;


myWindow.document.write(output);


var x = document.getElementById("right");
x.innerHTML = '<?php include_once "/wp-content/plugins/gift-picker/gift-picker.php?id=3";?>';