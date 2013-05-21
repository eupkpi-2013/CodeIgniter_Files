
$(document).ready(function(){
	$(".active").parent().show();
	$(".accordion h3").click(function(){
		$(this).parent().find($(".accordion-list")).slideToggle("slow");
	});
	// $(".addrowbutton").click(function(){
		// $(".kpitable").append('<tr><td><input></input></td><td><select><option>Text</option>option>Integer</option><option>Boolean</option><option>Time Range</option></select></td></tr>');
	// });
	
	$("#signup-button").click(function(){
		$("#signup").slideToggle();
	});
	
	//for popup divs
	$(function() {

	var popup = false;
	
	$("#submitKPI-button").click(function(){
		if(popup == false){
			$("#overlayEffect").fadeIn();
			$(".popup").fadeIn();
			popup = true;
		}
		});
	
	$("#verifybutton").click(function(){
		if(popup == false){
			$("#overlayEffect").fadeIn();
			$(".popup").fadeIn();
			$("#close").fadeIn();
			center();
			popup = true;
		}
		});

	$(".closepopup").click(function(){
		hidePopup();
	});
	
	$(".close").click(function(){
		hidePopup();
	});

	function hidePopup(){
		if(popup==true){
			$("#overlayEffect").fadeOut();
			$(".popup").fadeOut();
			popup = false;
		}
	}

	} ,jQuery);
});