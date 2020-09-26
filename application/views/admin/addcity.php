<div class="container">
  <div class="row">
    <div class="col-md-12">
      <a href="<?php echo site_url('admin/city_management');?>" class="btn btn-warning btn-sm pull-right">Back</a>
    </div>
  </div>
  <br>
  <div class="row">
    <div class="col-md-12">
      <div class="text-center text-danger">
        <?php echo validation_errors(); ?>
      </div>
    </div>
    <br>
    <?php if(!empty($city_data)){?>
      <form method="post" name="add_city"  id="add_city" action="<?php echo site_url('city/updatecity/'.$city_data['id']);?>">
      <?php } else { ?>
        <form method="post" name="add_city"  id="add_city" action="<?php echo site_url('city/savecity');?>">
        <?php } ?>
        <div class="row">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title table_header"><?php if(!empty($city_data)){ echo "Update";} else { echo "Add";}?> City</h4>
              <div class="table-responsive">
                <table id="datatableUser" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th width="50%">Select State</th>
                      <th width="50%">
                        <select class="form-control" name="state_id" id="state_id">
                        <option value="">Select State</option>
                        <?php if(!empty($state_master)){ 
                          foreach($state_master as $row){?>
                          <option value="<?php echo $row['id'] ?>" <?php echo set_select('state_id', $row['id'],(!empty($city_data['state_id']) && $city_data['state_id'] == $row['id']) ? TRUE : FALSE); ?>><?php echo $row['state']; ?>
                          </option>
                        <?php } } ?>
                        </select>
                      </th>
                    </tr>
                    <tr>
                      <th width="50%">Enter City Name</th>
                      <th width="50%"><input type="text" name="city" id="city" placeholder="Enter City Name" class="form-control" value="<?php if(set_value('city')) {echo set_value('city');} else if(!empty($city_data) && !set_value('city')) { echo $city_data['city'];}?>"></th>
                    </tr>
                    <tr>
                      <th width="50%"><button class="form-control btn btn-info submit_new"><?php if(!empty($city_data)){ echo "Update";} else { echo "Add";}?></button></th>
                      <th width="50%"><input type="reset" class="form-control btn btn-info" value="Cancel"/></th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>	
    <script>
      $(document).ready(function(){
      });

      $("#add_city").validate({
        rules: 
        {
          state_id :"required", 
          city:"required"
        },
        messages: 
        {  
          state_id :"Select State", 
          city:"Enter City Name"
        }
     });

      $('.submit_new').click(function(){ 
        if($("#add_city").valid())
        { 
          $("#add_city").submit();
        }
      });
    </script>
  </body>
  </html>