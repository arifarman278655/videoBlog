<?php
include 'inc/header.php';
?>
<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <?php include 'inc/Sidebar.php'; ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <?php include 'inc/top_bar.php'; ?>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800"><?php $helper->getTitle(); ?></h1>
                    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                </div>

                <hr/>
                <div class="row">
                    <div class="col-4 offset-4">
                        <?php
                        if (isset($_REQUEST['submit'])) {

                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                                $permited = array('jpg', 'jpeg', 'png', 'gif');

                                $file_name = $_FILES['photo']['name'];
                                // $file_size = $_FILES['photo']['size'];
                                $file_temp = $_FILES['photo']['tmp_name'];
                                $div = explode('.', $file_name);
                                $file_ext = strtolower(end($div));

                                if (!in_array($file_ext, $permited)) {
                                    echo "File Extention Invalid";
                                    exit();
                                }
                                $pathname = $con->gen_uuid();
                                $unique_image = $pathname . '.' . $file_ext;
                                $uploaded_image = "assets/img/content/" . $unique_image;
                                ?>
                                <div class="alert alert-success"><?php echo $con->addContent($_POST, $file_temp, $uploaded_image); ?>
                                    <button type="button" class="close" data-dismiss="alert"><span
                                                aria-hidden="true">×</span></button>
                                </div>
                            <?php } else { ?>
                                <div class="alert alert-danger">Request Method Invalid!</div>
                            <?php }
                        } ?>


                        <form class="user" action="" method="POST" enctype="multipart/form-data">
                            <div class="form-group row">
                                <div class="col-sm-12 mb-3 mb-sm-0">
                                    <input type="text" class="form-control" name="title" id="exampleFirstName"
                                           placeholder="title" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <?php $results = $con->getData("categories"); ?>
                                    <select class="form-control" name="cat_id" id="" required>
                                        <option value="">Select Category</option>
                                        <?php foreach ($results as $result) { ?>
                                            <option value="<?php echo $result['id']; ?>"><?php echo $result['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12 mb-3 mb-sm-0">
                                    <input type="text" class="form-control" name="short_desc" id="exampleFirstName"
                                           placeholder="Sort Description" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12 mb-3 mb-sm-0">
                                    <textarea id="" cols="40" rows="3" name="long_desc"
                                              placeholder="Long Description" required></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12 mb-3 mb-sm-0">
                                    <input type="text" class="form-control" name="tag" required id="exampleFirstName"
                                           placeholder="tag">
                                </div>
                            </div>
                            <div class="form-group row">
                                <input type="file" class="" name="photo" id="exampleFirstName"
                                       placeholder="Photo" required>
                            </div>


                            <input type="submit" class="btn btn-primary btn-user" name="submit" value="Add Category"/>
                        </form>
                    </div>
                </div>


            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <?php include 'inc/footer.php'; ?>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->


<!-- Bootstrap core JavaScript-->
<script src="assets/css/vendor/jquery/jquery.min.js"></script>
<script src="assets/css/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="assets/css/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="assets/css/vendor/chart.js/Chart.min.js"></script>

<!-- Page level custom scripts -->
<script src="js/demo/chart-area-demo.js"></script>
<script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>