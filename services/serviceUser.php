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
function get_categorys_list_user($conn)
{
    $sql = "SELECT * FROM categorys";
    return  mysqli_query($conn, $sql);
}



function showCategoriesU_edit($categories, $id, $parent_id = 0, $char = '')

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
            showCategoriesU_edit($categories, $id, $item['id'], $char . ' ---- || ');
        }
    }
}
