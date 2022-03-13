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
                <h4>Payroll</h4>
              </div>
              <div class="card-body">
                <table id="example1" class="table table-bordered">
                  <thead>
                    <th width="22%">Employee ID</th>
                    <th width="22%">Name</th>
                    <th width="15%">Position</th>
                    <th width="15%">Photo</th>
                    <th width="15%">Action</th>
                  </thead>
                  <tbody>
                    <?php
                      $sql = "SELECT * from employees ORDER BY created_on ASC";
                      $query = $conn->query($sql);
                      while($row = $query->fetch_assoc()){
                        $position_id = $row['position_id'];
                        $sql2 = "SELECT * FROM position WHERE id='$position_id'";
                        $query2 = $conn->query($sql2);
                        $row2 = $query2->fetch_assoc();
                        $position = $row2['description'];
                        echo "
                          <tr>
                            <td>".$row['employee_id']."</td>
                            <td style='text-transform: capitalize'>".$row['firstname'].' '.$row['lastname']."</td>
                            <td style='text-transform: capitalize'>".$position."</td>
                            <td style='text-align: center;'><img src='../images/".$row['photo']."' width='150' height='100'></td>
                            <td>
                            <form action='payroll-generate.php' method='POST'>
                              <button type='submit' class='btn btn-success btn-sm btn-flat' name='payroll-generate' value='".$row['id']."'><i class='far fa-credit-card'></i> Generate Payroll</button>
                            </form>
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
</body>
</html>
