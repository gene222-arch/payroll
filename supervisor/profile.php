<?php
  include 'session.php';
  
  $userId = $_SESSION['admin'];
  $sql = "SELECT * FROM supervisors WHERE id = '$userId'";
  $query = $conn->query($sql);
  $row = $query->fetch_assoc();

  if(empty($row['photo'])){
    $img_url = "profile.jpg";
  }else{
    $img_url = $row['photo'];
  }
  
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
  <!-- Toastr -->
  <link rel="stylesheet" href="../plugins/toastr/toastr.min.css">
  <style>
    .main-header *{
      color: #FFF !important;
    }
  </style>
</head>
<body class="hold-transition layout-top-nav dark-mode">
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
    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="row mt-5">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h1 class="text-capitalize"><?php echo $row['firstname']." ".$row['lastname'] ?></h1>
              </div>
              <div class="card-body">
                <div class="row float-right">
                  <img src="<?php echo "../images/".$img_url ?>" width="150" height="100">
                </div>
                <div class="row">
                  <dl class="row">
                    <dt class="col-sm-4">First Name</dt>
                    <dd class="col-sm-8 text-capitalize"><?php echo $row['firstname']; ?></dd>
                    <dt class="col-sm-4">Last Name</dt>
                    <dd class="col-sm-8 text-capitalize"><?php echo $row['lastname']; ?></dd>
                    <dt class="col-sm-4">Supervisor ID</dt>
                    <dd class="col-sm-8"><?php echo $row['employee_id']; ?></dd>
                  </dl>
                </div>
              </div>
              <div class="card-footer">
                <button class="btn btn-primary btn-md btn-flat float-left changepass">Change Password</button>
                <button class="btn btn-primary btn-md btn-flat float-right editprofile">Edit Profile</button>
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
    <!-- Change password -->
    <div class="modal fade" id="changepass">
      <div class="modal-dialog">
        <div class="modal-content">
          <form class="form-horizontal" method="POST" action="profile.php">
            <div class="modal-header">
              <h4 class="modal-title">Change Password</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <input type="hidden" name="empid" value="<?php echo $row['id'] ?>">
              <div class="form-group">
                <label for="edit_schedule">Current Password</label>
                <div class="col-sm-12">
                  <input type="password" class="form-control" name="currpass" id="currpass" required>
                </div>
              </div>
              <div class="form-group">
                <label for="edit_schedule">New Password</label>
                <div class="col-sm-12">
                  <input type="password" class="form-control" name="newpass" id="newpass" required>
                </div>
              </div>
              <div class="form-group">
                <label for="edit_schedule">Confirm Password</label>
                <div class="col-sm-12">
                  <input type="password" class="form-control" name="confirmpass" id="confirmpass" required>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
              <button type="submit" class="btn btn-success btn-flat" name="changepass"><i class="fa fa-check-square-o"></i> Update</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Edit Profile -->
    <div class="modal fade" id="editprofile">
      <div class="modal-dialog">
        <div class="modal-content">
          <form class="form-horizontal" method="POST" action="profile.php">
            <div class="modal-header">
              <h4 class="modal-title">Edit Profile</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <input type="hidden" name="empid" value="<?php echo $row['id'] ?>">
              <div class="form-group">
                <label for="edit_schedule">First Name</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control text-capitalize" name="firstname" id="firstname" value="<?php echo $row['firstname'] ?>"required>
                </div>
              </div>
              <div class="form-group">
                <label for="edit_schedule">Last Name</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control text-capitalize" name="lastname" id="lastname" value="<?php echo $row['lastname'] ?>" required>
                </div>
              </div>
              <div class="form-group">
                <label for="edit_schedule">Password</label>
                <div class="col-sm-12">
                  <input type="password" class="form-control" name="password" id="password" required>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
              <button type="submit" class="btn btn-success btn-flat" name="updateprofile"><i class="fa fa-check-square-o"></i> Update</button>
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
<!-- Toastr -->
<script src="../plugins/toastr/toastr.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
<script>
$(function(){
  $('.changepass').click(function(e){
    e.preventDefault();
    $('#changepass').modal('show');
  });
  $('.editprofile').click(function(e){
    e.preventDefault();
    $('#editprofile').modal('show');
  });
});
</script>
<?php
if(isset($_POST['changepass'])){
  $id = $_POST['empid'];
  $currpass = $_POST['currpass'];
  $newpass = $_POST['newpass'];
  $confirmpass = $_POST['confirmpass'];

  if($confirmpass == $newpass){
    $sql = "SELECT * FROM supervisors WHERE id = '$id'";
    $query = $conn->query($sql);

    if($query->num_rows < 1){
      $errormsg = 'Cannot find account with the username';
    }else{
      $row = $query->fetch_assoc();
      if(password_verify($currpass, $row['password'])){
        $newpassword = password_hash($newpass, PASSWORD_DEFAULT);
        $sql = "UPDATE supervisors SET password='$newpassword' WHERE id='$id'";
        if (mysqli_query($conn, $sql)) {
          echo "
            <script>
              toastr.success('Changed Password Successfully!')
            </script>
          ";
        }
      }else{
        echo "
          <script>
            toastr.error('Incorrect Password')
          </script>
        ";
      }
    }
  }else{
    echo "
      <script>
        toastr.error('Password does not match')
      </script>
    ";
  }
}

if(isset($_POST['updateprofile'])){
  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];
  $password = $_POST['password'];
  $id = $_POST['empid'];

  $sql = "SELECT * FROM supervisors WHERE id = '$id'";
  $query = $conn->query($sql);
  $row = $query->fetch_assoc();
  if(password_verify($password, $row['password'])){
    
    $sql = "UPDATE supervisors SET firstname='$firstname', lastname='$lastname' WHERE id='$id'";
    if (mysqli_query($conn, $sql)){
      header('location: profile.php');
      echo "
        <script>
          toastr.success('Profile Updated Successfully')
        </script>
      ";
      
    }
  }else{
    echo "
      <script>
        toastr.error('Incorrect Password')
      </script>
    ";
  }
}

?>
</body>
</html>
