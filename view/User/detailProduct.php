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
    $product = mysqli_fetch_assoc(getProductByID($conn, $_GET['id']))

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

                                <?php
                                $parent_name = mysqli_fetch_assoc(get_NameParent($conn, $product['parent_ID']));

                                echo '<tr id="' . $product['id'] . '" ><th scope="row">' . $product['id'] . '</th>';
                                echo '<td>' . $parent_name['category_name'] . '</td>';
                                echo '<td>' . $product['product_name'] . '</td>';
                                echo '<td>' . $product['title'] . '</td>';
                                echo '<td>' . $product['description'] . '</td>';
                                echo '<td>' . $product['price'] . '</td>';
                                echo '<td>' . $product['quantity'] . '</td>';
                                echo '<td> <a href="../../' . $product['image'] . '  " target="_blank" ><img src="../../' . $product['image'] . '" width="100px"></a> </td>';
                                echo '</tr>';
                                ?>
                                <?php mysqli_close($conn);  ?>
                            </tbody>

                        </table>
                        <!-- <div>
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="form-group col-md-8" style="padding-left: 20px;">
                                        <label for="menu" style="padding-left: 20%;">File inputssss</label>
                                        <input type="file" name="file1s[]" value="" class="form-control" multiple="multiple" id="uploadImageProducts">
                                        <input type="hidden" name="demImages" id="demImages">
                                        <div id="block_image" style="display: flex; ">
                                        </div>
                                    </div>
                                    <button style=" height: 20%; text-align: center; justify-items: center; padding-left: 20px; color: blue; cursor: pointer;"> <i class="fas fa-edit"> Th??m</i></button>
                                </div>

                            </form>
                            <div style="display: flex; justify-content: space-between;">
                                <div class="block2-pic hov-img0" style="display: flex; width: 100%; flex-wrap: wrap; padding: 5px;">

                                    <div style="width:24%; background-color: transparent;position: relative;margin: 1px;background-color: black;" id="">
                                        <a onclick="" id="" style="color: red;height: 10%;position: absolute; padding: 10px; cursor: pointer; " value="">
                                            X??a
                                        </a>
                                        <a href="" target="_blank">
                                            <img src="" width="100%" style="padding:3px; cursor: pointer; ">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div> -->

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

            Kh??ng th??? truy c???p!

        </h1>
    </body>

<?php endif; ?>
<script>
    function deleteProduct(id) {
        var accept = confirm('X??c nh???n x??a s???n ph???m n??y?');
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