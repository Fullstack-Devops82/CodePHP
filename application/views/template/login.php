<!DOCTYPE html>
<html dir='ltr'>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url(); ?>assets/images/favicon.png">
    <title>DevOps</title>
    <!-- Custom CSS -->
    <!-- <link href="<?php echo base_url(); ?>assets/libs/jquery-modal/jquery.modal.css" rel="stylesheet"> -->
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <div class="main-wrapper">
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <div class="bs-example">
            <div class="auth-wrapper d-flex no-block justify-content-center
                    align-items-center bg-dark">
                <div class="auth-box bg-dark border-top border-secondary">
                    <div id="loginform">
                        <div class="text-center p-t-20 p-b-20">
                            <span class="db"><img src="<?php echo base_url(); ?>assets/images/logo.png" alt="logo" /></span>
                        </div>
                        <!-- Form Start-->
                        <?php echo $view_content; ?>
                        <!-- Form End-->
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="myAlertModal" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Alert</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>This is a small modal.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-close btn
                                btn-default"
                            data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="myConfirmModal" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Confirm</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>This is a small modal.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-close btn
                                btn-default"
                            data-dismiss="modal">Close</button>
                        <button type="button" class="btn-confirm btn
                                btn-success save-event waves-effect
                                waves-light">Confirm</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="notification-container">

        </div>
    </div>
    <script src="<?php echo base_url(); ?>assets/libs/jquery/dist/jquery.min.js">
    </script>
    <script src="<?php echo base_url(); ?>assets/libs/popper.js/dist/umd/popper.min.js">
    </script>
    <script src="<?php echo base_url(); ?>assets/libs/bootstrap/dist/js/bootstrap.min.js">
    </script>
    <script src="<?php echo base_url(); ?>assets/js/pages/common.js">
    </script>
    <?php if (!is_null($js_path)) {?>
    <script src="<?php echo base_url(); ?>assets/js/pages/<?php echo $js_path; ?>">
    </script>
    <?php }?>

    <script>
        var base_url = '<?php echo base_url(); ?>';
        $(document).ready(function() {
            <?php if (!is_null($msg)) {echo "showAlertModal('" . $msg . "');";}?>
        });

        $(".preloader").fadeOut();
    </script>
</body>

</html>