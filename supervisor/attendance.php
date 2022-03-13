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
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white dark-mode">
    <div class="container">
      <a href="index.php" class="navbar-brand">
        <span class="brand-text font-weight-bold">TRIPLE A</span>
      </a>

      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a href="index.php" class="nav-link">Home</a>
          </li>
          <li class="nav-item">
            <a href="attendance.php" class="nav-link">Attendance</a>
          </li>
          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Employee</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="employees.php" class="dropdown-item">Employee List </a></li>
              <li><a href="cashadvance.php" class="dropdown-item">Cash Advance</a></li>
              <li><a href="schedules.php" class="dropdown-item">Schedules</a></li>
              <li><a href="positions.php" class="dropdown-item">Positions</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a id="dropdownSubMenu2" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle" style="text-transform: capitalize"><?php echo $_SESSION['fullname'] ?></a>
            <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
              <li><a href="profile.php" class="dropdown-item">My Profile</a></li>
              <li><a href="logout.php" class="dropdown-item">Logout</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
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
              </div>
              <div class="card-body">
                <table id="example1" class="table table-bordered">
                  <thead>
                    <th width="10%">Date</th>
                    <th width="22%">Employee ID</th>
                    <th width="22%">Name</th>
                    <th width="15%">Time In</th>
                    <th width="15%">Time Out</th>
                    <th width="15%">Tools</th>
                  </thead>
                  <tbody>
                    <?php
                      $sql = "SELECT *, employees.employee_id AS empid, attendance.id AS attid FROM attendance LEFT JOIN employees ON employees.id=attendance.employee_id ORDER BY attendance.date DESC, attendance.time_in DESC";
                      $query = $conn->query($sql);
                      while($row = $query->fetch_assoc()){
                        $status = ($row['status'])?'<span class="badge badge-success float-right">ontime</span>':'<span class="badgee badge-danger float-right">late</span>';
                        if($row['time_out'] == '00:00:00'){
                          $timeout = 'Not timed out';
                        }else{
                          $timeout = date('h:i A', strtotime($row['time_out']));
                        }
                        echo "
                          <tr>
                            <td>".date('M d, Y', strtotime($row['date']))."</td>
                            <td>".$row['empid']."</td>
                            <td  style='text-transform: capitalize'>".$row['firstname'].' '.$row['lastname']."</td>
                            <td>".date('h:i A', strtotime($row['time_in'])).$status."</td>
                            <td>".$timeout."</td>
                            <td>
                              <button class='btn btn-success btn-sm btn-flat edit' data-id='".$row['attid']."'><i class='fa fa-edit'></i> Edit</button>
                              <button class='btn btn-danger btn-sm btn-flat delete' data-id='".$row['attid']."'><i class='fa fa-trash'></i> Delete</button>
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
            <h4 class="modal-title"><b>Add Attendance</b></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form class="form-horizontal" method="POST" action="attendance_add.php">
            <div class="modal-body">
              <div class="form-group">
                <label for="employee" class="col-sm-3 control-label">Employee ID</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="employee" name="employee" required>
                </div>
              </div>
              <div class="form-group">
                <label for="datepicker_add" class="col-sm-3 control-label">Date</label>

                <div class="col-sm-12"> 
                  <div class="date">
                    <input type="date" class="form-control" id="datepicker_add" name="date" required>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="time_in" class="col-sm-3 control-label">Time In</label>

                <div class="col-sm-12">
                  <div class="bootstrap-timepicker">
                    <input type="time" class="form-control timepicker" id="time_in" name="time_in">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="time_out" class="col-sm-3 control-label">Time Out</label>

                <div class="col-sm-12">
                  <div class="bootstrap-timepicker">
                    <input type="time" class="form-control timepicker" id="time_out" name="time_out">
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
            <h4 class="modal-title"><b><span id="employee_name" style="text-transform: capitalize"></span></b></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form class="form-horizontal" method="POST" action="attendance_edit.php">
            <div class="modal-body">
            
              <input type="hidden" id="attid" name="id">
              <div class="form-group">
                <label for="datepicker_edit" class="col-sm-3 control-label">Date</label>

                <div class="col-sm-12"> 
                  <div class="date">
                    <input type="date" class="form-control" id="datepicker_edit" name="edit_date">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="edit_time_in" class="col-sm-3 control-label">Time In</label>

                <div class="col-sm-12">
                  <div class="bootstrap-timepicker">
                    <input type="time" class="form-control timepicker" id="edit_time_in" name="edit_time_in">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="edit_time_out" class="col-sm-3 control-label">Time Out</label>

                <div class="col-sm-12">
                  <div class="bootstrap-timepicker">
                    <input type="time" class="form-control timepicker" id="edit_time_out" name="edit_time_out">
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
              <button type="submit" class="btn btn-success btn-flat" name="edit"><i class="fa fa-check-square-o"></i> Update</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Delete -->
    <div class="modal fade" id="delete">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title"><b><span id="attendance_date"></span></b></h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form class="form-horizontal" method="POST" action="attendance_delete.php">
                  <div class="modal-body">
                    <input type="hidden" id="del_attid" name="id">
                    <div class="text-center">
                      <p>DELETE ATTENDANCE</p>
                      <h2 id="del_employee_name" class="bold"></h2>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                    <button type="submit" class="btn btn-danger btn-flat" name="delete"><i class="fa fa-trash"></i> Delete</button>
                  </div>
                </form>
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
    url: 'attendance_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('#datepicker_edit').val(response.date);
      $('#attendance_date').html(response.date);
      $('#edit_time_in').val(response.time_in);
      $('#edit_time_out').val(response.time_out);
      $('#attid').val(response.attid);
      $('#employee_name').html(response.firstname+' '+response.lastname);
      $('#del_attid').val(response.attid);
      $('#del_employee_name').html(response.firstname+' '+response.lastname);
    }
  });
}
</script>
</body>
</html>
