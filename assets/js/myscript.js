(function($){
	$(window).on("load",function(){	
		$(".cus-scrollBar").mCustomScrollbar({
			setHeight:300,
			theme:"3d-dark"
		});	
	});
})(jQuery);

$(function() {
	$( ".datepicker" ).datepicker({
		changeMonth: true,
		changeYear: true
	});
});

$(function() {
	$( ".datepicker1" ).datepicker({
		changeMonth: true,
		changeYear: true
	});
});

$(function() {
	$( ".datepicker2" ).datepicker({
		changeMonth: true,
		changeYear: true
	});
});

$(function() {
	$( ".datepicker3" ).datepicker({
		changeMonth: true,
		changeYear: true
	});
});

// var current_fs, next_fs, previous_fs;
// var left, opacity, scale;
// var animating;
// var new_inc = 1;
// $(".next").click(function(e) {
// 	// alert(new_inc);
// 	var c_type = $("#consultant_type").val();
// 	var consult = $("#consultant_list").val();
// 	var vend = $("#vendor_id").val();
// 	var pro_name = $("#project_name").val();
// 	var srt_date = $("#datepicker").val();
// 	var end_date = $("#datepicker1").val();
// 	var emp_role = $("#consultant_role").val();
// 	var pro_locn = $("#pro_location").val();
// 	var pro_city = $("#pro_city").val();
// 	var pro_stat = $("#pro_state").val();
// 	var rec_name = $("#recruiter_name").val();
// 	var man_name = $("#manager_name").val();
// 	var c_type_2 = $("#consul_type2").val();
// 	var cost_prc = $("#cost_price").val();
// 	var sale_prc = $("#sale_price").val();
// 	var eff_date = $("#datepicker2").val();
// 	if(new_inc == 1) {
// 		if(c_type != '' && consult != '') {
// 			new_inc++;
// 			if(animating) return false;
// 			animating = true;
// 			current_fs = $(this).parent();
// 			next_fs = $(this).parent().next();
// 			$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
// 			next_fs.show();
// 			current_fs.animate({opacity: 0}, {
// 				step: function(now, mx) {
// 					scale = 1 - (1 - now) * 0.2;
// 					left  = (now * 50)+"%";
// 					opacity = 1 - now;
// 					current_fs.css({
// 						'transform': 'scale('+scale+')'//,
// 						//'position': 'absolute'
// 					});
// 					next_fs.css({'left': left, 'opacity': opacity});
// 				}, 
// 				duration: 800, 
// 				complete: function() {
// 					current_fs.hide();
// 					animating = false;
// 				}, 
// 				easing: 'easeInOutBack'
// 			});
// 		} else if(c_type == "") {
// 			$("#consul_tpye_error").show();
// 		} else if(consult == "") {
// 			$("#consul_error").show();
// 		}
// 	} else if(new_inc == 2) {
// 		if(vend != '') {
// 			new_inc++;
// 			if(animating) return false;
// 			animating = true;
// 			current_fs = $(this).parent();
// 			next_fs = $(this).parent().next();
// 			$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
// 			next_fs.show();
// 			current_fs.animate({opacity: 0}, {
// 				step: function(now, mx) {
// 					scale = 1 - (1 - now) * 0.2;
// 					left = (now * 50)+"%";
// 					opacity = 1 - now;
// 					current_fs.css({
// 						'transform': 'scale('+scale+')'//,
// 						//'position': 'absolute'
// 					});
// 					next_fs.css({'left': left, 'opacity': opacity});
// 				}, 
// 				duration: 800, 
// 				complete: function() {
// 					current_fs.hide();
// 					animating = false;
// 				}, 
// 				easing: 'easeInOutBack'
// 			});
// 		} else {
// 			$("#vendor_error").show();
// 		}
// 	} else if(new_inc == 3) {
// 		if(pro_name != '' && srt_date != '' && end_date != '' && emp_role != '' && pro_locn != '' && pro_city != '' && pro_stat != '' && rec_name != '' && man_name != '' ) {
// 			new_inc++;
// 			if(animating) return false;
// 			animating = true;
// 			current_fs = $(this).parent();
// 			next_fs = $(this).parent().next();
// 			$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
// 			next_fs.show();
// 			current_fs.animate({opacity: 0}, {
// 				step: function(now, mx) {
// 					scale = 1 - (1 - now) * 0.2;
// 					left = (now * 50)+"%";
// 					opacity = 1 - now;
// 					current_fs.css({
// 						'transform': 'scale('+scale+')'//,
// 						//'position': 'absolute'
// 					});
// 					next_fs.css({'left': left, 'opacity': opacity});
// 				}, 
// 				duration: 800, 
// 				complete: function() {
// 					current_fs.hide();
// 					animating = false;
// 				}, 
// 				easing: 'easeInOutBack'
// 			});
// 		} else if(pro_name == "") {
// 			$("#pro_name_error").show();
// 		} else if(srt_date == "") {
// 			$("#start_date_error").show();
// 		}  else if(end_date == "") {
// 			$("#end_date_error").show();
// 		} else if(emp_role == "") {
// 			$("#role_error").show();
// 		} else if(pro_locn == "") {
// 			$("#pro_loc_error").show();
// 		} else if(pro_city == "") {
// 			$("#pro_city_error").show();
// 		} else if(pro_stat == "") {
// 			$("#pro_state_error").show();
// 		} else if(rec_name == "") {
// 			$("#recuiter_name_error").show();
// 		} else if(man_name == "") {
// 			$("#man_name_error").show();
// 		}
// 	}
// 	else if(new_inc == 4) {
// 		if(cost_prc != "" && sale_prc != "" && eff_date != "") {
// 			new_inc++;
// 			if(animating) return false;
// 			animating = true;
// 			current_fs = $(this).parent();
// 			next_fs = $(this).parent().next();
// 			$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
// 			next_fs.show();
// 			current_fs.animate({opacity: 0}, {
// 				step: function(now, mx) {
// 					scale = 1 - (1 - now) * 0.2;
// 					left = (now * 50)+"%";
// 					opacity = 1 - now;
// 					current_fs.css({
// 						'transform': 'scale('+scale+')'//,
// 						//'position': 'absolute'
// 					});
// 					next_fs.css({'left': left, 'opacity': opacity});
// 				}, 
// 				duration: 800, 
// 				complete: function() {
// 					current_fs.hide();
// 					animating = false;
// 				}, 
// 				easing: 'easeInOutBack'
// 			});
// 		} else if(cost_prc == "") {
// 			$("#bill_rate_error").show();
// 		} else if(sale_prc == "") {
// 			$("#pay_rate_error").show();
// 		} else if(eff_date == "") {
// 			$("#effective_date_error").show();
// 		}
// 	}
// });
// $(".previous").click(function() {
// 	new_inc--;
// 	if(animating) return false;
// 	animating = true;	
// 	current_fs = $(this).parent();
// 	previous_fs = $(this).parent().prev();
// 	$("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");	
// 	previous_fs.show(); 
// 	current_fs.animate({opacity: 0}, {
// 		step: function(now, mx) {
// 			scale = 0.8 + (1 - now) * 0.2;
// 			left = ((1-now) * 50)+"%";
// 			opacity = 1 - now;
// 			current_fs.css({'left': left});
// 			previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
// 		}, 
// 		duration: 800, 
// 		complete: function(){
// 			current_fs.hide();
// 			animating = false;
// 		}, 
// 		easing: 'easeInOutBack'
// 	});
// });
// $(".submit").click(function() {
// 	return false;
// });

jQuery(window).ready(function() {
	jQuery("#consul_info").hide();
	jQuery("#vend_info").hide();
});


$(document).ready(function(){
	$(".navbar-nav.mr-auto li").click(function(){
		$("li").removeClass("active");
		$(this).addClass("active");
	});
});

// $("input[name='phone']").keyup(function() {
// 	//alert();
// 	$("input[name='phone']").val(function(i, val) {
// 		return val.replace(/(\d\d\d)(\d\d\d)(\d\d\d\d)/, '($1) $2-$3');
// 	});
// });

$("input[type='phone']").on("keyup paste", function(event) {
//alert();
    if(event.which != 12){
        // Remove invalid chars from the input
        var input = this.value.replace(/[^0-9\(\)\s\-]/g, "");
        var inputlen = input.length;
        // Get just the numbers in the input
        var numbers = this.value.replace(/\D/g,'');
        var numberslen = numbers.length;
        // Value to store the masked input
        var newval = "";

        // Loop through the existing numbers and apply the mask
        for(var i=0;i<numberslen;i++){
            if(i==0) newval=numbers[i];
            else if(i==2) newval+=numbers[i]+"-";
            else if(i==6) newval+="-"+numbers[i];
            else newval+=numbers[i];
        }

        // Re-add the non-digit characters to the end of the input that the user entered and that match the mask.
        // if(inputlen>=1&&numberslen==0&&input[0]=="(") newval="(";
        // else if(inputlen>=6&&numberslen==3&&input[4]==")"&&input[5]==" ") newval+=") ";
        // else if(inputlen>=5&&numberslen==3&&input[4]==")") newval+=" ";
        // else if(inputlen>=6&&numberslen==3&&input[5]==" ") newval+=" ";
        // else if(inputlen>=10&&numberslen==6&&input[9]=="-") newval+="-";

        $(this).val(newval.substring(0,12));

    } else {
    	alert("Please enter valid phone number");
    }
});
// 
$(document).ready(function(){
	$(".document-listBox li").click(function(){
		$(".document-listBox li").removeClass("active");
		$(this).addClass("active");
	});

	$(".navbar-nav li a").click(function(){
		$(".navbar-nav li a").removeClass("active");
		$(this).addClass("active");
	});
});
