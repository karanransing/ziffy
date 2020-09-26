  <div class="container">
    <div class="animated fadeIn">
      <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6">
          <div class="jumbotron border_class">
            <a href="<?php echo base_url('admin/state_management');?>">
              <div class="card-body">
                <h4 class="card-title">State</h4>
                <h4 class="card-title"><?php if(!empty($countdata['state'])){ echo $countdata['state'];}else {echo "0";} ?> </h4>
              </div>
            </a>
          </div>
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6">
          <div class="jumbotron border_class">
            <a href="<?php echo base_url('admin/city_management');?>">
              <div class="card-body">
                <h4 class="card-title">City</h4>
                <h4 class="card-title"><?php if(!empty($countdata['city'])){ echo $countdata['city'];}else {echo "0";} ?> </h4>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>