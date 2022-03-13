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

    <?php include('./includes/navbar.php') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <?php
        if(isset($_SESSION['error']))
        {
            echo "
                <div class='alert alert-danger alert-dismissible'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                    <h4><i class='icon fa fa-warning'></i> Error!</h4>
                    ".$_SESSION['error']."
                </div>
            ";

            unset($_SESSION['error']);
        }
        
        if(isset($_SESSION['success']))
        {
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
                    <th>Name</th>
                    <th>Amount</th>
                  </thead>
                  <tbody>
                    <?php
                      $sql = "SELECT * FROM deductions";
                      $query = $conn->query($sql);
                      while($row = $query->fetch_assoc()){
                        echo "
                          <tr>
                            <td class='text-capitalize'>".$row['description']."</td>
                            <td>".number_format($row['amount'], 2)."</td>
                            <td>
                              <button class='btn btn-success btn-sm edit btn-flat' data-id='".$row['id']."'><i class='fa fa-edit'></i> Edit</button>
                              <button class='btn btn-danger btn-sm delete btn-flat' data-id='".$row['id']."'><i class='fa fa-trash'></i> Delete</button>
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
            <h4 class="modal-title"><b>Add Deduction</b></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form class="form-horizontal" method="POST" action="deduction_crud.php">
            <div class="modal-body">
                <div class="form-group">
                    <label for="description" class="col-sm-3 control-label">Description</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control text-capitalize" id="description" name="description" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="amount" class="col-sm-3 control-label">Amount</label>
                    <div class="col-sm-9">
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
              <h4 class="modal-title"><b>Update Deduction</b></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="form-horizontal" method="POST" action="deduction_crud.php">
              <div class="modal-body">
              <input type="hidden" class="edit-id" name="id">
              <div class="form-group">
                <label for="description_edit" class="col-sm-3 control-label">Description</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control text-capitalize edit-description" id="description_edit" name="description">
                </div>
              </div>
              <div class="form-group">
                <label for="edit_amount" class="col-sm-3 control-label">Amount</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control edit-amount" id="edit_amount" name="amount">
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
              <button type="submit" class="btn btn-success btn-flat" name="update"><i class="fa fa-check-square-o"></i> Update</button>
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
                  <h4 class="modal-title"><b>Deleting...</b></h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form action="./deduction_crud.php" method="post">
                    <div class="modal-body">
                        <input type="hidden" class="delete-id" name="id">
                        <div class="text-center">
                            <p>Delete deduction?</p>
                            <h2 id="del_position" class="bold text-capitalize"></h2>
                        </div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                    <button type="submit" class="btn btn-danger btn-flat delete-submit-btn" name="delete"><i class="fa fa-trash"></i> Delete</button>
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
$(function() 
{
    $('.edit').click(function(e)
    {
        e.preventDefault();

        $('#edit').modal('show');
        const id = $(this).data('id');

        $.ajax({
            type: 'POST',
            url: 'deduction_crud.php?action=edit',
            data: { id },
            success: function(response)
            {
                const {
                    id,
                    description,
                    amount
                } = JSON.parse(response);

                $('.edit-id').val(id);
                $('.edit-description').val(description);
                $('.edit-amount').val(amount);
            }
        });
    });

    $('.delete').click(function(e)
    {
        e.preventDefault();

        $('#delete').modal('show');
        const id = $(this).data('id');

        $('.delete-id').val(id);
    });
});
</script>
</body>
</html>
