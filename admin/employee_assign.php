<?php 
session_start();
require_once('./Helpers/Employee.php');

if (isset($_POST['assign_employee']))
{
    $employeeID = $_POST['employee_id'];
    $supervisorID = (int) $_POST['supervisor_id'];

    $isCreated = Employee::assignSupervisor(
        $employeeID, 
        $supervisorID
    );

    if ($isCreated) {
        $_SESSION['success'] = 'Employee assigned successfully.';
    }
    
    if (! $isCreated) {
        $_SESSION['error'] = 'Employee not assigned.';
    }

    header('location: employees.php');
}

if (isset($_GET['action']) && $_GET['action'] === 'reassign_employee')
{
    $employeeID = $_POST['employeeID'];
    $supervisorID = $_POST['supervisorID'];

    $isUpdated = Employee::switchSupervisor(
        $employeeID, 
        $supervisorID
    );

    if ($isUpdated) {
        $_SESSION['success'] = 'Employee reassigned successfully.';
    }
    
    if (! $isUpdated) {
        $_SESSION['error'] = 'Employee not reassigned.';
    }
}