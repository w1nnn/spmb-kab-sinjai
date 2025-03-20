<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!-- Required meta tags -->

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SPMB - Kabupaten Sinjai </title>

    <link rel="shortcut icon" href="<?= base_url() ?>assets/images/page-img/29.png" />
    <meta name="description" content="Selamat Datang Di Sistem Penerimaan Peserta Didik Baru Kabupaten Sinjai  ">
    <meta property='fb:app_id' content='1617259004961144' />
    <meta property='og:type' content='article' />
    <meta property='og:url' content='<?= base_url() ?>' />
    <meta property='og:title' content='Pendaftaran | Penerimaan Peserta Didik Baru Kabupaten Sinjai ' />
    <meta property='og:image' content='<?= base_url() ?>assets/landing/slide1.png' />
    <meta property='og:description' content='Selamat Datang Di Sistem Penerimaan Peserta Didik Baru Kabupaten Sinjai '>


    <meta name="theme-color" content="#037afb">
    <meta name="msapplication-navbutton-color" content="#037afb">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="#037afb">

    <link rel="stylesheet" href="<?= base_url() ?>assets/css/ppdb.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/typography.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/responsive.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/select2.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.min.css" rel="stylesheet">

    <script src="<?= base_url() ?>assets/js/jquery.min.js"></script>



    <style>
        .select2-container--default .select2-selection--single {
            background: #e9edf4;
            height: 40px;
            border: 0px;
            padding-top: 5px;
            width: 100%;
        }

        .bexcel {
            float: right;
            position: relative;
            top: 40px;
        }

        .form-list {
            margin-left: 1rem;
            margin-bottom: -3rem;
        }

        @media (max-width: 640px) {
            .navbar-list .utext {
                display: none;
            }
        }

        @media (max-width: 800px) {
            .navbar-list .utext {
                display: none;
            }

            .bexcel {
                float: none;
                top: 0;
                margin-bottom: 10px;
            }

            .form-list {
                margin-bottom: -0.5rem;
            }
        }
    </style>
</head>

<body>
    <div id="layer-main-wrap"></div>

    <!-- Wrapper Start -->
    <div class="wrapper">
        <!-- Sidebar  -->
        <?php include("partials/sidebar.php"); ?>
        <!-- TOP Nav Bar -->
        <?php include("partials/header.php"); ?>
        <!-- TOP Nav Bar END -->

        <!-- Page Content  -->
        <div id="content-page" class="content-page">
            <div class="container-fluid">
                <?php echo $contents; ?>
            </div>
        </div>

    </div>
    <!-- Wrapper END -->
    <!-- Footer -->
    <footer class="bg-white iq-footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 ">
                    Copyright &copy <?php echo date('Y') ?> <a href="#">SPMB Kabupaten Sinjai</a>. All Rights Reserved.
                </div>
                <div class="col-lg-6 text-right">
                    Sistem Aplikasi SPMB Versi 2.0
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer END -->

    <script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>assets/js/popper.min.js"></script>
    <!-- Appear JavaScript -->
    <script src="<?= base_url() ?>assets/js/jquery.appear.js"></script>
    <!-- Countdown JavaScript -->
    <script src="<?= base_url() ?>assets/js/countdown.min.js"></script>
    <!-- Counterup JavaScript -->
    <script src="<?= base_url() ?>assets/js/waypoints.min.js"></script>
    <script src="<?= base_url() ?>assets/js/jquery.counterup.min.js"></script>
    <!-- Wow JavaScript -->
    <script src="<?= base_url() ?>assets/js/wow.min.js"></script>
    <!-- Apexcharts JavaScript -->
    <script src="<?= base_url() ?>assets/js/apexcharts.js"></script>
    <!-- Slick JavaScript -->
    <script src="<?= base_url() ?>assets/js/slick.min.js"></script>
    <!-- Select2 JavaScript -->
    <script src="<?= base_url() ?>assets/js/select2.min.js"></script>
    <!-- Owl Carousel JavaScript -->
    <script src="<?= base_url() ?>assets/js/owl.carousel.min.js"></script>
    <!-- Magnific Popup JavaScript -->
    <script src="<?= base_url() ?>assets/js/jquery.magnific-popup.min.js"></script>
    <!-- Smooth Scrollbar JavaScript -->
    <script src="<?= base_url() ?>assets/js/smooth-scrollbar.js"></script>
    <!-- lottie JavaScript -->
    <script src="<?= base_url() ?>assets/js/lottie.js"></script>
    <!-- Chart Custom JavaScript -->
    <script src="<?= base_url() ?>assets/js/chart-custom.js"></script>
    <!-- Custom JavaScript -->
    <script src="<?= base_url() ?>assets/js/custom.js"></script>

    <script src="<?= base_url() ?>assets/js/select2.full.js"></script>
    <script src="<?= base_url() ?>assets/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>assets/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?= base_url() ?>assets/js/toastr.min.js"></script>


    <?= notification() ?>


    <script>
        function goBack() {
            window.history.back();
        }

        $(document).ready(function() {
            toastr.options = {
                'closeButton': true,
                'debug': false,
                'newestOnTop': false,
                'progressBar': true,
                'positionClass': 'toast-bottom-right',
                'preventDuplicates': false,
                'showDuration': '1000',
                'hideDuration': '1000',
                'timeOut': '4000',
                'extendedTimeOut': '1000',
                'showEasing': 'swing',
                'hideEasing': 'linear',
                'showMethod': 'fadeIn',
                'hideMethod': 'fadeOut',
            }
        });

        $(document).ready(function() {
            $('.dataTables_filter input[type="search"]').css({
                'width': '800px',
                'display': 'inline-block',
                'margin-left': '0px',
                'height': '40px'
            });
        });

        $(document).ready(function() {
            $(".select2").select2();
            $(".select2-multi").select2();

        });
    </script>



</html>