<?php

session_start();
function getNameAccountByID($conn)
{
    if (isset($_SESSION['account'])) {
        return mysqli_query($conn, "SELECT id,account_name FROM accounts where id='" . key($_SESSION['account']) . "'");
    }
}



function getCategory($conn)
{
    return mysqli_query($conn, "SELECT * FROM categorys where active=1");
}

if (isset($_GET['action']) && $_GET['action'] == 'createProduct') {
    require("../db/connection.php");
    $parent_ID = $_POST['parent_ID'];
    $name = $_POST['name'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $qty = $_POST['qty'];
    $id_account = key($_SESSION['account']);
    $urlImage = $_POST['NameImage'];
    $query = mysqli_query($conn, "INSERT INTO products (user_ID,parent_ID,product_name,title,description,price,quantity,image) VALUES (N'$id_account',N'$parent_ID',N'$name',N'$title',N'$description',N'$price',N'$qty',N'$urlImage')");

    if ($query) {
        $_SESSION['success'] = 'Add thanh cong.';
        header('location:../view/User/addProduct.php');
        exit;
    } else {
        $_SESSION['success'] = 'Add that bai.';
        header('location:../view/User/addProduct.php');
        exit;
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'updateProduct') {
    require("../db/connection.php");
    $parent_ID = $_POST['parent_ID'];
    $name = $_POST['name'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $qty = $_POST['qty'];
    $id_account = key($_SESSION['account']);
    $image = $_POST['NameImage'];
    $sql = "UPDATE products SET parent_ID=N'$parent_ID',product_name=N'$name',title=N'$title',description=N'$description',price=N'$price',quantity=N'$qty',image=N'$image'  WHERE id='" . $_GET['id'] . "'";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        $_SESSION['success'] = 'Update thanh cong.';
        header('location:../view/User/products.php');
        exit;
    } else {
        $_SESSION['success'] = 'Update that bai.';
        header('location:../view/User/products.php');
        exit;
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'deleteProduct') {
    require("../db/connection.php");

    $idProduct = $_POST['id'];

    $idAccount = key($_SESSION['account']);

    $sql = "DELETE FROM products WHERE id='" . $idProduct . "' AND user_ID ='" . $idAccount . "'";

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

if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    unset($_SESSION['account']);
    header('location:../index.php');
    exit;
}
if (isset($_GET['action']) && $_GET['action'] == 'login') {
    require("../db/connection.php");
    $user = $_POST;
    $sql = "SELECT * FROM accounts where email ='" . $user['email'] . "' AND password = '" . md5($user['password']) . "'";
    $accounts = mysqli_query($conn, $sql);

    if ($accounts->num_rows > 0) {
        $account = $accounts->fetch_assoc();
        $_SESSION['account'] = [$account['id'] => $account['roleID']];

        if ($account['roleID'] == 1) {
            header("Location:../view/Admin/index.php");
            exit;
        } elseif ($account['roleID'] == 2) {
            header("Location:../view/User/index.php");
            exit;
        }
    } else {
        $_SESSION['success'] = 'Tài khoản hoặc mật khẩu không đúng!';
        header("Location:../index.php");
        exit;
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'register') {
    require("../db/connection.php");
    $register = $_POST;
    if ($register['password'] === $register['confirm_password']) {
        $sql = "SELECT * FROM accounts where email ='" . $register['email'] . "'";
        $accounts = mysqli_query($conn, $sql);
        if ($accounts->num_rows > 0) {
            echo '<h1>Email đã được sử dụng!</h1>';
            exit;
        } else {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = md5($_POST['password']);
            $query = $conn->query("INSERT INTO accounts (account_name,email,password,roleID) VALUES (N'$name',N'$email',N'$password','2')");
            if ($query) {

                $sql = "SELECT * FROM accounts where email ='" . $register['email'] . "'";
                $accounts = mysqli_query($conn, $sql);
                mysqli_close($conn);
                $account = $accounts->fetch_assoc();
                $_SESSION['account_register'] = $email;


                $_SESSION['success'] = 'Đăng ký tài khoản thành công.';


                header("Location:../index.php");
                exit;
            }
            echo '<h1>Đăng ký thất bại! </h1>';
        }
    } else {
        $_SESSION['success'] = 'Mật khẩu xác nhận không đúng!';
        header("Location:../registration.php");
        exit;
    }
}


function showCategoriesAU($categories, $parent_id = 0, $char = '')

{

    foreach ($categories as $key => $item) {
        if ($item['parent_ID'] == $parent_id) {
            echo '<option value="' . $item['id'] . '">';
            echo $char . $item['category_name'];
            echo '</option>';
            unset($categories[$key]);
            showCategoriesAU($categories, $item['id'], $char . ' ---- ||');
        }
    }
}

function showCategoriesAddProduct($categories, $parent_id = 0, $char = '')

{
    foreach ($categories as $key => $item) {
        if ($item['parent_ID'] == $parent_id) {
            echo '<option value="' . $item['id'] . '">';
            echo $char . $item['category_name'];
            echo '</option>';
            unset($categories[$key]);
            showCategoriesAU($categories, $item['id'], $char . ' ---- ||');
        }
    }
}

function showCategoriesAddProduct_U($categories, $id, $parent_id = 0, $char = '')

{
    foreach ($categories as $key => $item) {
        if ($item['parent_ID'] == $parent_id) {
            echo '<option value="' . $item['id'] . '">';
            echo $char . $item['category_name'];
            echo '</option>';
            unset($categories[$key]);
            showCategoriesAddProduct_U($categories, $id, $item['id'], $char . ' ---- ||');
        }
    }
}
