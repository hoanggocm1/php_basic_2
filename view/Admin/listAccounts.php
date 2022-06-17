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
    $account_list = getListAccouts($conn);
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
                        <!-- <a href="addProduct.php" class="btn btn-info btn-fill pull-left">Thêm</a> -->
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID account</th>
                                    <th scope="col">Name account</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Role</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($accounts = mysqli_fetch_assoc($account_list)) : ?>
                                    <?php

                                    if ($accounts['roleID'] == 1) {
                                        $name_role = 'Admin';
                                    } else {
                                        $name_role = 'User';
                                    }
                                    echo '<tr id="' . $accounts['id'] . '" ><th scope="row">' . $accounts['id'] . '</th>';
                                    echo '<td>' . $accounts['account_name'] . '</td>';
                                    echo '<td>' . $accounts['email'] . '</td>';
                                    echo '<td>' . $name_role . '</td>';
                                    echo '<td>';

                                    // if ($accounts['roleID'] != 1 || $accounts['id'] == key($_SESSION['account'])) {
                                    //     echo '<a href="editProduct.php?id=' . $accounts['id'];
                                    //     echo '" class="mr-2" >';
                                    //     echo '<i class="fa fa-edit"></i></a>';
                                    //     echo '<a style="color:red;" onclick="deleteProduct(' . $accounts['id'] . ')"';
                                    //     echo 'class="mr-2">';
                                    //     echo '<i class="fa fa-times"></i></a>';
                                    // }
                                    echo '<a style="color:red;" ';
                                    echo 'class="" >';
                                    echo '<i class="fa fa-info-circle"></i></a></td></tr>';
                                    ?>
                                <?php endwhile; ?>
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
    function deleteProduct(id) {
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "../../services/services.php?action=deleteProduct",
            data: {
                id
            },
            success: function(result) {
                $('#' + id).remove();
                alert(result.message);
            }
        });
    }
</script>


</html>