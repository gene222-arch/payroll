<?php

  include 'session.php';
  require_once('./Helpers/Deduction.php');

  $today = date("M/d/Y");

  $day = date('d');

  $totalCashAdvance = 0;
  $overtimeHour = 0;

  if($day >= 1 && $day <= 15){
    $beginDate = date("M/01/Y");
    $endDate = date("M/15/Y");
    $sqldate_start = date("Y-m-01");
    $sqldate_end = date("Y-m-15");
  }else{
    $beginDate = date("M/16/Y");
    $endDate = date("M/t/Y");
    $sqldate_start = date("Y-m-16");
    $sqldate_end = date("Y-m-t");
  }

  if(isset($_POST['payroll-generate'])){
    $id = $_POST['payroll-generate'];
    $sql = "SELECT * from employees WHERE id='$id'";
    $query = $conn->query($sql);
    $row = $query->fetch_assoc();
    $name = $row['firstname'] . " " . $row['lastname'];
    $address = $row['address'];
    $contact = $row['contact_info'];
    $employee_id = $row['employee_id'];
    $position_id = $row['position_id'];
  }

  

  $sql = "SELECT * FROM position WHERE id='$position_id'";
  $query = $conn->query($sql);
  $row = $query->fetch_assoc();
  $position_name = $row['description'];
  $position_rate = $row['rate'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Triple A</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
</head>
<body>
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-12">
        <h2 class="page-header">
          Triple A
          <small class="float-right">Date: <?php echo $today; ?></small>
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info mt-3">
      <table class="table table-bordered">
        <thead>
          <th>Name</th>
          <th>Employee ID</th>
          <th>Position</th>
          <th>Contact</th>
          <th>Pay Begin Date</th>
          <th>Pay End Date</th>
        </thead>
        <tbody>
          <tr class="text-capitalize">
            <td><?php echo $name ?></td>
            <td><?php echo $employee_id ?></td>
            <td><?php echo $position_name ?></td>
            <td><?php echo $contact ?></td>
            <td><?php echo $beginDate ?></td>
            <td><?php echo $endDate ?></td>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- /.row -->

    <div class="row">
      <!-- /.col -->
      <div class="col-6">
        <p class="lead">Cash Advance</p>
        <div class="table-responsive table-bordered table-striped">
          <table class="table">
            <?php 
              $sql = "SELECT * FROM cashadvance WHERE employee_id='$id'";
              $result = mysqli_query($conn, $sql);

              if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                  $totalCashAdvance += $row['amount'];
                  echo '
                  <tr>
                    <th style="width:50%">'.$row['date_advance'].'</th>
                    <td>'.$row['amount'].'</td>
                  </tr>
                  ';
                }
              }
            ?>
          </table>
        </div>
        <!-- <p class="lead">Deductions</p>
        <div class="table-responsive table-bordered table-striped">
          <table class="table">
              $sql = "SELECT * FROM deductions WHERE employee_id='$id'";
              $result = mysqli_query($conn, $sql);

              if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                  $totalCashAdvance += $row['amount'];
                  echo '
                  <tr>
                    <th style="width:50%">'.$row['description'].'</th>
                    <td>'.$row['amount'].'</td>
                  </tr>
                  ';
                }
              } 
          </table>
        </div> 
        <p class="lead">Overtimes</p>
        <div class="table-responsive table-bordered table-striped">
          <table class="table">
              $sql = "SELECT * FROM overtime WHERE employee_id='$id'";
              $result = mysqli_query($conn, $sql);

              if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                  $overtimeHour += $row['hours'];
                  $overTimeRate = $row['rate'];
                  
                  echo '
                    <tr>
                      <th style="width:50%">'.$row['date_overtime'].'</th>
                      <td>'.$row['hours'].' Hr/s</td>
                    </tr>
                  ';
                }
                $overTimeAmount = $overTimeRate * $overtimeHour;
              }
          </table>
        </div> -->
      </div>
      <!-- /.col -->
      <!-- /.col -->
      <div class="col-6">
        <p class="lead">Number of days worked</p>

        <div class="table-responsive table-bordered table-striped">
          <table class="table">
            <?php 
              $sql = "SELECT count(date) as days FROM attendance WHERE employee_id='$id' AND date BETWEEN '$sqldate_start' AND '$sqldate_end'";
              $result = mysqli_query($conn, $sql);

              if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                  $daysPresent = $row['days'];
                  echo '
                    <tr>
                      <th style="width:50%">Number of Days Present:</th>
                      <td>'.$daysPresent.'</td>
                    </tr>
                  ';
                }
              }
              echo '
                <tr>
                  <th style="width:50%">Rate:</th>
                  <td>'.$position_rate.'</td>
                </tr>
              ';
              // echo '
              //   <tr>
              //     <th style="width:50%">Overtime:</th>
              //     <td>'.$overTimeAmount.'</td>
              //   </tr>
              // ';
              $subtotal = $position_rate * $daysPresent;
              // $subtotal = ($position_rate * $daysPresent) + $overTimeAmount;
              ?> 
                <tr>
                  <th style="width:50%">Total Cash Deductions:</th>
                  <td>
                    <?= Deduction::total()->total_deductions ?>
                  </td>
                </tr>
              <?php 
              echo '
                <tr>
                  <th style="width:50%">Subtotal:</th>
                  <td>'.$subtotal.'</td>
                </tr>
                <tr>
                  <th style="width:50%">Total Cash Advance:</th>
                  <td>'.$totalCashAdvance.'</td>
                </tr>
              ';
              $total = $subtotal - $totalCashAdvance - Deduction::total()->total_deductions;
              echo '
                <tr>
                  <th style="width:50%">Total:</th>
                  <td>'.$total.'</td>
                </tr>
              ';
            ?>
          </table>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
<!-- Page specific script -->
<script>
  window.addEventListener("load", window.print());
</script>
</body>
</html>
