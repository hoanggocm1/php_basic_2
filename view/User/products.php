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
if ($_SESSION['account'][key($_SESSION['account'])] == 2) : ?>
    <?php
    require("../../db/connection.php");
    require("../../services/serviceUser.php");
    $product_list = get_product_list($conn);

    ?>



    <body>
        <div class="wrapper">
            <div class="sidebar" data-image="/php_basic_2/assets/img/sidebar-5.jpg">
                <div class="sidebar-wrapper">
                    <?php include("../layout/sidebar.php"); ?>
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
                        <a href="addProduct.php" class="btn btn-info btn-fill pull-left">Thêm</a>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID products</th>
                                    <th scope="col">Parent</th>
                                    <th scope="col">Name product</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Decription</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Image</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($product = mysqli_fetch_assoc($product_list)) : ?>
                                    <?php
                                    $parent_name = mysqli_fetch_assoc(get_NameParent($conn, $product['parent_ID']));
                                    // $a =  mysqli_fetch_assoc($parent_name);
                                    // print_r($parent_name);
                                    // die;
                                    echo '<tr id="' . $product['id'] . '" ><th scope="row">' . $product['id'] . '</th>';
                                    echo '<td>' . $parent_name['category_name'] . '</td>';
                                    echo '<td>' . $product['product_name'] . '</td>';
                                    echo '<td>' . $product['title'] . '</td>';
                                    echo '<td>' . $product['description'] . '</td>';
                                    echo '<td>' . $product['price'] . '</td>';
                                    echo '<td>' . $product['quantity'] . '</td>';
                                    echo '<td> <a href="../../' . $product['image'] . '  " target="_blank" ><img src="../../' . $product['image'] . '" width="100px"></a> </td>';
                                    echo '<td><a href="editProduct.php?id=' . $product['id'];
                                    echo '" class="mr-2" >';
                                    echo '<i class="fa fa-edit"></i></a>';
                                    echo '<a style="color:red;cursor: pointer;" onclick="deleteProduct(' . $product['id'] . ')"';
                                    echo 'class="mr-2">';
                                    echo '<i class="fa fa-times"></i></a><a  href="detailProduct.php?id=' . $product['id'];
                                    echo '" style="color:red;" ';
                                    echo 'class="" >';
                                    echo '<i class="fa fa-info-circle"></i></a></td></tr>';
                                    ?>
                                <?php endwhile; ?>
                                <?php mysqli_close($conn);  ?>
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
            Không thể truy cập!
        </h1>
    </body>

<?php endif; ?>
<script>
    function deleteProduct(id) {
        var accept = confirm('Xác nhận xóa sản phẩm này?');
        if (accept) {
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "../../services/services.php?action=deleteProduct",
                data: {
                    id
                },
                success: function(result) {
                    if (result.code == 200) {
                        $('#' + id).remove();
                        alert(result.message);
                    } else {
                        alert(result.message);
                    }

                }
            })
        }
    }
</script>


</html>