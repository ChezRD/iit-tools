
<?php $INC_DIR = $_SERVER["DOCUMENT_ROOT"] . "/includes";?>
<?php require_once "$INC_DIR/header.php"; ?>
<?php require_once "$INC_DIR/functions.php"; ?>
<?php require_once "includes/AxlClass.php"; ?>

<!-- Custom page content -->
<div class="row top-margin-row" >
    <div class="row-fluid">
        <div class="col-md-6 col-md-offset-3 margin-bottom-form">
            <form id="<?php echo $_FILES ? 'form-hide' : ''; ?>" class="bs-example form-horizontal" method="get" enctype='multipart/form-data' action="<?php echo "adminTestAxl.php" ?>" >
                <div class="panel-group">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <b>Test AXL Connection</b>
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse in">
                            <div class="panel-body">
                                <div class="well">
                                    <fieldset>
                                        <input type="hidden" name="testaxl" />
                                        <?php $servers = array('WAS' => array('10.178.8.1','8443'),'CDG' => array('127.0.0.1','9110'), 'MAA' => array('127.0.0.1','9111')); ?>
                                        <?php //$servers = array('LAB' => array('192.168.158.10','8443')); ?>
                                        <?php foreach($servers as $key => $value): ?>
                                            <?php $axl = new AxlClass($value[0],$value[1]); ?>
                                            <?php $res = $axl->getVersion(); ?>
                                            <?php if (isset($res->return->componentVersion->version)): ?>
                                                <h3 class="text-success text-center">Connected to <?php echo $key; ?>!</h3>
                                            <?php else : ?>
                                                <h3 class="text-danger text-center">Not Connected to <?php echo $key; ?></h3>
                                            <?php endif ?>
                                        <?php endforeach ?>
                                    </fieldset>
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
