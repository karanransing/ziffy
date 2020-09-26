<div class="container">
    <div class="login-content">
        <div class="login-logo">
       </div>
       <div class="login-form">
        <form method="post" id="login_form" name="login_form"  action="<?php echo base_url('validateotp');?>">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <input type="text" placeholder="Enter Mobile No." name="mobile" class="form-control form_element" id="mobile" value="<?php echo set_value('mobile');?>">
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <input type="password" placeholder="Enter Password." name="password" class="form-control form_element" id="password">
            </div>
          </div>

          <div class="col-md-12 text-center" id="show_sendotpbtn">
            <div class="form-group">
              <input type="button" name="proceed" value="Login" class="action_button form-control btn" style="color: white;background-color:#27e7bf;" onclick="validateLogin()">
            </div>
          </div>
        </div>
        </form>
      </div> 
    </div>
</div>
<script>
  $(document).ready(function() {
      
  });

  $("#login_form").validate({
        rules: 
        {
          mobile:
          {
            required:true,
            digits:true,
            maxlength:10,
            minlength:10
          },
          password:"required"
        },
        messages: 
        { 
          mobile:
          {
            required:"Enter a Mobile Number",
            digits:"Invalid Mobile Number",
            maxlength:"Invalid Mobile Number",
            minlength:"Invalid Mobile Number"
          },
          password:"Enter Password"
        }
    });
  function validateLogin()
  {
    var mobile = $('#mobile').val();
    var password = $('#password').val();

    if($('#login_form').valid())
    {
      var $action = "<?php echo site_url('/validatelogin'); ?>";
      $.ajax({
          url: $action,
          type: "post",
          data: {'mobile': mobile,'password':password},
          dataType: "json",
          success: function (result)
          {
            if(result.status)
            {
              toastr.success(result.msg);
              window.location.href=result.redirect;
            } 
            else
            {
              toastr.error(result.msg);
              return false;
            }
          },
          error: function (xhr, ajaxOptions, thrownError)
          {
            toastr.error("ajax call error");
            return false;
          }
      });   
    }
    else
    {
      return false;
    }
  }
</script>
</body>
</html>