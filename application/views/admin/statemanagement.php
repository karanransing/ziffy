 <div class="container">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                  <a href="<?php echo base_url('admin/state_add');?>" class="btn btn-xs pull-right" style="color: white;background-color:#27e7bf">New State</a>
                    <div class="card-body">
                        <h4 class="card-title table_header">State Master</h4>
                          <div class="table-responsive">
                            <table id="datatableUser" class="table table-striped table-bordered">
                                <thead>
                                  <tr>
                                    <th width="20%">#</th>
                                    <th width="40%">State Name</th>
                                    <th width="40%">Action</th>
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
    var action = "<?php echo base_url('admin/getstatedata')?>";
    $(document).ready(function()
    {
        loadTable();
    });//document

    function loadTable()
    {
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
        type:"POST"
       }
      });
    }  

    function deleteState(state_id)
    {
      if(state_id)
      {
        swal({
          title: "Are you sure?",
          text: "You Want to Delete this State",
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
            var action = "<?php echo base_url('admin/delete_state/'); ?>";
            var newAction  = action+state_id;
            $.ajax({
                url: newAction,
                type: "post",
                dataType: "json",
                success: function (result)
                {
                    if (result.status==true)
                    {
                      toastr.success(result.msg, 'Delete State', { "progressBar": true });
                      loadTable();
                    } 
                    else
                    {
                      toastr.error(result.msg, 'Delete State', { "progressBar": true });
                    }
                },
                error: function (xhr, ajaxOptions, thrownError)
                {
                  toastr.error('Ajax Call Error', 'Delete State', { "progressBar": true });
                }
            });
          }
          else
          {
            swal("Cancelled", "Your State data is safe :)", "error");
          }
        });
      }
      else
      {
        toastr.warning('Something Went Wrong Empty Id', 'Delete State', { "progressBar": true });
        return false;
      }
    }
</script>