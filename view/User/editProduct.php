<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("../layout/head.php"); ?>
</head>
<?php



require("../../db/connection.php");
require("../../services/services.php");
if (!isset($_SESSION['account'])) {
    header('location:../../index.php');
    exit;
}
if ($_SESSION['account'][key($_SESSION['account'])] == 2) : ?>
    <?php
    // require("../../db/connection.php");
    $product = mysqli_fetch_assoc(getProductByID($conn, $_GET['id']))

    // print_r(mysqli_fetch_object($user_list));  
    // $name = mysqli_fetch_assoc(getNameAccountByID($conn));
    // $name1 = mysqli_fetch_assoc($name);
    // echo (mysqli_fetch_assoc(getCategory($conn))['name']);
    // die;
    ?>



    <body>
        <div class="wrapper">
            <div class="sidebar" data-image="/php_basic_2/assets/img/sidebar-5.jpg">
                <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

        Tip 2: you can also add an image using data-image tag
    -->
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
                        <div class="card-body">
                            <form action="../../services/services.php?action=updateProduct&id=<?php echo $_GET['id']  ?>" method="POST">
                                <?php if (isset($_SESSION['success'])) : ?>
                                    <p style="color: green;"><?php echo $_SESSION['success'];  ?></p>
                                    <?php unset($_SESSION['success']); ?>
                                <?php endif; ?>
                                <div class="row">
                                    <div class="col-md-6 pr-1">
                                        <div class="form-group">
                                            <label>Name account</label>
                                            <input type="hidden" name="user_ID" class="form-control" disabled="" value="<?php echo mysqli_fetch_assoc(getNameAccountByID($conn))['id'] ?>">
                                            <samp class="form-control" disabled=""><?php echo mysqli_fetch_assoc(getNameAccountByID($conn))['account_name'] ?></samp>
                                        </div>
                                    </div>
                                    <div class="col-md-6 px-1">
                                        <div class="form-group">
                                            <label>Category</label>
                                            <select name="parent_ID" class="form-control">
                                                <?php $categorys = getCategory($conn); ?>
                                                <?php while ($category = mysqli_fetch_assoc($categorys)) :  ?>
                                                    <option value="<?php echo $category['id']; ?>" <?php if ($product['parent_ID'] == $category['id']) {
                                                                                                        echo 'selected=""';
                                                                                                    } ?>><?php echo $category['category_name'];  ?></option>
                                                <?php endwhile; ?>
                                            </select>

                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" name="name" required value="<?php echo $product['product_name'] ?>" placeholder="name" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class=" row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Title</label>
                                            <textarea name="title" required class="form-control" style="height: 60px;" cols="30" rows="10"><?php echo $product['title'] ?> </textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea name="description" required class="form-control" style="height: 60px;" cols="30" rows="10"><?php echo $product['description'] ?> </textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 pr-1">
                                        <div class="form-group">
                                            <label>Price</label>
                                            <input type="number" required name="price" value="<?php echo $product['price'] ?>" class="form-control" placeholder="Price" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6 pl-1">
                                        <div class="form-group">
                                            <label>Quantity</label>
                                            <input type="number" required class="form-control" value="<?php echo $product['quantity'] ?>" name="qty" placeholder="Quantity" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="menu">File input</label>
                                    <input type="file" name="file" class="form-control" id="uploadImageProduct">
                                    <div id="image_show">
                                        <a href="../../ <?php echo $product['image']  ?>   " target="_blank"><img src="../../<?php echo $product['image']  ?> " width="100px"></a>
                                    </div>
                                    <input type="hidden" name="NameImage" value="<?php echo $product['image']  ?>" id="file">
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

            Không thể truy cập!

        </h1>
    </body>

<?php endif; ?>
<script>
    $('#uploadImageProduct').change(function() {
        const form = new FormData();
        let img = $("#uploadImageProduct");
        var a = form.append('file', img[0].files[0]);
        // console.log(form);
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