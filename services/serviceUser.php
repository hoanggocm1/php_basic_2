<?php

function get_product_list($conn)
{
    $id = key($_SESSION['account']);
    $sql = "SELECT * FROM products where user_id ='" . $id . "' ORDER BY products.id ASC";
    return mysqli_query($conn, $sql);
}
function get_NameParent($conn, $parent_ID)
{
    $sql = "SELECT category_name FROM categorys where id ='" . $parent_ID . "'";
    return mysqli_query($conn, $sql);
}
function getProductByID($conn, $id)
{
    if (isset($_SESSION['account'])) {
        return mysqli_query($conn, "SELECT * FROM products where id='" . $id . "'");
    }
}
