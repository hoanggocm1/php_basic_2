<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("../layout/head.php"); ?>
</head>
<?php
require("../../db/connection.php");
require("../../services/services.php");

require("../../services/serviceAdmin.php");

if (!isset($_SESSION['account'])) {
    header('location:../../index.php');
    exit;
}

if ($_SESSION['account'][key($_SESSION['account'])] == 1) : ?>
    <?php



    $product = mysqli_fetch_assoc(getProductByIDAdmin($conn, $_GET['id']));

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
                            <form action="../../services/serviceAdmin.php?action=updateProduct&id=<?php echo $_GET['id']  ?>" method="POST">
                                <?php if (isset($_SESSION['success'])) : ?>
                                    <p style="color: green;"><?php echo $_SESSION['success'];  ?></p>
                                    <?php unset($_SESSION['success']); ?>
                                <?php endif; ?>
                                <div class="row">
                                    <div class="col-md-6 pr-1">
                                        <div class="form-group">
                                            <label>Name account</label>
                                            <samp class="form-control" disabled=""><?php echo $product['account_name']; ?></samp>
                                        </div>
                                    </div>
                                    <div class="col-md-6 px-1">
                                        <div class="form-group">
                                            <label>Category</label>
                                            <select name="parent_ID" class="form-control">
                                                <?php showCategoriesAU_edit($categorys_list, $product['parent_ID'])  ?>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Name</label>

                                            <input type="text" name="name" value="<?php echo $product['product_name'] ?>" placeholder="name" class="form-control">
                                            <input type="hidden" name="roleID" value="<?php echo $product['roleID']; ?>">
                                            <input type="hidden" name="account_id" value="<?php echo $product['account_id']; ?>">
                                            <input type="hidden" name="imageOld" value="<?php echo $product['image']; ?>">

                                        </div>
                                    </div>
                                </div>
                                <div class=" row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Title</label>
                                            <textarea name="title" class="form-control" style="height: 60px;" cols="30" rows="10"><?php echo $product['title'] ?> </textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea name="description" class="form-control" style="height: 60px;" cols="30" rows="10"><?php echo $product['description'] ?> </textarea>


                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 pr-1">
                                        <div class="form-group">
                                            <label>Price</label>
                                            <input type="text" name="price" value="<?php echo $product['price'] ?>" class="form-control" placeholder="Price" value="">

                                        </div>
                                    </div>
                                    <div class="col-md-6 pl-1">
                                        <div class="form-group">
                                            <label>Quantity</label>
                                            <input type="text" class="form-control" value="<?php echo $product['quantity'] ?>" name="qty" placeholder="Quantity" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="menu">File input</label>


                                    <input type="file" name="file" class="form-control" id="uploadImageProduct">
                                    <div id="image_show">
                                        <a href="../../ <?php echo $product['image']  ?>   " target="_blank"><img src="../../<?php echo $product['image']  ?> " width="100px"></a>
                                    </div>
                                    <input type="hidden" name="NameImage" id="file">

                                </div>
                                <button type="submit" class="btn btn-info btn-fill pull-right">Update</button>
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

            T??i kho???n admin m???i c?? th??? truy c???p!

        </h1>
    </body>

<?php endif; ?>
<script>
    $('#uploadImageProduct').change(function() {
        const form = new FormData();
        let img = $("#uploadImageProduct");
        var a = form.append('file', img[0].files[0]);
        $.ajax({
            processData: false,
            contentType: false,
            mimeType: "multipart/form-data",
            type: 'post',
            dataType: 'JSON',
            data: form,
            url: '../../services/uploadImage.php',
            success: function(result) {
                if (result.code == 401) {
                    alert(result.message);
                    $("#uploadImageProduct").val('');
                } else {
                    if (result.code == 200) {
                        $('#image_show').html('<a href="../../' + result.urlImage + '  " target="_blank" ><img src="../../' + result.urlImage + '" width="100px"></a>');
                        $('#file').val(result.urlImage);
                    } else {
                        alert(result.message);

                    }
                }

            }

        });

    });
</script>

</html>