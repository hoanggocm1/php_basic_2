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
    $product_list = get_product_listByID($conn, $_GET['id']);
    $accounts = getNameAccount($conn);

    // print_r($_SESSION['account']);
    // die;
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
                                <a href="addProduct.php" class="btn btn-info btn-fill pull-left">Thêm</a>
                            </div>

                            <div class="col-md-3 px-1">
                                <div class="form-group">
                                    <select name="parent_ID" id="listProduct" onchange="location = this.value;" class="form-control">
                                        <option value="listProductByID.php?id=0">All</option>
                                        <?php while ($name_accounts = mysqli_fetch_assoc($accounts)) :  ?>
                                            <option value="listProductByID.php?id=<?php echo $name_accounts['id']; ?>" <?php if ($name_accounts['id'] == $_GET['id']) {
                                                                                                                            echo 'selected=""';
                                                                                                                        } ?>><?php echo $name_accounts['account_name'];
                                                                                                                                if ($name_accounts['roleID'] != 1) {
                                                                                                                                    echo ' - User';
                                                                                                                                } elseif ($name_accounts['id'] != key($_SESSION['account'])) {
                                                                                                                                    echo ' - Admin';
                                                                                                                                } else {
                                                                                                                                    echo ' - Admin (tôi)';
                                                                                                                                } ?></option>
                                        <?php endwhile; ?>
                                    </select>

                                </div>
                            </div>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID products</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Name product</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Name account</th>
                                    <th scope="col">Name role</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($product = mysqli_fetch_assoc($product_list)) : ?>
                                    <?php
                                    if ($product['roleID'] == 1) {
                                        $name_role = 'Admin';
                                    } else {
                                        $name_role = 'User';
                                    }
                                    echo '<tr id="' . $product['id'] . '" ><th scope="row">' . $product['id'] . '</th>';
                                    echo '<td>' . $product['category_name'] . '</td>';
                                    echo '<td>' . $product['product_name'] . '</td>';
                                    echo '<td>' . $product['title'] . '</td>';
                                    echo '<td>' . $product['description'] . '</td>';
                                    echo '<td>' . $product['price'] . '</td>';
                                    echo '<td>' . $product['quantity'] . '</td>';
                                    echo '<td> <a href="../../' . $product['image'] . '  " target="_blank" ><img src="../../' . $product['image'] . '" width="100px"></a> </td>';
                                    echo '<td>' .   $product['account_name']  . '</td>';
                                    echo '<td>' .   $name_role . '</td>';
                                    if ($product['roleID'] == 1 && $product['user_ID'] != key($_SESSION['account'])) {
                                        echo '<td><a  onclick="noUpdate()" style="cursor: pointer;"  class="mr-2" >';
                                        echo '<i class="fa fa-edit"></i></a>';
                                    } else {
                                        echo '<td><a href="editProduct.php?id=' . $product['id'];
                                        echo '" class="mr-2" >';
                                        echo '<i class="fa fa-edit"></i></a>';
                                    }
                                    echo '<a style="color:red;cursor: pointer;"  onclick="deleteProductAdmin(' . $product['id'] . ',' . $product['roleID'] . ',' . $product['user_ID'] . ')"';
                                    echo 'class="mr-2">';
                                    echo '<i class="fa fa-times"></i></a><a style="color:red;" ';
                                    echo 'class="" href="detailProductAdmin.php?id=' . $product['id'];
                                    echo '"><i class="fa fa-info-circle"></i></a></td></tr>';
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
    function deleteProductAdmin(id, roleID, userID) {

        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "../../services/serviceAdmin.php?action=deleteProduct",
            data: {
                id,
                roleID,
                userID
            },
            success: function(result) {
                if (result.code == 200) {
                    $('#' + id).remove();
                    alert(result.message);
                } else {
                    alert(result.message);
                }

            }
        });
    }

    function noUpdate() {
        alert('Không thể update sản phẩm của Admin khác!');
    }
</script>


</html>