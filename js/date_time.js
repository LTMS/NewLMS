$(document).ready(function() {
//	Create two variable with the names of the months and days in an array
	var monthNames = [ "Jan", "Feb", "Mar", "Apr", "May", "June", "July", "Aug", "Sep", "Oct", "Nov", "Dec" ]; 
	var dayNames= ["Sun","Mon","Tues","Wed","Thu","Fri","Sat"];

//	Create a newDate() object
	var newDate = new Date();
//	Extract the current date from Date object
	newDate.setDate(newDate.getDate());
//	Output the day, date, month and year   
	var year=newDate.getFullYear();
	var twoyear=year.toString().substring(0);
	$('#Date').html("<center>" + newDate.getDate()+" - "+ monthNames[newDate.getMonth()] + ', ' +twoyear+" ("+dayNames[newDate.getDay()] +")"+"</center>");

	setInterval( function() {
		// Create a newDate() object and extract the seconds of the current time on the visitor's
		var seconds = new Date().getSeconds();
		var hours = new Date().getHours();
		var ampm = hours >= 12 ? 'PM' : 'AM';
		// Add a leading zero to seconds value
		$("#sec").html(( seconds < 10 ? "0" : "" ) + seconds+' '+ampm);
	},1000);

	setInterval( function() {
		// Create a newDate() object and extract the minutes of the current time on the visitor's
		var minutes = new Date().getMinutes();
		// Add a leading zero to the minutes value
		$("#min").html(( minutes < 10 ? "0" : "" ) + minutes);
	},1000);

	setInterval( function() {
		// Create a newDate() object and extract the hours of the current time on the visitor's
		var hours = new Date().getHours();
		
		var ampm = hours >= 12 ? 'PM' : 'AM';
		hours = hours % 12;
	    hours = hours ? hours : 12;
		// Add a leading zero to the hours value
		$("#hours").html(( hours < 10 ? "0" : "" ) + hours);
	}, 1000);
	intvlid=window.setInterval( "updateTime()", 60000 ); 
});
function updateTime() {
	mins=0;
	mins++;
	if(mins==3){
		mins=0;
		window.clearInterval(intvlid);
		delayer();
	}   
}
