<section  class="subscribe">

    <div class="subscribe-title text-center">
        <h2>Join our Subscribers List to Get Regular Update</h2>
        <p>Subscribe Now. We will send you Best offer for your Trip</p>
    </div>
    <form action="javascript:void(0);" class="" type="post">
        @csrf
        <div class="row">
            <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                <div id="btnSubmit" class="custom-input-group">
                    <input onfocus="enableSubscriber();" onfocusout="checkSubscriber();" type="email" name="newsletter_email" id="newsletter_email" class="form-control" placeholder="Enter Email">
                    <button  onclick="checkSubscriber(); addSubscriber();" type="submit" class="appsLand-btn subscribe-btn">Subscribe</button>
                    <div class="clearfix"></div>
                    <i class="fa fa-envelope"></i>
                </div>
                <div onclick="checkSubscriber();"  id="statusSubscriber" style="display: none; font-weight:1600; font-size:30px; background-color: #f2eee4; opacity:0.5; border:0;"></div>
            </div>
        </div>
    </form>
</section>

<script>
    function checkSubscriber(){
        var newsletter_email = $("#newsletter_email").val();
        $.ajax({
            type:'post',
            url:'/check-subscriber-email',
            data:{newsletter_email:newsletter_email},
            success:function(resp){
               if(resp =="exists"){
                   //alert("Subscriber email exists");
                   $("#statusSubscriber").show();
                   $("#btnSubmit").hide();
                   $("#statusSubscriber").html("<div style='margin-top:10px; margin-right:50px;'>&nbsp;</div><font color='red'>Subscriber email already exists</font>");
               }
            },error:function(){
                alert("Error");
            }
        });
    }

    function addSubscriber(){
        var newsletter_email = $("#newsletter_email").val();
        $.ajax({
            type:'post',
            url:'/add-subscriber-email',
            data:{newsletter_email:newsletter_email},
            success:function(resp){
               if(resp =="exists"){
                   //alert("Subscriber email exists");
                   $("#statusSubscriber").show();
                   $("#btnSubmit").hide();
                   $("#statusSubscriber").html("<div >&nbsp;</div><font color='red'>Subscriber email already exists</font>");
               }else if(resp=="saved"){
                $("#statusSubscriber").show();
                $("#statusSubscriber").html("<div >&nbsp;</div><font color='green'>Thanks for Subscribing!</font>");
               }
            },error:function(){
                alert("Error");
            }
        });
    }

    function enableSubscriber(){
        $("#btnSubmit").show();
        $("#statusSubscriber").hide();
    }
</script>
