<?php
  include 'session.php';
  require_once('./../admin/Helpers/Employee.php');
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
    .dateBox-container{
      color: #fff;
      background: transparent;
      padding: 10px 15px;
      border: 3px solid #2E94E3;
      border-radius: 5px;
      -webkit-box-reflect: below 1px linear-gradient(transparent, rgba(255, 255, 255, 0.1));
      transition: 0.5s;
      transition-property: background, box-shadow;
      margin: auto;
    }
    .dateBox-container:hover{
      background: #2E94E3;
      box-shadow: 0 0 30px #2e94e3;
    }
    .time, .date{
      text-align: center;
    }
    #dayOfweek, #dateToday{
      font-size: 20px;
      font-weight: 600;
      text-align: center;
      letter-spacing: 3px;
    }
    #currentTime, #ampm{
      font-size: 60px;
      display: inline;
    }
    #ampm{
      background: #2e94e3;
      font-size: 30px;
      font-weight: 600;
      text-transform: uppercase;
      padding: 0 5px;
      border-radius: 3px;
      vertical-align: text-bottom;
    }
    #click-photo, #canvas{
      display: none;
    }
    .camera-container *{
      display: block;
      margin: auto;
    }
    /* .row{
      margin-top: 50px;
    } */
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

    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="row mt-5">
          <div class="col-6" style="text-align: center; align-self: center;">
            <div class="dateBox-container" style="display: inline-block;">
              <div class="date">
                <span id="dayOfweek"></span>
                <span id="dateToday"></span>
              </div>
              <div class="time">
                <span id="currentTime"></span>
                <span id="ampm"></span>
              </div>
            </div>
          </div>
          <div class="col-6">
            <div class="camera-container">
              <video id="video" width="320" height="240" autoplay></video>
              <button class="btn btn-primary btn-flat btn-md" style="margin-bottom: 10px;" id="start-camera">Start Camera</button>
              <canvas id="canvas" width="320" height="240"></canvas>
              <button class="btn btn-primary btn-flat btn-md" style="margin-top: 10px; margin-bottom: 10px;" id="click-photo">Capture Image</button>
            </div>
            <form method="POST" action="index.php" id="attendance_info">
              <input type="text" name="attndnce_img" id="attndnce_img" hidden>
              <div class="form-group">
                <label for="status">Attendance</label>
                <select class="form-control " name="status" required>
                  <option value="in">Time In</option>
                  <option value="out">Time Out</option>
                </select>
              </div>
				<label for="exampleFormControlSelect1">Select Employee</label>
				<select class="form-control" name="employee" id="exampleFormControlSelect1">
					<option value="0">Employees</option>
					<?php 
						foreach (Employee::allBySupervisor($_SESSION['admin']) as $employee) {
							?>  
								<option value="<?= $employee['employee_id'] ?>">
								<?= "{$employee['employee_id']} - {$employee['firstname']}" ?>
								</option>
							<?php
						}
						?>
				</select>
              <div class="row mt-3">
                <div class="col-12">
                  <button type="submit" class="btn btn-primary btn-block btn-flat" name="signin"><i class="fa fa-sign-in"></i> Save</button>
                </div>
              </div>
            </form>
            
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
<!-- Toastr -->
<script src="../plugins/toastr/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datejs/1.0/date.min.js"></script>
<script type="text/javascript"> 
  function display_c(){
    var refresh=1000; // Refresh rate in milli seconds
    mytime=setTimeout('display_ct()',refresh)
  }

  function display_ct() {
    const today = new Date()
    let weekdays = new Array(7);
    weekdays[0] = "Sunday";
    weekdays[1] = "Monday";
    weekdays[2] = "Tuesday";
    weekdays[3] = "Wednesday";
    weekdays[4] = "Thursday";
    weekdays[5] = "Friday";
    weekdays[6] = "Saturday";
    const monthNames = ["January", "February", "March", "April", "May", "June",
      "July", "August", "September", "October", "November", "December"
    ];
    let dayOfWeek = weekdays[today.getDay()];
    let todayDate = monthNames[today.getMonth()]+ " " + today.getDate() + ", " + today.getFullYear()
    
    var hours = today.getHours();
    var minutes = today.getMinutes();
    var seconds = today.getSeconds();
    var ampm = hours >= 12 ? 'pm' : 'am';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    minutes = minutes < 10 ? '0'+minutes : minutes;
    seconds = seconds < 10 ? '0'+seconds : seconds;
    var strTime = hours + ':' + minutes + ':' + seconds;

    document.getElementById('dayOfweek').innerHTML = dayOfWeek;
    document.getElementById('dateToday').innerHTML = todayDate;
    document.getElementById('currentTime').innerHTML = strTime;
    document.getElementById('ampm').innerHTML = ampm;
    display_c();
  }

  let camera_button = document.querySelector("#start-camera");
  let video = document.querySelector("#video");
  let click_button = document.querySelector("#click-photo");
  let canvas = document.querySelector("#canvas");
  video.style.display = "none";

  camera_button.addEventListener('click', async function() {
    video.style.display = "block";
    let stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false });
    video.srcObject = stream;
    click_button.style.display = "block";
    camera_button.style.display = "none";
  });

  click_button.addEventListener('click', async function() {
      canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
      let image_data_url = canvas.toDataURL('image/jpeg');
      let stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false });
      video.srcObject = stream;
      stream.getVideoTracks()[0].stop();
      video.style.display = "none";
      canvas.style.display = "block";
      click_button.style.display = "none";
      document.getElementById('attndnce_img').value = image_data_url;

  });

  $('#attendance_info').submit(function(e){
    e.preventDefault();
    var attendance_info = $(this).serialize();
    $.ajax({
      type: 'POST',
      url: 'add_attendance.php',
      data: attendance_info,
      dataType: 'json',
      success: function(response){
        if(response.error){
          toastr.error(response.message);
        }
        else{
          toastr.success(response.message);
          $('#employee').val('');
        }
      }
    });
  });
</script>
</body>
</html>
