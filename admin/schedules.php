<?php
  include 'session.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Triple A</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <style>
    .main-header *{
      color: #FFF !important;
    }
  </style>
</head>
<body class="hold-transition layout-top-nav dark-mode" onload="display_ct();">
<div class="wrapper">

  <!-- Navbar -->
  <?php include_once('./includes/navbar.php') ?>
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <?php
    if(isset($_SESSION['error'])){
      echo "
        <div class='alert alert-danger alert-dismissible'>
          <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
          <h4><i class='icon fa fa-warning'></i> Error!</h4>
          ".$_SESSION['error']."
        </div>
      ";
      unset($_SESSION['error']);
    }
    if(isset($_SESSION['success'])){
      echo "
        <div class='alert alert-success alert-dismissible'>
          <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
          <h4><i class='icon fa fa-check'></i> Success!</h4>
          ".$_SESSION['success']."
        </div>
      ";
      unset($_SESSION['success']);
    }
  ?>

    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="row mt-5">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-md btn-flat"><i class="fa fa-plus"></i>Add New</a>
              </div>
              <div class="card-body">
                <table id="example1" class="table table-bordered">
                  <thead>
                    <th width="33%">Time In</th>
                    <th width="33%">Time Out</th>
                    <th width="34%">Tools</th>
                  </thead>
                  <tbody>
                    <?php
                      $sql = "SELECT * FROM schedules ORDER BY time_in ASC";
                      $query = $conn->query($sql);
                      while($row = $query->fetch_assoc()){
                        echo "
                          <tr>
                            <td>".date('h:i A', strtotime($row['time_in']))."</td>
                            <td>".date('h:i A', strtotime($row['time_out']))."</td>
                            <td>
                              <button class='btn btn-success btn-sm edit btn-flat' data-id='".$row['id']."'><i class='fa fa-edit'></i> Edit</button>
                              <button class='btn btn-danger btn-sm delete btn-flat' data-id='".$row['id']."'><i class='fa fa-trash'></i> Delete</button>
                            </td>
                          </tr>
                        ";
                      }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- modals -->
    <!-- Add -->
    <div class="modal fade" id="addnew">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"><b>Add Schedule</b></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form class="form-horizontal" method="POST" action="schedule_add.php">
            <div class="modal-body">
              <div class="form-group">
                <label for="time_in" class="col-sm-3 control-label">Time In</label>

                <div class="col-sm-9">
                  <div class="bootstrap-timepicker">
                  <input type="time" class="form-control timepicker" id="time_in" name="time_in" required>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="time_out" class="col-sm-3 control-label">Time Out</label>

                <div class="col-sm-9">
                  <div class="bootstrap-timepicker">
                    <input type="time" class="form-control timepicker" id="time_out" name="time_out" required>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
              <button type="submit" class="btn btn-primary btn-flat" name="add"><i class="fa fa-save"></i> Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Edit -->
    <div class="modal fade" id="edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title"><b>Update Schedule</b></h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form class="form-horizontal" method="POST" action="schedule_edit.php">
                    <input type="hidden" id="timeid" name="id">
                    <div class="form-group">
                        <label for="edit_time_in" class="col-sm-3 control-label">Time In</label>

                        <div class="col-sm-12">
                          <div class="bootstrap-timepicker">
                            <input type="time" class="form-control timepicker" id="edit_time_in" name="time_in">
                          </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_time_out" class="col-sm-3 control-label">Time out</label>

                        <div class="col-sm-12">
                          <div class="bootstrap-timepicker">
                            <input type="time" class="form-control timepicker" id="edit_time_out" name="time_out">
                          </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                  <button type="submit" class="btn btn-success btn-flat" name="edit"><i class="fa fa-check-square-o"></i> Update</button>
                  </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete -->
    <div class="modal fade" id="delete">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title"><b>Deleting...</b></h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form class="form-horizontal" method="POST" action="schedule_delete.php">
                    <input type="hidden" id="del_timeid" name="id">
                    <div class="text-center">
                        <p>DELETE SCHEDULE</p>
                        <h2 id="del_schedule" class="bold"></h2>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                  <button type="submit" class="btn btn-danger btn-flat" name="delete"><i class="fa fa-trash"></i> Delete</button>
                  </form>
                </div>
            </div>
        </div>
    </div>
  <!-- end of modals -->

</div>
<!-- ./wrapper -->
<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
<script>
$(function(){
  $('.edit').click(function(e){
    e.preventDefault();
    $('#edit').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $('.delete').click(function(e){
    e.preventDefault();
    $('#delete').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });
});

function getRow(id){
  $.ajax({
    type: 'POST',
    url: 'schedule_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('#timeid').val(response.id);
      $('#edit_time_in').val(response.time_in);
      $('#edit_time_out').val(response.time_out);
      $('#del_timeid').val(response.id);
      $('#del_schedule').html(response.time_in+' - '+response.time_out);
    }
  });
}
</script>
</body>
</html>
