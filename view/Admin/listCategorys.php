<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("../layout/head.php"); ?>
</head>
<?php
session_start();
if (!isset($_SESSION['account'])) {
    header('location:../../index.php');
    exit;
}
if ($_SESSION['account'][key($_SESSION['account'])] == 1) : ?>
    <?php
    require("../../db/connection.php");
    require("../../services/serviceAdmin.php");
    // $categorys_list = get_categorys_list($conn);
    // $accounts = getNameAccount($conn);

    $result = get_categorys_list($conn);
    while ($row = mysqli_fetch_assoc($result)) {
        $categorys_list[] = $row;
    }


    $noupdate = 'onclick="noupdate();"';

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
                        <?php if (isset($_SESSION['success'])) : ?>
                            <p style="color: green;"><?php echo $_SESSION['success'];  ?></p>
                            <?php unset($_SESSION['success']); ?>
                        <?php endif; ?>
                        <div class="row">
                            <div class="col-md-1 px-1">
                                <a href="addCategory.php" class="btn btn-info btn-fill pull-left">Thêm</a>
                            </div>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID category</th>
                                    <th scope="col">Name category</th>
                                    <th scope="col">Status</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php listCategorys($categorys_list)  ?>
                                <?php mysqli_close($conn); ?>

                            </tbody>
                        </table>
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


<!--  Notifications Plugin    -->

<script>
    function deleteCategoryAdmin(id) {
        var accept = confirm('Xác nhận xóa sản phẩm này?');
        if (accept) {
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "../../services/serviceAdmin.php?action=deleteCategory",
                data: {
                    id
                },
                success: function(result) {
                    if (result.code == 200) {
                        $('#category_' + result.id).remove();
                        alert(result.message);
                    } else {
                        alert(result.message);
                    }

                }
            });
        }

    }
</script>


</html>