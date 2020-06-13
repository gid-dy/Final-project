jQuery(document).ready(function($) {

    // Accordion Toggle
    var iconOpen = 'icon-minus',
        iconClose = 'icon-plus';

    $(document).on('show.bs.collapse hide.bs.collapse', '.accordion', function(e) {
        var $target = $(e.target)
        $target.siblings('.accordion-heading')
            .find('em').toggleClass(iconOpen + ' ' + iconClose);
        if (e.type == 'show')
            $target.prev('.accordion-heading').find('.accordion-toggle').addClass('active');
        if (e.type == 'hide')
            $(this).find('.accordion-toggle').not($target).removeClass('active');
    });


    // setting
    $(function() {
        var $tabButtonItem = $('#tab-button li'),
            $tabSelect = $('#tab-select'),
            $tabContents = $('.tab-contents'),
            activeClass = 'is-active';

        $tabButtonItem.first().addClass(activeClass);
        $tabContents.not(':first').hide();

        $tabButtonItem.find('a').on('click', function(e) {
            var target = $(this).attr('href');

            $tabButtonItem.removeClass(activeClass);
            $(this).parent().addClass(activeClass);
            $tabSelect.val(target);
            $tabContents.hide();
            $(target).show();
            e.preventDefault();
        });


        $tabSelect.on('change', function() {
            var target = $(this).val(),
                targetSelectNum = $(this).prop('selectedIndex');

            $tabButtonItem.removeClass(activeClass);
            $tabButtonItem.eq(targetSelectNum).addClass(activeClass);
            $tabContents.hide();
            $(target).show();

        });
    });


    //setting
    $(document).ready(function() {
        $(".btn-pref .btn").click(function() {
            $(".btn-pref .btn").removeClass("btn-primary").addClass("btn-default");
            // $(".tab").addClass("active"); // instead of this do the below
            $(this).removeClass("btn-default").addClass("btn-primary");
        });
    });

    //password show

    $(document).ready(function() {
        $('.pass_show').append('<span class="ptxt">Show</span>');
    });


    $(document).on('click', '.pass_show .ptxt', function() {

        $(this).text($(this).text() == "Show" ? "Hide" : "Show");

        $(this).prev().attr('type', function(index, attr) { return attr == 'password' ? 'text' : 'password'; });

    });

    // DM Top
    $(window).scroll(function() {
        if ($(this).scrollTop() > 1) {
            $('.dmtop').css({
                bottom: "25px"
            });
        } else {
            $('.dmtop').css({
                bottom: "-100px"
            });
        }
    });

    $('.dmtop').click(function() {
        $('html, body').animate({
            scrollTop: '0px'
        }, 800);
        return false;
    });

    // DM Menu
    // $('#nav').affix({
    //     offset: {
    //         top: $('#nav').offset().top
    //     }
    // });

    // Menu
    $(".panel a").click(function(e) {
        e.preventDefault();
        var style = $(this).attr("class");
        $(".jetmenu").removeAttr("class").addClass("jetmenu").addClass(style);
    });
    $().jetmenu();

    // Facts
    function count($this) {
        var current = parseInt($this.html(), 10);
        current = current + 1; /* Where 50 is increment */

        $this.html(++current);
        if (current > $this.data('count')) {
            $this.html($this.data('count'));
        } else {
            setTimeout(function() {
                count($this)
            }, 50);
        }
    }

    $(".stat-count").each(function() {
        $(this).data('count', parseInt($(this).html(), 10));
        $(this).html('0');
        count($(this));
    });

    // Tooltip
    $('.social_buttons, .client').tooltip({
        selector: "a[data-toggle=tooltip]"
    })

    $('.social_buttons, .client').tooltip();

    // prettyPhoto
    $(document).ready(function() {
        $('a[data-gal]').each(function() {
            $(this).attr('rel', $(this).data('gal'));
        });
        $("a[data-rel^='prettyPhoto']").prettyPhoto({
            animationSpeed: 'slow',
            theme: 'light_square',
            slideshow: false,
            overlay_gallery: false,
            social_tools: false,
            deeplinking: false
        });
    });


    $().ready(function() {
        $('[rel="tooltip"]').tooltip();

        $('a.scroll-down').click(function(e) {
            e.preventDefault();
            scroll_target = $(this).data('href');
            $('html, body').animate({
                scrollTop: $(scroll_target).offset().top - 60
            }, 1000);
        });

    });

    function rotateCard(btn) {
        var $card = $(btn).closest('.card-container');
        console.log($card);
        if ($card.hasClass('hover')) {
            $card.removeClass('hover');
        } else {
            $card.addClass('hover');
        }
    }





    // $(function() {
    //     $(".date").datepicker({
    //         autoclose: true,
    //         todayHighlight: true
    //     });
    // });

    /*--- showlogin toggle function ----*/

    $('#showlogin').on('click', function() {
        $('#checkout-login').slideToggle(900);
    });

    /*--- showlogin toggle function ----*/
    $('#showcoupon').on('click', function() {
        $('#checkout_coupon').slideToggle(900);
    });

    /*--- showlogin toggle function ----*/
    $('#ship-box').on('click', function() {
        $('#ship-box-info').slideToggle(1000);
    });






    // Hover and Carousel
    $('.owl-carousel > .item ').each(function() {
        $(this).hoverdir();
    });
    $("#owl-demo").owlCarousel({
        items: 5,
        autoPlay: 3000, //Set AutoPlay to 3 seconds
        stopOnHover: true,
        lazyLoad: true,
        transitionStyle: "fade",
        navigation: true,
        pagination: false,
    });

    // tooltip demo
    $("[data-toggle=tooltip]").tooltip();

    // popover demo
    $("[data-toggle=popover]").popover();

    // Chart Effects;
    $('.chart').easyPieChart({
        easing: 'easeOutBounce',
        size: 180,
        animate: 2000,
        lineWidth: 10,
        lineCap: 'square',
        lineWidth: 18,
        barColor: '#3498db',
        trackColor: '#f9f9f9',
        scaleColor: false,
        onStep: function(from, to, percent) {
            $(this.el).find('.percent').text(Math.round(percent) + '%');
        }
    });

    // if HTML DOM Element that contains the map is found...
    // if (document.getElementById('map-canvas')) {

    //     // Coordinates to center the map
    //     var myLatlng = new google.maps.LatLng(28.632681, 77.208162);

    //     // Other options for the map, pretty much selfexplanatory
    //     var mapOptions = {
    //         zoom: 14,
    //         center: myLatlng,
    //         mapTypeId: google.maps.MapTypeId.ROADMAP
    //     };

    //     // Attach a map to the DOM Element, with the defined settings
    //     var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);

    // }




    // i. #testimonial-carousel


    var owl = $('#testemonial-carousel');
    owl.owlCarousel({
        items: 3,
        margin: 0,

        loop: true,
        autoplay: true,
        smartSpeed: 1000,

        //nav:false,
        //navText:["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],

        dots: true,
        autoplayHoverPause: true,

        responsiveClass: true,
        responsive: {
            0: {
                items: 1
            },
            640: {
                items: 1
            },
            767: {
                items: 2
            },
            992: {
                items: 3
            }
        }


    });



    // Popular Items Carousel
    $(document).ready(function() {
        $("#popularitems").owlCarousel({
            items: 3,
            lazyLoad: true,
            navigation: false
        });
    });

    // Hover and Carousel on Home #1
    $('.owl-carousel > .item ').each(function() {
        $(this).hoverdir();
    });

    $("#owl-related").owlCarousel({
        items: 3,
        autoPlay: 3000, //Set AutoPlay to 3 seconds
        stopOnHover: true,
        lazyLoad: true,
        transitionStyle: "fade",
        navigation: true,
        pagination: false,
    });
    $('#myTab a[href="#profile"]').tab('show')

    /*-------------------------
      product thumb img slider
    --------------------------*/
    $('.pro-thumb-img-slider').owlCarousel({
        loop: true,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        items: 5,
        dots: false,
        margin: 25,
        nav: true,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        responsive: {
            0: {
                items: 3
            },
            600: {
                items: 3
            },
            1000: {
                items: 5
            }
        }
    });




    // Portfolio
    var $container = $('.portfolio'),
        $items = $container.find('.market-item'),
        portfolioLayout = 'fitRows';

    if ($container.hasClass('portfolio-centered')) {
        portfolioLayout = 'masonry';
    }

    $container.isotope({
        filter: '*',
        animationEngine: 'best-available',
        layoutMode: portfolioLayout,
        animationOptions: {
            duration: 750,
            easing: 'linear',
            queue: false
        },
        masonry: {}
    }, refreshWaypoints());

    function refreshWaypoints() {
        setTimeout(function() {}, 1000);
    }

    $('nav.portfolio-filter ul a').on('click', function() {
        var selector = $(this).attr('data-filter');
        $container.isotope({
            filter: selector
        }, refreshWaypoints());
        $('nav.portfolio-filter ul a').removeClass('active');
        $(this).addClass('active');
        return false;
    });

    function getColumnNumber() {
        var winWidth = $(window).width(),
            columnNumber = 2;
    }

    function setColumns() {
        var winWidth = $(window).width(),
            columnNumber = getColumnNumber(),
            itemWidth = Math.floor(winWidth / columnNumber);

        $container.find('.market-item').each(function() {
            $(this).css({
                width: itemWidth + 'px'
            });
        });
    }

    function setPortfolio() {
        setColumns();
        $container.isotope('reLayout');
    }

    $container.imagesLoaded(function() {
        setPortfolio();
    });

    $(window).on('resize', function() {
        setPortfolio();
    });

    //tour price
    $(document).ready(function(){

        $("#SelType").change(function(){
            var idTourTypeName = $(this).val();
            if(idTourTypeName == ""){
                return false;
            }
            let ck = $(this).val().split('-');
            //console.log(ck)
            if(ck[1] === "Organisation"){
                $('#nt').attr({"min":10,  "max":30});
            }else if(ck[1] === "Family"){
                $('#nt').attr({"min":3,  "max":8});
            }else if(ck[1] === "Individual"){
                $('#nt').attr({"min":1,  "max":1});
            }else if(ck[1] === "Couple"){
                $('#nt').attr({"min":2,  "max":2});
            }
            $.ajax({
                type:'get',
                url:'/get-tourpackage-Price',
                data:{idTourTypeName:idTourTypeName},
                success:function(resp){
                    //alert(resp); return false;
                    var arr = resp.split('#');
                    var arr1 =arr[0].split('-');
                    $("#getPackagePrice").html("GHS " +arr1[0]+"<br><h4>USD "+arr1[1]+"<br>GBP "+arr1[2]+"<br>EUR "+arr1[3]+"</h4>");
                    $("#PackagePrice").val(arr[0]);
                    if(arr[1]==0){
                        $("#cartbutton").hide();
                        $("#Availability").text("Sold Out");
                    }else{
                        $("#cartbutton").show();
                        $("#Availability").text("Available for booking");
                    }
                    $("#PackagePrice").val(arr[0]);
                },error:function(){
                    alert("Error");
                }
            });
        });
    });

    //transport price
    $(document).ready(function(){

        $("#SelTran").change(function(){
            var idTransportName = $(this).val();
            if(idTransportName == " "){
                return false;
            }
            $.ajax({
                type:'get',
                url:'/get-transport-Cost',
                data:{idTransportName:idTransportName},
                success:function(resp){
                    console.log(resp);
                    var el = $("#getTransportCost")
                    el.removeAttr('hidden')
                    el.html("GHS " +resp);

                },error:function(){
                    alert("Error");
                }
            });
        });
    });

     $(".changeImage").click(function(){
        var Image = $(this).attr('src');
        $(".mainImage").attr("src",Image);
    });

});

$().ready(function(){
    //validate register form on keypress
    $("#registerform").validate({
        rules:{
            SurName:{
                required:true,
                minlength:2,
                accept: "[a-zA-Z]+"
            },
            OtherNames:{
                required:true,
                minlength:2,
                accept: "[a-zA-Z]+"
            },
            UserEmail:{
                required:true,
                email:true,
                remote:"/check-email"
            },
            Mobile:{
                required:true,
                minlength:10,
                accept: "[0-9]+"
            },
            password:{
                required:true,
                minlength:8
            }
        },
        messages:{
            SurName:{
                required:"Please enter your Sur Name",
                minlength: "Your SurName must be at least 2 characters long",
                accept:"Your name must contain letters only"
            },
            OtherNames: {
                required:"Please enter Other names",
                minlength: "Other names must be at least 2 characters long",
                accept:"Your name must contain letters only"
            },
            UserEmail:{
                required: "Please enter your email",
                email: "Please enter a valid Email",
                remote:"Email already exist"
            },
            Mobile:{
                required: "Please enter your contact",
                Mobile: "Your contact should be at leat 10 digits",
                accept:"Your contact must contain numbers only"
            },
            password:{
                required: "Please provide your Password",
                minlength: "Your Password should be at least 8 characters long"
            }
        }
    });

    $("#current_pwd").keyup(function(){
		var current_pwd = $(this).val();
		$.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
			type:'post',
			url:'/check-user-pwd',
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
    $("#passwordform").validate({
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

    //Password strength Script
    $('#myPassword').passtrength({
        minChars: 8,
        passwordToggle: true,
        tooltip: true,
        eyeImg :"images/frontend_images/eye.svg"
    });

    $("#ship-box").click(function(){
        if(this.checked){
            $("#travelling_SurName").val($("#billing_SurName").val());
            $("#travelling_OtherNames").val($("#billing_OtherNames").val());
            $("#travelling_Mobile").val($("#billing_Mobile").val());
            $("#travelling_OtherContact").val($("#billing_OtherContact").val());
            $("#travelling_Country").val($("#billing_Country").val());
            $("#travelling_Address").val($("#billing_Address").val());
            $("#travelling_City").val($("#billing_City").val());
            $("#travelling_State").val($("#billing_State").val());
            $("#travelling_ZipCode").val($("#billing_ZipCode").val());
        }else{
            $("#travelling_SurName").val('');
            $("#travelling_OtherNames").val('');
            $("#travelling_Mobile").val('');
            $("#travelling_OtherContact").val('');
            $("#travelling_Country").val('');
            $("#travelling_Address").val('');
            $("#travelling_City").val('');
            $("#travelling_State").val('');
            $("#travelling_ZipCode").val('');
        }
    });

});

function selectPaymentMethod(){
    if($('#flutterwave').is(':checked') || $('#ipay').is(':checked') || $('#COD').is(':checked')){
        //  alert("checked");
    }else{
        alert("Please select Payment Method");
        return false;
    }

}


// // Instantiate EasyZoom instances
// 		var $easyzoom = $('.easyzoom').easyZoom();

// 		// Setup thumbnails example
// 		var api1 = $easyzoom.filter('.easyzoom--with-thumbnails').data('easyZoom');

// 		$('.thumbnails').on('click', 'a', function(e) {
// 			var $this = $(this);

// 			e.preventDefault();

// 			// Use EasyZoom's `swap` method
// 			api1.swap($this.data('standard'), $this.attr('href'));
// 		});

// 		// Setup toggles example
// 		var api2 = $easyzoom.filter('.easyzoom--with-toggle').data('easyZoom');

// 		$('.toggle').on('click', function() {
// 			var $this = $(this);

// 			if ($this.data("active") === true) {
// 				$this.text("Switch on").data("active", false);
// 				api2.teardown();
// 			} else {
// 				$this.text("Switch off").data("active", true);
// 				api2._init();
// 			}
// 		});


