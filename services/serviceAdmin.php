<?php


function getNameAccount($conn)
{
    return mysqli_query($conn, "SELECT * FROM accounts order by roleID");
}
function get_product_list($conn)
{

    $sql = "SELECT products.*, 
    accounts.account_name,categorys.category_name,accounts.roleID
    FROM products
    INNER JOIN accounts ON products.user_ID = accounts.id 
    INNER JOIN categorys ON products.parent_ID = categorys.id
     ORDER BY products.id DESC ";



    return  mysqli_query($conn, $sql);
}
// danh sách danh mục
function get_categorys_list($conn)
{
    $sql = "SELECT * FROM categorys";
    return  mysqli_query($conn, $sql);
}

function listCategorys($categorys, $parent_id = 0, $char = '')
{
    foreach ($categorys as $key => $value) {
        if ($value['parent_ID'] == $parent_id) {

            if ($value['active'] == 1) {
                $status = 'ON';
            } else {
                $status = 'OFF';
            }

            echo '<tr id ="category_' . $value['id'] . '">';
            echo '<td>'  . $value['id'] . '</td>';
            echo '<td >' . $char . $value['category_name'] . '</td>';
            echo '<td >' . $status . '</td>';

            echo '<td><a href="editCategory.php?id=' . $value['id'];
            echo '"   class="mr-2"  >';
            echo '<i class="fa fa-edit" ></i></a>';
            echo '<a style="color:red;cursor: pointer;" onclick="deleteCategoryAdmin(' . $value['id'] . ')"';
            echo 'class="mr-2">';
            echo '<i class="fa fa-times"></i></a></td></tr>';


            unset($value[$key]);
            listCategorys($categorys, $value['id'], $char . ' ---- || ');
        }
    }
}

function getCategoryByID($conn, $id)
{
    return mysqli_query($conn, "SELECT name FROM categorys where active = 1 AND id='" . $id . "'");
}
function getRoleByID($conn, $id)
{

    $sql = "SELECT * FROM roles where id='" . $id . "'";
    return mysqli_query($conn, $sql);
}
function getListAccouts($conn)
{
    $sql = "SELECT * FROM accounts";
    return mysqli_query($conn, $sql);
}


if (isset($_GET['action']) && $_GET['action'] == 'createProduct') {
    require("../db/connection.php");
    session_start();
    $parent_ID = $_POST['parent_ID'];
    $name = $_POST['name'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $qty = $_POST['qty'];
    $urlImage = $_POST['NameImage'];
    $id_account = key($_SESSION['account']);
    $query = mysqli_query($conn, "INSERT INTO products (user_ID,parent_ID,product_name,title,description,price,quantity,image) VALUES (N'$id_account',N'$parent_ID',N'$name',N'$title',N'$description',N'$price',N'$qty',N'$urlImage')");

    if ($query) {
        $_SESSION['success'] = 'Add thanh cong.';
        header('location:../view/Admin/addProduct.php');
        exit;
    } else {
        $_SESSION['success'] = 'Add that bai.';
        header('location:../view/Admin/addProduct.php');
        exit;
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'updateProduct') {
    require("../db/connection.php");
    session_start();

    $user_id = $_POST['account_id'];
    $roleID = $_POST['roleID'];

    if ($roleID == 1 && key($_SESSION['account']) != $user_id) {

        $_SESSION['success'] = 'Không thể sửa sản phẩm của Admin khác!';
        header('location:../view/Admin/listProducts.php');
        exit;
    } else {

        $parent_ID = $_POST['parent_ID'];
        $name = $_POST['name'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $qty = $_POST['qty'];
        if ($_POST['NameImage'] == '') {
            $urlImage = $_POST['imageOld'];
        } else {
            $urlImage = $_POST['NameImage'];
        }
        $id_account = key($_SESSION['account']);
        $sql = "UPDATE products SET parent_ID=N'$parent_ID',product_name=N'$name',title=N'$title',description=N'$description',price=N'$price',quantity=N'$qty',image=N'$urlImage'  WHERE id='" . $_GET['id'] . "'";
        $query = mysqli_query($conn, $sql);
        if ($query) {
            $_SESSION['success'] = 'Update thanh cong.';
            header('location:../view/Admin/listProducts.php');
            exit;
        } else {
            $_SESSION['success'] = 'Update that bai.';
            header('location:../view/Admin/listProducts.php');
            exit;
        }
    }
}


if (isset($_GET['action']) && $_GET['action'] == 'deleteProduct') {
    require("../db/connection.php");
    session_start();
    if ($_POST['roleID'] == 1 && key($_SESSION['account']) != $_POST['userID']) {
        echo json_encode([
            'message' => 'Không thể xóa sản phẩm của Admin khác!',
            'code' => '400'
        ]);
        exit;
    } else {
        $idProduct = $_POST['id'];
        $sql = "DELETE FROM products WHERE id='" . $idProduct . "'";
        $query = mysqli_query($conn, $sql);
        $change = mysqli_affected_rows($conn);
        mysqli_close($conn);
        if ($change > 0 && $query == true) {
            echo json_encode([
                'message' => 'Delete thanh cong.',
                'code' => '200'
            ]);
        } else {
            echo json_encode([
                'message' => 'Delete that bai!',
                'code' => '400'
            ]);
        }
        exit;
    }
}
function get_product_listByID($conn, $id)
{
    if ($id != 0) {
        $sql = "SELECT products.*, 
        accounts.account_name,categorys.category_name,accounts.roleID
        FROM products
        INNER JOIN accounts ON products.user_ID = accounts.id 
        INNER JOIN categorys ON products.parent_ID = categorys.id
         where products.user_ID = $id
         ORDER BY products.id DESC ";
        return  mysqli_query($conn, $sql);
    } else {
        $sql = "SELECT products.*, 
        accounts.account_name,categorys.category_name,accounts.roleID
        FROM products
        INNER JOIN accounts ON products.user_ID = accounts.id 
        INNER JOIN categorys ON products.parent_ID = categorys.id
        ORDER BY products.id DESC ";
        return  mysqli_query($conn, $sql);
    }
}

function getProductByIDAdmin($conn, $id)
{


    if (isset($_SESSION['account'])) {
        $sql = "SELECT products.*, 
        accounts.account_name,accounts.id as account_id,accounts.roleID
        FROM products
        INNER JOIN accounts ON products.user_ID = accounts.id
        where products.id= $id";
        return mysqli_query($conn, $sql);
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'createCategory') {
    require("../db/connection.php");
    $category_name = $_POST['category_name'];
    $parent_ID = $_POST['parent_ID'];

    $active = $_POST['active'];
    $query = mysqli_query($conn, "INSERT INTO categorys (parent_ID,category_name,active) VALUES (N'$parent_ID',N'$category_name',N'$active')");

    if ($query) {
        $_SESSION['success'] = 'Add thanh cong.';
        header('location:../view/Admin/addCategory.php');
        exit;
    } else {
        $_SESSION['success'] = 'Add that bai.';
        header('location:../view/Admin/addCategory.php');
        exit;
    }
}

function showCategoriesAU_edit($categories, $id, $parent_id = 0, $char = '')

{
    foreach ($categories as $key => $item) {
        if ($item['parent_ID'] == $parent_id) {
            if ($id == $item['id']) {
                echo '<option selected="" value="' . $item['id'] . '">';
                echo $char . $item['category_name'];
                echo '</option>';
            } else {
                echo '<option  value="' . $item['id'] . '">';
                echo $char . $item['category_name'];
                echo '</option>';
            }

            unset($categories[$key]);
            showCategoriesAU_edit($categories, $id, $item['id'], $char . ' ---- || ');
        }
    }
}

function getCategoryByIDAdmin($conn, $id)
{
    if (isset($_SESSION['account'])) {
        $sql = "SELECT * FROM  categorys where id= $id";
        return mysqli_query($conn, $sql);
    }
}
if (isset($_GET['action']) && $_GET['action'] == 'updateCategory') {
    require("../db/connection.php");
    session_start();
    $parent_ID = $_POST['parent_ID'];
    $category_name = $_POST['category_name'];
    $active = $_POST['active'];
    $sql = "UPDATE categorys SET parent_ID=N'$parent_ID',category_name=N'$category_name',active=N'$active'  WHERE id='" . $_POST['id'] . "'";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        $_SESSION['success'] = 'Update thanh cong.';
        header('location:../view/Admin/listCategorys.php');
        exit;
    } else {
        $_SESSION['success'] = 'Update that bai.';
        header('location:../view/Admin/listCategorys.php');
        exit;
    }
}
if (isset($_GET['action']) && $_GET['action'] == 'deleteCategory') {
    require("../db/connection.php");
    session_start();

    $idCategory = $_POST['id'];
    $sql = "DELETE FROM categorys WHERE id='" . $idCategory . "'";
    $query = mysqli_query($conn, $sql);
    $change = mysqli_affected_rows($conn);
    mysqli_close($conn);
    if ($change > 0 && $query == true) {
        echo json_encode([
            'message' => 'Delete thanh cong.',
            'code' => '200',
            'id' => $idCategory
        ]);
    } else {
        echo json_encode([
            'message' => 'Delete that bai!',
            'code' => '400'
        ]);
    }
    exit;
}


if (isset($_GET['action']) && $_GET['action'] == 'createAccount') {
    require("../db/connection.php");
    $account_name = $_POST['account_name'];
    $email = $_POST['email'];

    $password = md5($_POST['password']);
    $roleID = $_POST['roleID'];
    $query = mysqli_query($conn, "INSERT INTO accounts (account_name,email,password,roleID) VALUES (N'$account_name',N'$email',N'$password',N'$roleID')");

    if ($query) {
        $_SESSION['success'] = 'Add thanh cong.';
        header('location:../view/Admin/addAccount.php');
        exit;
    } else {
        $_SESSION['success'] = 'Add that bai.';
        header('location:../view/Admin/addAccount.php');
        exit;
    }
}
