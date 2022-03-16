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
                  <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-md btn-flat"><i class="fa fa-plus"></i>Add New</a>
                </div>
                <div class="card-body">
                  <table id="example1" class="table table-bordered">
                    <thead>
                      <th width="15%">Employee ID</th>
                      <th width="10%">Photo</th>
                      <th width="15%">Name</th>
                      <th width="15%">Position</th>
                      <th width="15%">Schedule</th>
                      <th width="15%">Member Since</th>
                      <th width="15%">Action</th>
                    </thead>
                    <tbody>
                      <?php
                        $sql = "SELECT 
                              *,
                              employees.id as empid
                            FROM 
                              employee_supervisors
                            INNER JOIN 
                              employees 
                            ON 
                              employees.id = employee_supervisors.employee_id
                            INNER JOIN 
                              `position`
                            ON 
                              `position`.id = employees.position_id
                            LEFT JOIN 
                              schedules 
                            ON 
                              schedules.id = employees.schedule_id
                            WHERE 
                              employee_supervisors.supervisor_id = '". $_SESSION['admin'] ."'";
                        $query = $conn->query($sql);
                        while($row = $query->fetch_assoc()){
                          ?>
                            <tr style="text-align:center;text-transform: capitalize;">
                              <td><?php echo $row['employee_id']; ?></td>
                              <td>
                                <img src="<?php echo (!empty($row['photo']))? '../images/'.$row['photo']:'../images/profile.jpg'; ?>" width="80px" height="100px"> 
                              </td>
                              <td><?php echo $row['firstname'].' '.$row['lastname']; ?></td>
                              <td><?php echo $row['description']; ?></td>
                              <td><?php echo date('h:i A', strtotime($row['time_in'])).' - '.date('h:i A', strtotime($row['time_out'])); ?></td>
                              <td><?php echo date('M d, Y', strtotime($row['created_on'])) ?></td>
                              <td>
                                <button class="btn btn-success btn-sm edit btn-flat" data-id="<?php echo $row['empid']; ?>"><i class="fa fa-edit"></i> Edit</button>
                                <button class="btn btn-danger btn-sm delete btn-flat" data-id="<?php echo $row['empid']; ?>"><i class="fa fa-trash"></i> Delete</button>
                              </td>
                            </tr>
                          <?php
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
              <h4 class="modal-title"><b>Add Employee</b></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="form-horizontal" method="POST" action="employee_add.php" enctype="multipart/form-data">
              <div class="modal-body">
              
                <div class="form-group">
                  <label for="firstname" class="col-sm-3 control-label">Firstname</label>

                  <div class="col-sm-12">
                    <input type="text" class="form-control text-capitalize" id="firstname" name="firstname" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="lastname" class="col-sm-3 control-label">Lastname</label>

                  <div class="col-sm-12">
                    <input type="text" class="form-control text-capitalize" id="lastname" name="lastname" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="address" class="col-sm-3 control-label">Address</label>

                  <div class="col-sm-12">
                    <textarea class="form-control" name="address" id="address"></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label for="datepicker_add" class="col-sm-3 control-label">Birthdate</label>

                  <div class="col-sm-12"> 
                    <div class="date">
                      <input type="date" class="form-control" id="datepicker_add" name="birthdate">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="contact" class="col-sm-3 control-label">Contact Info</label>

                  <div class="col-sm-12">
                    <input type="text" class="form-control" id="contact" name="contact">
                  </div>
                </div>
                <div class="form-group">
                  <label for="gender" class="col-sm-3 control-label">Gender</label>

                  <div class="col-sm-12"> 
                    <select class="form-control" name="gender" id="gender" required>
                      <option value="" selected>- Select -</option>
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="position" class="col-sm-3 control-label">Position</label>

                  <div class="col-sm-12">
                    <select class="form-control" name="position" id="position" required>
                      <option value="" selected>- Select -</option>
                      <?php
                        $sql = "SELECT * FROM position";
                        $query = $conn->query($sql);
                        while($prow = $query->fetch_assoc()){
                          echo "
                            <option value='".$prow['id']."'>".$prow['description']."</option>
                          ";
                        }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="schedule" class="col-sm-3 control-label">Schedule</label>

                  <div class="col-sm-12">
                    <select class="form-control" id="schedule" name="schedule" required>
                      <option value="" selected>- Select -</option>
                      <?php
                        $sql = "SELECT * FROM schedules";
                        $query = $conn->query($sql);
                        while($srow = $query->fetch_assoc()){
                          $timein = date('h:i A',strtotime($srow['time_in']));
                          $timeout = date('h:i A',strtotime($srow['time_out']));
                          echo "
                            <option value='".$srow['id']."'>".$timein.' - '.$timeout."</option>
                          ";
                        }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="photo" class="col-sm-3 control-label">Photo</label>

                  <div class="col-sm-9">
                    <input type="file" name="photo" id="photo">
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
              <h4 class="modal-title"><b><span class="employee_id"></span></b></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="form-horizontal" method="POST" action="employee_edit.php">
              <div class="modal-body">
                <input type="hidden" class="empid" name="id">
                <div class="form-group">
                  <label for="edit_firstname" class="col-sm-3 control-label">Firstname</label>

                  <div class="col-sm-12">
                    <input type="text" class="form-control text-capitalize" id="edit_firstname" name="firstname">
                  </div>
                </div>
                <div class="form-group">
                  <label for="edit_lastname" class="col-sm-3 control-label">Lastname</label>

                  <div class="col-sm-12">
                    <input type="text" class="form-control text-capitalize" id="edit_lastname" name="lastname">
                  </div>
                </div>
                <div class="form-group">
                  <label for="edit_address" class="col-sm-3 control-label">Address</label>

                  <div class="col-sm-12">
                    <textarea class="form-control" name="address" id="edit_address"></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label for="datepicker_edit" class="col-sm-3 control-label">Birthdate</label>

                  <div class="col-sm-12"> 
                    <div class="date">
                      <input type="date" class="form-control" id="datepicker_edit" name="birthdate">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="edit_contact" class="col-sm-3 control-label">Contact Info</label>

                  <div class="col-sm-12">
                    <input type="text" class="form-control" id="edit_contact" name="contact">
                  </div>
                </div>
                <div class="form-group">
                  <label for="edit_gender" class="col-sm-3 control-label">Gender</label>

                  <div class="col-sm-12"> 
                    <select class="form-control" name="gender" id="edit_gender">
                      <option selected id="gender_val"></option>
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="edit_position" class="col-sm-3 control-label">Position</label>

                  <div class="col-sm-12">
                    <select class="form-control" name="position" id="edit_position">
                      <option selected id="position_val"></option>
                      <?php
                        $sql = "SELECT * FROM position";
                        $query = $conn->query($sql);
                        while($prow = $query->fetch_assoc()){
                          echo "
                            <option value='".$prow['id']."'>".$prow['description']."</option>
                          ";
                        }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="edit_schedule" class="col-sm-3 control-label">Schedule</label>

                  <div class="col-sm-12 ">
                    <select class="form-control" id="edit_schedule" name="schedule">
                      <option selected id="schedule_val"></option>
                      <?php
                        $sql = "SELECT * FROM schedules";
                        $query = $conn->query($sql);
                        while($srow = $query->fetch_assoc()){
                          $timein = date('h:i A',strtotime($srow['time_in']));
                          $timeout = date('h:i A',strtotime($srow['time_out']));
                          echo "
                            <option value='".$srow['id']."'>".$timein.' - '.$timeout."</option>
                          ";
                        }
                      ?>
                    </select>
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
                    <h4 class="modal-title"><b><span class="employee_id"></span></b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form class="form-horizontal" method="POST" action="employee_delete.php">
                    <div class="modal-body">
                    
                      <input type="hidden" class="empid" name="id">
                      <div class="text-center">
                          <p>DELETE EMPLOYEE</p>
                          <h2 class="bold del_employee_name"></h2>
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

      <!-- Update Photo -->
      <div class="modal fade" id="edit_photo">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><b><span class="del_employee_name"></span></b></h4>
                  </div>
                  <div class="modal-body">
                    <form class="form-horizontal" method="POST" action="employee_edit_photo.php" enctype="multipart/form-data">
                      <input type="hidden" class="empid" name="id">
                      <div class="form-group">
                          <label for="photo" class="col-sm-3 control-label">Photo</label>

                          <div class="col-sm-9">
                            <input type="file" id="photo" name="photo" required>
                          </div>
                      </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                    <button type="submit" class="btn btn-success btn-flat" name="upload"><i class="fa fa-check-square-o"></i> Update</button>
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

    $('.photo').click(function(e){
      e.preventDefault();
      var id = $(this).data('id');
      getRow(id);
    });

  });

  function getRow(id){
    $.ajax({
      type: 'POST',
      url: 'employee_row.php',
      data: {id:id},
      dataType: 'json',
      success: function(response){
        $('.empid').val(response.empid);
        $('.employee_id').html(response.employee_id);
        $('.del_employee_name').html(response.firstname+' '+response.lastname);
        $('#employee_name').html(response.firstname+' '+response.lastname);
        $('#edit_firstname').val(response.firstname);
        $('#edit_lastname').val(response.lastname);
        $('#edit_address').val(response.address);
        $('#datepicker_edit').val(response.birthdate);
        $('#edit_contact').val(response.contact_info);
        $('#gender_val').val(response.gender).html(response.gender);
        $('#position_val').val(response.position_id).html(response.description);
        $('#schedule_val').val(response.schedule_id).html(response.time_in+' - '+response.time_out);
      }
    });
  }
  </script>
  </body>
  </html>
