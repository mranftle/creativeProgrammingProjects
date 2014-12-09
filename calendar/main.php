<html lang="en">
<head>
  <meta charset="utf-8">
  <title>home</title>
  <style>
  div {
    border: 2px solid #a1a1a1;
    width: 100px;
    height: 100px;
}
.bigDay{
 border: 2px solid #a1a1a1;
 border-spacing: 1px;
    width: 24%;
    height: 75%;
    margin-top:2px;
}
.event{
	height: 20px;
	
	border:0px;
	padding-bottom: 0px;
	padding-top: 0px;
	white-space: nowrap;
 	overflow: hidden;
}
.bigEvent{
	height: 100px;
	width:100%;
	border:0px;
	padding-bottom: 0px;
	padding-top: 0px;
	
 	overflow: hidden;
}
#a{
	background: #6699FF;
}
#b{
	background: #FF6666;	
}

table{
border-collapse: separate;
border-spacing: 1px;
/*background:grey;*/
}

  </style>
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>

</head>
<body>
<a href="calendar.php">cal</a>
<a href="login.php?logout=true">Logout</a>
<button id="button">refresh</button>
<select id="Month">
<option value="1">January</option>
<option value="2" selected="selected">February</option>
<option value="3">March</option>
<option value="4">April</option>
<option value="5">May</option>
<option value="6">June</option>
<option value="7">July</option>
<option value="8">August</option>
<option value="9">September</option>
<option value="10">October</option>
<option value="11">November</option>
<option value="12">December</option>
</select>
<br>

<br>
<table style="width:75%;float:left;">
  <tr>
	<td><div class="day" value="_1"></div> </td>
	<td><div class="day" value="_2"></div> </td>
	<td><div class="day" value="_3"></div> </td>
	<td><div class="day" value="_4"></div> </td>
	<td><div class="day" value="_5"></div> </td>
	<td><div class="day" value="_6"></div> </td>
	<td><div class="day" value="_7"></div> </td>
	</tr>
	<tr>
	<td><div class="day" value="_8"></div> </td>
	<td><div class="day" value="_9"></div> </td>
	<td><div class="day" value="_10"></div> </td>
	<td><div class="day" value="_11"></div> </td>
	<td><div class="day" value="_12"></div> </td>
	<td><div class="day" value="_13"></div> </td>
	<td><div class="day" value="_14"></div> </td>
	</tr>
	<tr>
	<td><div class="day" value="_15"></div> </td>
	<td><div class="day" value="_16"></div> </td>
	<td><div class="day" value="_17"></div> </td>
	<td><div class="day" value="_18"></div> </td>
	<td><div class="day" value="_19"></div> </td>
	<td><div class="day" value="_20"></div> </td>
	<td><div class="day" value="_21"></div> </td>
	</tr>
	<tr>
	<td><div class="day" value="_22"></div> </td>
	<td><div class="day" value="_23"></div> </td>
	<td><div class="day" value="_24"></div> </td>
	<td><div class="day" value="_25"></div> </td>
	<td><div class="day" value="_26"></div> </td>
	<td><div class="day" value="_27"></div> </td>
	<td><div class="day" value="_28"></div> </td>
	</tr>
	<tr>
	<td><div class="day" value="_29"></div> </td>
	<td><div class="day" value="_30"></div> </td>
	<td><div class="day" value="_31"></div> </td>
	<td><div class="day" value="_32"></div> </td>
	<td><div class="day" value="_33"></div> </td>
	<td><div class="day" value="_34"></div> </td>
	<td><div class="day" value="_35"></div> </td>
	</tr>
</table>
 <div class="bigDay" style="float:right;"></div>
 <div>
 ----------------
ADD EVENT <br>
<form action="addEvent.php" id ="addForm" method="POST">
Name: <input type="text" name="eventName"></input><br>
Description: <input type="text" name="description"></input><br>
Month#: <input type="number" name="month" step="1" min="0" max="12" /><br>
Day: <input type="number" name="day" step="1" min="0" max="31" /><br>
Hour: <input type="number" name="hour" step="1" min="0" max="23" /><br>
Minute: <input type="number" name="minute" step="1" min="0" max="60" />
<?php 
session_start();
echo '<input type="hidden" name="token" value="'.$_SESSION["token"].'" />';

?>
</form>
<button id="post" >Submit</button><br>
------------------
</div>
 
<script>
$("#post").click(function(){
	$.post( "addEvent.php", $( "#addForm" ).serialize() );
	$( "#button" ).click();
});
$( "select" ).change(function() {
  //m=$( "select option:selected" ).val();
  $( "#button" ).click();
});
$( document ).ready(function() {
	<?php 
	echo "tok='".$_SESSION["token"]."';";
	?>
	$( "#button" ).click();//performs refresh function
	$('.bigDay').height($('table').height()-8);
});
$( ".day" ).click(
  function() {
  	var oldHTML = $(this).html();
	var newHTML = oldHTML.replace(/event/g, "bigEvent");
	
	//alert(newHTML);
  	$('.bigDay').html(newHTML);
  });

$(document).on("click", "#delete", function(){
	
	 eventId=$(this).val();
	//	alert(eventId);
	//$.post( "delete.php",{id: eventId},function(data ){
	$.when( $.post( "delete.php",{id: eventId,token:tok} ) ).then(function( data) {
	$( "#button" ).click();
	//alert(data);
	}) ;
});
$( "#button" ).click(function() {
	$('.bigDay').html(" ");
	m=$( "select option:selected" ).val();
	$.when( $.post( "getEvent.php",{month: m} ) ).then(function( data, textStatus, jqXHR ) {//needs to wait for data
  		//alert( data ); 
  		jsonData=JSON.parse(data);
  		$( ".day" ).each(function( dIndex ) {
		dIndex=dIndex+1;
		$thisDiv=$(this);
		$.each(jsonData, function (jIndex, value) {
        modJIndex=jIndex.slice( 1 );//from _1 to 1
        if (modJIndex==dIndex){
        $thisDiv.html(dIndex+" "+value.weekday+"<br>");
       // alert(value[2]);//value[2] is weekday... javascript is dumb
       		color="a";
       		$.each(value, function (vIndex, vValue) {
       		if (vValue!=undefined&&vIndex!="weekday"){
       		
       			 $thisDiv.html( $thisDiv.html()+"<div id='"+color+"' class='event' >"+vValue.Time+" "+vValue.Title+"<br>"+vValue.description+"<button id='delete' value='"+vValue.id+"'>delete</button></div>");
       			
       			if(color=="a"){
       			color="b";
       			}
       			else{
       			color="a";
       			}
       
       		}
       		});
        }
   		 });

	});
	});


});
/*$( "#button" ).click(function() {
	var m= "november";
	$.post("test.php", {month: m},function(data) {
		fullData=data;
		jsonData=JSON.parse(fullData);
  		//alert(data);
  		//$( this ).text( htmlString );
		//$(this).html(data);
				});
	 //alert(jsonData._1.weekday);
	$( "div" ).each(function( dIndex ) {
		//alert(jsonData._1.weekday);
		dIndex=dIndex+1;
		$thisDiv=$(this);
		$.each(jsonData, function (jIndex, value) {
        //$(this).html(value.weekday);
        modJIndex=jIndex.slice( 1 );//from _1 to 1
        if (modJIndex==dIndex){
        $thisDiv.html(dIndex+" "+value.weekday);
        }
   		 });
		//alert(index);
 		// var d = $(this).html(jsonData);
 		 
 		 //alert(d);

	});
  

});*/
</script>
 
</body>
</html>