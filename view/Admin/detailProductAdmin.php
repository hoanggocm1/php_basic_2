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
    require("../../services/serviceUser.php");
    $product_list = get_product_list($conn);
    $product = mysqli_fetch_assoc(getProductByID($conn, $_GET['id']))

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
                                        <label for="menu" style="padding-left: 20%;">File</label>
                                        <input type="file" name="file1s[]" value="" class="form-control" multiple="multiple" id="uploadImageProducts">
                                        <input type="hidden" name="demImages" id="demImages">
                                        <div id="block_image" style="display: flex; ">
                                        </div>
                                    </div>
                                    <button style=" height: 20%; text-align: center; justify-items: center; padding-left: 20px; color: blue; cursor: pointer;"> <i class="fas fa-edit"> Thêm</i></button>
                                </div>

                            </form>
                            <div style="display: flex; justify-content: space-between;">
                                <div class="block2-pic hov-img0" style="display: flex; width: 100%; flex-wrap: wrap; padding: 5px;">


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

    $('#uploadImageProducts').change(function() {


        const form = new FormData();
        form.append('files[]', $(this)[0].files[0]);
        form.append('files[]', $(this)[0].files[1]);
        form.append('files[]', $(this)[0].files[2]);
        form.append('files[]', $(this)[0].files[3]);
        $.ajax({
            processData: false,
            contentType: false,
            type: 'post',
            dataType: 'JSON',
            data: form,
            url: '../../services/uploadImages.php?',
            success: function(result) {
                if (result.error == false) {
                    var a = new Array;
                    $('#demImages').val(result.url.dem)

                    for (let i = 0; i < result.url.dem; i++) {


                        $('#block_image').append('<div class="images_show" style="padding-right: 10px;padding-top: 5px;"><a href="' + result.url.fullUrl[i] + '  " target="_blank" ><img src="' + result.url.fullUrl[i] + '" width="100px" height= "150px"; ></a></div>' +
                            '<input type="hidden" name="files' + i + '" value="' + result.url.fullUrl[i] + '" id="files' + i + '" >');

                        a[i] = result.url.fullUrl[i];



                    }



                } else {
                    alert('Upload file lỗi!');
                }
            }

        });




    });
</script>


</html>