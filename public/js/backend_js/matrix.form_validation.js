
$(document).ready(function(){
    $("#access").hide();
    $("#Type").change(function(){
        var Type = $("#Type").val();
        if(Type == "Admin"){
            $("#access").hide();
        }else{
            $("#access").show();
        }
    })
	$("#new_pwd").click(function(){
		var current_pwd = $("#current_pwd").val();
		$.ajax({
			type:'get',
			url:'/admin/check-pwd',
			data:{current_pwd:current_pwd},
			success:function(resp){
				//alert(resp);
				if(resp=="false"){
					$("#chkPwd").html("<font color='red'>Current Password is Incorrect</font>");
				}else if(resp=="true"){
					$("#chkPwd").html("<font color='green'>Current Password is Correct</font>");
				}
			},error:function(){
				alert("Error");
			}
		});
	});

	$('input[type=checkbox],input[type=radio],input[type=file]').uniform();

	$('select').select2();

	$("#basic_validate").validate({
		rules:{
			required:{
				required:true
			},
			email:{
				required:true,
				email: true
			},
			date:{
				required:true,
				date: true
			},
			url:{
				required:true,
				url: true
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});

	// Add Category validation
    $("#add_category").validate({
		rules:{
			CategoryName:{
				required:true,
			},
			CategoryDescription:{
				required:true,
			},
			Imageaddress:{
				required:true,
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});

	// Edit Category validation
    // $("#edit_category").validate({
	// 	rules:{
	// 		category_name_edit:{
	// 			required:true
	// 		},
	// 		description_edit:{
	// 			required:true,
	// 		},
	// 		url_edit:{
	// 			required:true,
	// 		}
	// 	},
	// 	errorClass: "help-inline",
	// 	errorElement: "span",
	// 	highlight:function(element, errorClass, validClass) {
	// 		$(element).parents('.control-group').addClass('error');
	// 	},
	// 	unhighlight: function(element, errorClass, validClass) {
	// 		$(element).parents('.control-group').removeClass('error');
	// 		$(element).parents('.control-group').addClass('success');
	// 	}
	// });



	//Add tourPackage
	$("#add_tour").validate({
		rules:{
			category_id:{
				required:true,
			},
			tour_name:{
				required:true,
			},
			hotel_name:{
				required:true,
			},
			tour_code:{
				required:true,
			},
			price:{
				required:true,
				number:true
			},
			bus_price:{
				required:true,
				number:true
			},
			van_price:{
				required:true,
				number:true
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});

	//Edit tourPackage
	$("#edit_tour").validate({
		rules:{
			category_id:{
				required:true,
			},
			tour_name:{
				required:true,
			},
			hotel_name:{
				required:true,
			},
			tour_code:{
				required:true,
			},
			price:{
				required:true,
				number:true
			},
			bus_price:{
				required:true,
				number:true
			},
			van_price:{
				required:true,
				number:true
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});

	$("#number_validate").validate({
		rules:{
			min:{
				required: true,
				min:10
			},
			max:{
				required:true,
				max:24
			},
			number:{
				required:true,
				number:true
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});

	$("#password_validate").validate({
		rules:{
			current_pwd:{
				required: true,
				minlength:6,
				maxlength:20
			},
			new_pwd:{
				required: true,
				minlength:6,
				maxlength:20
			},
			confirm_pwd:{
				required:true,
				minlength:6,
				maxlength:20,
				equalTo:"#new_pwd"
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});

	$("#delCat").click(function(){
		if(confirm('Are you sure you want to delete this category?')){
			return true;
		}
        return false;

	});

	// $("#delTour").click(function(){
	// 	if(confirm('Are you sure you want to delete this tourPackage?')){
	// 		return true;
	// 	}
    //     return false;

	// });

	$(".deleteRecord").click(function(){
		var id = $(this).attr('rel');
		var deleteFunction = $(this).attr('rel1');
		swal({
			title: 'Are you sure?',
			text: "You won't be able to revert this!",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, delete it!',
			cancelButtonText: 'No, cancel!',
			confirmButtonClass: 'btn btn-success',
    		cancelButtonClass: 'btn btn-danger',
			buttonsStyling: false,
			reverseButtons: true
		},
		function(){
			window.location.href="/admin/"+deleteFunction+"/"+id;
		});

	});

		$(document).ready(function(){
		var maxField = 10; //Input fields increment limitation
		var addButton = $('.add_button'); //Add button selector
		var wrapper = $('.field_wrapper'); //Input field wrapper
		var fieldHTML = '<div class="field_wrapper" style="margin-top:5px;" ><input type="text" name="SKU[]" id="SKU" placeholder="SKU" style="width:120px; margin-left:100px;" /><input type="text" name="TourTypeSize[]" id="TourTypeSize" placeholder="TourTypeSize" style="width:120px; margin-left:3px;" /><input type="text" name="TourTypeName[]" id="TourTypeName" placeholder="TourTypeName" style="width:120px; margin-left:3px;" /><input type="text" name="PackagePrice[]" id="PackagePrice" placeholder="PackagePrice" style="width:120px; margin-left:3px;" /><a href="javascript:void(0);" class="remove_button">Remove</a></div>'; //New input field html
		var x = 1; //Initial field counter is 1

		//Once add button is clicked
		$(addButton).click(function(){
			//Check maximum number of input fields
			if(x < maxField){
				x++; //Increment field counter
				$(wrapper).append(fieldHTML); //Add field html
			}
		});

		//Once remove button is clicked
		$(wrapper).on('click', '.remove_button', function(e){
			e.preventDefault();
			$(this).parent('div').remove(); //Remove field html
			x--; //Decrement field counter
		});
	});

//for transport
$(document).ready(function(){
		var maxField = 10; //Input fields increment limitation
		var addButton = $('.add_button_trans'); //Add button selector
		var wrapper = $('.field_wrapper_transport'); //Input field wrapper
		var fieldHTML = '<div class="field_wrapper" style="margin-top:5px;" ><input type="text" name="TransportName[]" id="TransportName" placeholder="TransportName" style="width:120px; margin-left:100px;" /><input type="text" name="TransportCost[]" id="TransportCost" placeholder="TransportCost" style="width:120px; margin-left:3px;" /><a href="javascript:void(0);" class="remove_button">Remove</a></div>'; //New input field html
		var x = 1; //Initial field counter is 1

		//Once add button is clicked
		$(addButton).click(function(){
			//Check maximum number of input fields
			if(x < maxField){
				x++; //Increment field counter
				$(wrapper).append(fieldHTML); //Add field html
			}
		});

		//Once remove button is clicked
		$(wrapper).on('click', '.remove_button', function(e){
			e.preventDefault();
			$(this).parent('div').remove(); //Remove field html
			x--; //Decrement field counter
		});
	});

//for Tour include
$(document).ready(function(){
		var maxField = 10; //Input fields increment limitation
		var addButton = $('.add_button_include'); //Add button selector
		var wrapper = $('.field_wrapper_include'); //Input field wrapper
		var fieldHTML = '<div class="field_wrapper" style="margin-top:5px;" ><input type="text" name="IncludeName[]" id="IncludeName" placeholder="IncludeName" style="width:120px; margin-left:100px;" /><input type="text" name="TourIncludeInfo[]" id="TourIncludeInfo" placeholder="TourIncludeInfo" style="width:120px; margin-left:3px;" /><input type="text" name="TourExcludeName[]" id="TourExcludeName" placeholder="TourExcludeName" style="width:120px; margin-left:3px;" /><a href="javascript:void(0);" class="remove_button">Remove</a></div>'; //New input field html
		var x = 1; //Initial field counter is 1

		//Once add button is clicked
		$(addButton).click(function(){
			//Check maximum number of input fields
			if(x < maxField){
				x++; //Increment field counter
				$(wrapper).append(fieldHTML); //Add field html
			}
		});

		//Once remove button is clicked
		$(wrapper).on('click', '.remove_button', function(e){
			e.preventDefault();
			$(this).parent('div').remove(); //Remove field html
			x--; //Decrement field counter
		});
	});



});
