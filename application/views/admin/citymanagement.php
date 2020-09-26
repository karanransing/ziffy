 <div class="container">
    <div class="animated fadeIn">
        <div class="row">
          <div class="col-md-12">
            <a href="<?php echo base_url('admin/city_add');?>" class="btn btn-xs pull-right" style="color: white;background-color:#27e7bf">New City</a>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title table_header">City Master
                <select class="pull-right" name="state_id" id="state_id" onchange="filterList(this.value)">
                  <option value="">Select State</option>
                  <?php if(!empty($state_master))
                  { foreach($state_master as $row){?>
                    <option value="<?php echo $row['id'] ?>"><?php echo $row['state'] ?>
                  <?php }}?>
                </select>
                </h4>
                <div class="table-responsive">
                  <table id="datatableUser" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th width="10%">#</th>
                          <th width="30%">State Name</th>
                          <th width="30%">City Name</th>
                          <th width="30%">Action</th>
                        </tr>
                      </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
     </div>
 </div>
 <script>
    var action = "<?php echo base_url('admin/getcitydata')?>";
    $(document).ready(function()
    {
        loadTable();
    });//document

    function filterList(state_id)
    {
      loadTable();
    }

    function loadTable()
    { 
      var state_id = $('#state_id').val();
      if ($.fn.DataTable.isDataTable("#datatableUser")) {
        $('#datatableUser').DataTable().clear().destroy();
      }
      var dataTable = $('#datatableUser').DataTable({  
       "processing":true,  
       "serverSide":true,  
       "order":[],
       "searching": false,
       rowReorder: 
       {
        selector: 'td:nth-child(2)'
      },
      responsive: true,
       "ajax":
       {  
        url:action,
        type:"POST",
        data:{'state_id':state_id}
       }
      });
    }  

    function deleteCity(city_id)
    {
      if(city_id)
      {
        swal({
          title: "Are you sure?",
          text: "You Want to Delete this City",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: 'red',
          confirmButtonText: 'Yes, I am sure!',
          cancelButtonText: "No, close it!",
          closeOnConfirm: true,
          closeOnCancel: false
        },
        function(isConfirm)
        {
          if (isConfirm)
          {
            /* ajax functionality to delete state */
            var action = "<?php echo base_url('admin/delete_city/'); ?>";
            var newAction  = action+city_id;
            $.ajax({
                url: newAction,
                type: "post",
                dataType: "json",
                success: function (result)
                {
                    if (result.status==true)
                    {
                      toastr.success(result.msg, 'Delete City', { "progressBar": true });
                      loadTable();
                    } 
                    else
                    {
                      toastr.error(result.msg, 'Delete City', { "progressBar": true });
                    }
                },
                error: function (xhr, ajaxOptions, thrownError)
                {
                  toastr.error('Ajax Call Error', 'Delete City', { "progressBar": true });
                }
            });
          }
          else
          {
            swal("Cancelled", "Your City data is safe :)", "error");
          }
        });
      }
      else
      {
        toastr.warning('Something Went Wrong Empty Id', 'Delete City', { "progressBar": true });
        return false;
      }
    }
</script>