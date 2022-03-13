<?php 
session_start();
require_once('./Helpers/Deduction.php');

if (isset($_POST['add'])) 
{
    $description = $_POST['description'];
    $amount = (float) $_POST['amount'];

    $isCreated = Deduction::create($description, $amount);

    $isCreated 
        ? $_SESSION['success'] = 'Deduction created successfully.'
        : $_SESSION['error'] = 'Deduction create failed.';

    header('location: deductions.php');
}

if (isset($_GET['action']) && $_GET['action'] === 'edit') 
{
    $id = $_POST['id'];

    echo json_encode(Deduction::find($id));
}

if (isset($_POST['update'])) 
{
    $id = (int) $_POST['id'];
    $description = $_POST['description'];
    $amount = $_POST['amount'];

    $isUpdated = Deduction::update($id, $description, $amount);

    if (! $isUpdated) {
        $_SESSION['error'] = 'Deduction update failed.';
    }

    if ($isUpdated) {
        $_SESSION['success'] = 'Deduction updated successfully.';
    }

    header('location: deductions.php');
}

if (isset($_POST['delete'])) 
{
    $id = (int) $_POST['id'];

    $isDestroyed = Deduction::delete($id);

    $isDestroyed 
        ? $_SESSION['success'] = 'Deduction deleted successfully.'
        : $_SESSION['error'] = 'Deduction delete failed.';

    header('location: deductions.php');
}