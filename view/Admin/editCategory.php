<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("../layout/head.php"); ?>
</head>
<?php

require("../../services/services.php");
require("../../db/connection.php");
require("../../services/serviceAdmin.php");

if (!isset($_SESSION['account'])) {
    header('location:../../index.php');
    exit;
}
if ($_SESSION['account'][key($_SESSION['account'])] == 1) : ?>
    <?php
    // require("../../db/connection.php");
    $category = mysqli_fetch_assoc(getCategoryByIDAdmin($conn, $_GET['id']));

    $result = get_categorys_list($conn);
    while ($row = mysqli_fetch_assoc($result)) {
        $categorys_list[] = $row;
    }



    ?>



    <body>
        <div class="wrapper">
            <div class="sidebar" data-image="/php_basic_2/assets/img/sidebar-5.jpg">
                <div class="sidebar-wrapper">
                    <?php include("../layout/sidebarAdmin.php"); ?>
                </div>
            </div>
            <div class="main-panel">
                <!-- Navbar -->
                <nav class="navbar navbar-expand-lg " color-on-scroll="500">
                    <div class="container-fluid">
                        <?php include("../layout/navbar.php"); ?>
                    </div>
                </nav>
                <!-- End Navbar -->
                <div class="content">
                    <div class="container-fluid">
                        <div class="card-body">
                            <form action="../../services/serviceAdmin.php?action=updateCategory" method="POST">

                                <div class="row">
                                    <div class="col-md-6 pr-1">
                                        <div class="form-group">
                                            <label>Name category</label>
                                            <input type="text" name="category_name" placeholder="Tên danh mục" value="<?php echo $category['category_name']  ?>" class="form-control">
                                            <input type="hidden" name="id" value="<?php echo $category['id']  ?>" class="form-control">

                                        </div>
                                    </div>
                                    <div class="col-md-6 px-1">
                                        <div class="form-group">
                                            <label>Category</label>
                                            <select name="parent_ID" class="form-control">
                                                <option value="0">Danh mục cha</option>
                                                <?php showCategoriesAU_edit($categorys_list, $category['parent_ID']); ?>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group m-4">
                                    <label> Kích hoạt</label>
                                    <div class="form-group">

                                        <div class="custom-control custom-radio">
                                            <input value="1" type="radio" id="active" <?php if ($category['active'] == 1)  echo 'checked'; ?> name="active">
                                            <label style="margin-left:10px ;" for="active" class="custom-control-label">Có</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input value="0" type="radio" id="no_active" <?php if ($category['active'] == 0)  echo 'checked'; ?> name="active">
                                            <label style="margin-left:10px ;" for="no_active" class="custom-control-label">Không</label>
                                        </div>
                                    </div>
                                </div>


                                <button type="submit" class="btn btn-info btn-fill pull-right">Sửa</button>
                                <div class="clearfix"></div>
                            </form>
                        </div>

                    </div>
                </div>
                <footer class="footer">
                    <?php include("../layout/footer.php"); ?>
                </footer>
            </div>
        </div>

    </body>
<?php else : ?>

    <body>
        <h1>

            Tài khoản admin mới có thể truy cập!

        </h1>
    </body>

<?php endif; ?>


</html>