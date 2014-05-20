<?php $INC_DIR = $_SERVER["DOCUMENT_ROOT"] . "/includes";?>
<?php require_once "$INC_DIR/header.php"; ?>
<?php require_once "$INC_DIR/functions.php"; ?>
<!-- Custom page content -->

<!-- Access Restrictions -->
<?php if ($_SESSION['role'] == '2') { header('Location:  401.php'); } ?>

<div class="row top-margin-row <?php echo $_SERVER['REQUEST_METHOD'] == 'POST' ? 'hide' : 'show'; ?>" >
    <div class="row-fluid">
        <div class="col-md-6 col-md-offset-3 margin-bottom-form">
            <form class="bs-example form-horizontal" method="post" action="<?php echo "addAdmin.php" ?>" >
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <b>Add New User</b>
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse in">
                            <div class="panel-body">
                                <div class="well">
                                    <fieldset>
                                        <div class="form-group">
                                            <label class="col-md-4 text-warning" for="textArea">
                                                Username
                                            </label>
                                            <div class="col-lg-8">
                                                <input name="user_name" id="inputSmall" class="form-control input-sm" type="text" placeholder='username'/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 text-warning" for="textArea">
                                                First Name
                                            </label>
                                            <div class="col-lg-8">
                                                <input name="first_name" id="inputSmall" class="form-control input-sm" type="text" placeholder='first name'/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 text-warning" for="textArea">
                                                Last Name
                                            </label>
                                            <div class="col-lg-8">
                                                <input name="last_name" id="inputSmall" class="form-control input-sm" type="text" placeholder='last name'/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 text-warning" for="select">
                                                User Role
                                            </label>
                                            <div class="col-lg-8">
                                                <select name="role">
                                                    <option value="">Select</option>
                                                    <option value="1">Admin</option>
                                                    <option value="2">Support</option>
                                                </select>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-md-9 col-md-offset-1 top-buffer-col text-right ">
                                    <button type="submit" class="btn btn-success">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
<div class="row top-margin-index">
    <div class="col-md-6 col-md-offset-3 text-left top-margin-index-logo">
        <div class="panel-group">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <b>Add New User: <b class="text-warning">RESULTS</b>
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <div class="well">
                            <?php addAdmin($_POST['user_name'],$_POST['first_name'],$_POST['last_name'],$_POST['role']); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif ?>
<?php require_once "$INC_DIR/footer.php";