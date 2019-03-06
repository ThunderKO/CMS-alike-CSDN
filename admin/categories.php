<!DOCTYPE html>
<html lang="en">

<?php include "includes/admin_header.php" ?>

<body>

    <div id="wrapper">

        <?php include "includes/admin_navigation.php" ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to Admin Page
                            <small>Author</small>
                        </h1>
                        <!-- custom form for adding categories -->
                        <div class="col-xs-6">
                            <!-- insert categories data operation to db -->
                            <?php
                                insert_categories();
                            ?>
                            <!-- /.insert categories data operation to db -->
                            <!-- form for adding categories -->
                            <form action="" method="post">
                                <div class="form-gourp">
                                    <label for="cat-title">Add Category</label>
                                    <input type="text" name="cat_title" class="form-control">
                                </div>
                                <div class="form-gourp">
                                    <input type="submit" name="submit" value="Add Category" class="btn btn-primary">
                                </div>
                            </form>
                            <!-- form for updating categories -->
                            <?php 
                                if(isset($_GET['edit'])) {
                                    $cat_id = $_GET['edit'];
                                    include "includes/update_categories.php" ;
                                }
                            ?>
                        </div>
                        <div class="col-xs-6">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Category Title</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- fetching categories table data in db -->
                                    <?php
                                        fetch_all_categories();
                                    ?>
                                    <!-- /.fetching categories table data in db -->
                                    <!-- delete categories data operation to db -->
                                    <?php
                                        delete_categories();
                                    ?>
                                    <!-- /.delete categories data operation to db -->
                                </tbody>
                            </table>
                        </div>
                        <!-- /.custom form for adding categories -->
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <?php include "includes/admin_footer.php" ?>

</body>

</html>
