<?php
	include 'session.php';
    $supervisor_id = "";

	if(isset($_POST['add'])){
		$firstname = ucwords($_POST['firstname']);
		$lastname = ucwords($_POST['lastname']);
        $fullname = $firstname.$lastname;
		$address = $_POST['address'];
		$birthdate = $_POST['birthdate'];
		$contact = $_POST['contact'];
		$gender = $_POST['gender'];
		$filename = $_FILES['photo']['name'];
		if(!empty($filename)){
			move_uploaded_file($_FILES['photo']['tmp_name'], '../images/'.$filename);	
		}

        $password = password_hash($firstname, PASSWORD_DEFAULT);

        echo $password;

		$sql = "INSERT INTO supervisors (firstname, lastname, address, birthdate, contact_info, gender, photo, created_on, password) 
                VALUES ('$firstname', '$lastname', '$address', '$birthdate', '$contact', '$gender', '$filename', NOW(), '$password')";
		if($conn->query($sql)){
            $last_id = mysqli_insert_id($conn);
            $year = date("Y");
            if($last_id < 10){
                $employee_id = $year."-0000".$last_id;
            }elseif ($last_id < 100) {
                $employee_id = $year."-000".$last_id;
            }elseif ($last_id < 1000) {
                $employee_id = $year."-00".$last_id;
            }elseif ($last_id < 10000) {
                $employee_id = $year."-0".$last_id;
            }else{
                $employee_id = $year."-".$last_id;
            }

            $sql = "UPDATE supervisors SET employee_id='$employee_id' WHERE id=$last_id";

            if (mysqli_query($conn, $sql)) {
                $_SESSION['success'] = 'Supervisor added successfully';
            }else{
                $_SESSION['error'] = $conn->error;
            }
		}
		else{
			$_SESSION['error'] = $conn->error;
		}

	}
	else{
		$_SESSION['error'] = 'Fill up add form first';
	}

	header('location: supervisors.php');
?>