$(function(){

	var $clock = $("body nav div ul li a#clock-system");

	setInterval(function(){

		var date = new Date();
		var txtHours = date.getDate() + "/" + (date.getMonth()+1) + "/" + date.getFullYear()
						+ " " + date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();
		$clock.html(txtHours);

	}, 1000);

});