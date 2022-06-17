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

if (isset($_GET['action']) && $_GET['action'] == 'updateProduct') {
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
        accounts.account_name,accounts.id as account_id
        FROM products
        INNER JOIN accounts ON products.user_ID = accounts.id
        where products.id= $id";
        return mysqli_query($conn, $sql);
    }
}
