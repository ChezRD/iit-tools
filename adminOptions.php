
<?php $INC_DIR = $_SERVER["DOCUMENT_ROOT"] . "/includes";?>
<?php require_once "$INC_DIR/header.php"; ?>
<?php require_once "$INC_DIR/functions.php"; ?>
<!-- Custom page content -->

<div class="row top-margin-row" >
    <div class="row-fluid">
        <div class="col-md-6 col-md-offset-3 margin-bottom-form">
            <form class="bs-example form-horizontal" method="post" action="<?php echo "do-updateAdmin.php" ?>" >
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <b>Change Password</b>
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse in">
                            <div class="panel-body">
                                <div class="well">
                                    <fieldset>
                                        <div class="form-group">
                                            <label class="col-md-4 text-warning" for="textArea">
                                                New Password
                                            </label>
                                            <div class="col-lg-8">
                                                <input name="new_pass" id="inputSmall" class="form-control input-sm" type="password" ></input>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 text-warning" for="textArea">
                                                Confirm New Password
                                            </label>
                                            <div class="col-lg-8">
                                                <input name="confirm_pass" id="inputSmall" class="form-control input-sm" type="password" ></input>
                                            </div>
                                        </div>
                                        <input name="user_name" id="inputSmall" class="form-control input-sm" type="hidden" value="<?php echo $_GET['username'] ?>"></input>
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

<?php require_once "$INC_DIR/footer.php";