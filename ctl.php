
<?php $INC_DIR = $_SERVER["DOCUMENT_ROOT"] . "/includes";?>
<?php require_once "$INC_DIR/header.php"; ?>
<?php require_once "$INC_DIR/functions.php"; ?>

<!-- Custom page content -->
<div class="row top-margin-row" >
    <div class="row-fluid">
        <div class="col-md-6 col-md-offset-3 margin-bottom-form">
            <form id="<?php echo !isset($_FILES['file']['name']) == "" ? 'form-hide' : ''; ?>" class="bs-example form-horizontal" method="post" enctype='multipart/form-data' action="<?php echo "ctl.php" ?>" >
                <div class="panel-group">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <b>Delete CTL File</b>
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse in">
                            <div class="panel-body">
                                <div class="well">
                                    <fieldset>
                                        <legend class="text-center">Load a List of Device Names</legend>
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label text-warning margin-left-editD text-center">Search For File:</label>
                                            <div class="col-lg-6">
                                                <input id="file" type='file' name='file'>
                                                <input id="upload" type='submit' name='submit' value='Upload File Now'>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <?php if ($_FILES): ?>
                <?php if (!$_FILES['file']['name'] == ""): ?>
                    <table id='upi' class="table table-striped table-hover">
                        <thead>
                        <th>Device Name</th>
                        <th>Status</th>
                        <th>Message</th>
                        <th>Code</th>
                        </thead>
                        <?php $csv = processCsv($_FILES); ?>
                        <?php foreach ($csv as $row): ?>
                            <?php if ($row == ''): ?>
                                <? continue; ?>
                            <?php endif ?>
                            <tr class="requestRowDescription">
                                <td class="device"><?php echo "$row[0]"; ?></td>
                                <td class="status"></td>
                                <td class="message"></td>
                                <td class="code"></td>
                            </tr>
                        <?php endforeach ?>
                    </table>
                <?php else: ?>
                    <h2 class="text-center text-primary">No File Selected</h2>
                    <a href="ctl.php">Go Back</a>
                <?php endif ?>
            <?php endif ?>
        </div>
    </div>
</div>

<?php require_once "$INC_DIR/footer.php";
