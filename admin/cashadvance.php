<?php
  include 'session.php';

  require_once('./Helpers/Employee.php');
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
      <a href="index.php  " class="navbar-brand">
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
          <li class="nav-item">
            <a href="payroll.php" class="nav-link">Payroll</a>
          </li>
          <li class="nav-item">
            <a href="schedule-employee.php" class="nav-link">Schedule</a>
          </li>
          <li class="nav-item dropdown">
            <a id="dropdownSubMenu2" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle" style="text-transform: capitalize"><?php echo $user['lastname']; ?></a>
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
                <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-md btn-flat"><i class="fa fa-plus"></i>Add New</a>
              </div>
              <div class="card-body">
                <table id="example1" class="table table-bordered">
                  <thead>
                    <th width="20%">Date</th>
                    <th width="20%">Employee ID</th>
                    <th width="20%">Name</th>
                    <th width="20%">Amount</th>
                    <th width="20%">Tools</th>
                  </thead>
                  <tbody>
                    <?php
                      $sql = "SELECT *, cashadvance.id AS caid, employees.employee_id AS empid FROM cashadvance LEFT JOIN employees ON employees.id=cashadvance.employee_id ORDER BY date_advance DESC";
                      $query = $conn->query($sql);
                      while($row = $query->fetch_assoc()){
                        echo "
                          <tr>
                            <td>".date('M d, Y', strtotime($row['date_advance']))."</td>
                            <td>".$row['empid']."</td>
                            <td class='text-capitalize'>".$row['firstname'].' '.$row['lastname']."</td>
                            <td>".number_format($row['amount'], 2)."</td>
                            <td>
                              <button class='btn btn-success btn-sm edit btn-flat' data-id='".$row['caid']."'><i class='fa fa-edit'></i> Edit</button>
                              <button class='btn btn-danger btn-sm delete btn-flat' data-id='".$row['caid']."'><i class='fa fa-trash'></i> Delete</button>
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
          <form class="form-horizontal" method="POST" action="cashadvance_add.php">
            <div class="modal-header">
              <h4 class="modal-title"><b>Add Cash Advance</b></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label for="employee" class="col-sm-3 control-label">Employee ID</label>

                <div class="col-sm-12">
                	<label for="exampleFormControlSelect1">Select Employee</label>
                    <select class="form-control" name="employee" id="exampleFormControlSelect1">
                		<option value="0">Employees</option>
						<?php 
								foreach (Employee::all() as $employee) {
								?>  
									<option value="<?= $employee['employee_id'] ?>">
									<?= "{$employee['employee_id']} - {$employee['firstname']}" ?>
									</option>
								<?php
								}
							?>
                    </select>
                </div>
              </div>
              <div class="form-group">
                <label for="amount" class="col-sm-3 control-label">Amount</label>

                <div class="col-sm-12">
                  <input type="text" class="form-control" id="amount" name="amount" required>
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
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form class="form-horizontal" method="POST" action="cashadvance_edit.php">
            <div class="modal-body">
              <input type="hidden" class="caid" name="id">
              <div class="form-group">
                <label for="edit_amount" class="col-sm-3 control-label">Amount</label>

                <div class="col-sm-12">
                  <input type="text" class="form-control" id="edit_amount" name="amount" required>
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
            <h4 class="modal-title"><b><span class="date"></span></b></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            
          </div>
          <form class="form-horizontal" method="POST" action="cashadvance_delete.php">
            <div class="modal-body">
              <input type="hidden" class="caid" name="id">
              <div class="text-center">
                  <p>DELETE CASH ADVANCE</p>
                  <h2 class="employee_name bold text-capitalize"></h2>
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
    url: 'cashadvance_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      console.log(response);
      $('.date').html(response.date_advance);
      $('.employee_name').html(response.firstname+' '+response.lastname);
      $('.caid').val(response.caid);
      $('#edit_amount').val(response.amount);
    }
  });
}
</script>
</body>
</html>
