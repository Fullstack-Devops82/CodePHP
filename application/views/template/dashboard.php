<!DOCTYPE html>
<html dir="ltr" lang="en">
<?php $tag = isset($tag) ? $tag : array();?>

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
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/libs/select2/dist/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/libs/jquery-minicolors/jquery.minicolors.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/libs/quill/dist/quill.snow.css">

    <?php if (in_array("table", $tag)) {?>
    <link href="<?php echo base_url(); ?>assets/extra-libs/DataTables/datatables.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/extra-libs/DataTables/buttons.dataTables.min.css" rel="stylesheet">
    <!-- <link href="<?php echo base_url(); ?>assets/extra-libs/DataTables/select.dataTables.min.css"
    rel="stylesheet"> -->
    <link href="<?php echo base_url(); ?>assets/extra-libs/DataTables/editor.dataTables.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/responsive.bootstrap4.css" rel="stylesheet" type="text/css">
    <?php }?>
    <?php if (in_array("jcrop", $tag)) {?>
    <link href="<?php echo base_url(); ?>assets/css/jquery.Jcrop.css" rel="stylesheet" type="text/css">
    <?php }?>
    <link href="<?php echo base_url(); ?>assets/libs/magnific-popup/dist/magnific-popup.css" rel="stylesheet">

    <link href="<?php echo base_url(); ?>assets/css/style.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/common.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar" data-navbarbg="skin5">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header" data-logobg="skin5">
                    <!-- This is for the sidebar toggle which is visible on mobile only -->
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
                            class="ti-menu ti-close"></i></a>
                    <!-- ============================================================== -->
                    <!-- Toggle which is visible on mobile only -->
                    <!-- ============================================================== -->
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                        data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-left mr-auto">
                        <li class="nav-item d-none d-md-block"><a class="nav-link sidebartoggler waves-effect waves-light"
                                href="javascript:void(0)" data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a></li>
                    </ul>
                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-right">
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href=""
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?php echo base_url(); ?>assets/images/users/1.jpg"
                                    alt="user" class="rounded-circle" width="31"></a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated">
                                <!-- <a class="dropdown-item" href="<?php echo base_url(); ?>user/profile"><i class="ti-user m-r-5 m-l-5"></i>
                                    My Profile</a>
                                <div class="dropdown-divider"></div> -->
                                <a class="dropdown-item" href="<?php echo base_url(); ?>login/logout"><i class="fa fa-power-off m-r-5 m-l-5"></i>
                                    Logout</a>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar" data-sidebarbg="skin5">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav" class="p-t-30">
                        <?php if (USER_TYPE_ADMIN == $data['level']) {?>
                        <!-- <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo base_url(); ?>admin/userlist"
                                aria-expanded="false"><i class="mdi mdi-account-key"></i><span class="hide-menu">User
                                    List</span></a></li> -->
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo base_url(); ?>admin/userlist"
                                aria-expanded="false"><i class="mdi mdi-account"></i><span class="hide-menu">Users List</span></a></li>
                                
                        <?php } else {?>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo base_url(); ?>admin/welcome"
                                aria-expanded="false"><i class="mdi mdi-blur-linear"></i><span class="hide-menu">Welcome</span></a></li>
                        <?php }?>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <h4 class="page-title">
                            <?php echo $title; ?>
                        </h4>
                        <!-- <div class="ml-auto text-right">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Library</li>
                                </ol>
                            </nav>
                        </div> -->
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->

            <!-- ============================================================== -->
            <!-- Start Page Content -->
            <!-- ============================================================== -->
            <?php echo $view_content; ?>
            <!-- ============================================================== -->
            <!-- End Page Content -->
            <!-- ============================================================== -->

            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center">
                All Rights Reserved by admin. Designed and Developed by <a href="http://localhost">DevOps</a>.
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
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
                    <button type="button" class="btn-close btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="myConfirmModal" role="dialog">
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
                    <button type="button" class="btn-close btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn-confirm btn btn-success save-event waves-effect waves-light">Confirm</button>
                </div>
            </div>
        </div>
    </div>
    <div class="notification-container">

    </div>

    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="<?php echo base_url(); ?>assets/libs/jquery/dist/jquery.min.js">
    </script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?php echo base_url(); ?>assets/libs/popper.js/dist/umd/popper.min.js">
    </script>
    <script src="<?php echo base_url(); ?>assets/libs/bootstrap/dist/js/bootstrap.min.js">
    </script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="<?php echo base_url(); ?>assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js">
    </script>
    <script src="<?php echo base_url(); ?>assets/extra-libs/sparkline/sparkline.js">
    </script>
    <!--Wave Effects -->
    <script src="<?php echo base_url(); ?>assets/js/waves.js">
    </script>
    <!--Menu sidebar -->
    <script src="<?php echo base_url(); ?>assets/js/sidebarmenu.js">
    </script>
    <!--Custom JavaScript -->
    <script src="<?php echo base_url(); ?>assets/js/custom.min.js">
    </script>
    <!-- This Page JS -->
    <script src="<?php echo base_url(); ?>assets/libs/inputmask/dist/min/jquery.inputmask.bundle.min.js">
    </script>
    <script src="<?php echo base_url(); ?>assets/js/pages/mask/mask.init.js">
    </script>
    <script src="<?php echo base_url(); ?>assets/libs/select2/dist/js/select2.full.min.js">
    </script>
    <script src="<?php echo base_url(); ?>assets/libs/select2/dist/js/select2.min.js">
    </script>
    <script src="<?php echo base_url(); ?>assets/libs/jquery-asColor/dist/jquery-asColor.min.js">
    </script>
    <script src="<?php echo base_url(); ?>assets/libs/jquery-asGradient/dist/jquery-asGradient.js">
    </script>
    <script src="<?php echo base_url(); ?>assets/libs/jquery-asColorPicker/dist/jquery-asColorPicker.min.js">
    </script>
    <script src="<?php echo base_url(); ?>assets/libs/jquery-minicolors/jquery.minicolors.min.js">
    </script>
    <script src="<?php echo base_url(); ?>assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js">
    </script>
    <script src="<?php echo base_url(); ?>assets/libs/quill/dist/quill.min.js">
    </script>

    <script src="<?php echo base_url(); ?>assets/libs/jquery-validation/dist/jquery.validate.min.js">
    </script>

    <?php if (in_array("table", $tag)) {?>
    <script src="<?php echo base_url(); ?>assets/extra-libs/DataTables/datatables.min.js">
    </script>
    <script src="<?php echo base_url(); ?>assets/extra-libs/DataTables/dataTables.buttons.min.js">
    </script>
    <!-- <script src="<?php echo base_url(); ?>assets/extra-libs/DataTables/dataTables.select.min.js"></script>
    -->
    <script src="<?php echo base_url(); ?>assets/extra-libs/DataTables/dataTables.editor.min.js">
    </script>
    <script src="<?php echo base_url(); ?>assets/js/dataTables.responsive.js">
    </script>
    <?php }?>
    <?php if (in_array("jcrop", $tag)) {?>
    <script src="<?php echo base_url(); ?>assets/js/jquery.Jcrop.js">
    </script>
    <?php }?>
    <script src="<?php echo base_url(); ?>assets/libs/magnific-popup/dist/jquery.magnific-popup.min.js">
    </script>
    <script src="<?php echo base_url(); ?>assets/libs/magnific-popup/meg.init.js">
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
            <?php
if (!is_null($msg)) {
    echo "showAlertModal('" . $msg . "');";
}
?>
        });
    </script>
    <!-- this is for "Setting" page -->

    <?php if (in_array("map", $tag)) {?>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCew_xAnG6EfMLke0go0fGxU9FA6wFAUrI&libraries=places&callback=initMap"
        async defer>
    </script>
    <?php }?>


</body>

</html>