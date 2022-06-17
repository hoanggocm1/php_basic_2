<?php
// if (isset($_POST) && !empty($_FILES['file'])) {
//     $duoi = explode('.', $_FILES['file']['name']); // tách chuỗi khi gặp dấu .
//     $duoi = $duoi[(count($duoi) - 1)]; //lấy ra đuôi file
//     // Kiểm tra xem có phải file ảnh không
//     // $domain =  (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/php_basic_2';
//     // print_r($domain);
//     // die;
//     if ($duoi === 'jpg' || $duoi === 'png' || $duoi === 'gif') {
//         // tiến hành upload
//         if (move_uploaded_file($_FILES['file']['tmp_name'], '../images/uploads/' . $_FILES['file']['name'])) {
//             // Nếu thành công
//             $domain =  (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/php_basic_2';
//             echo $domain . $;
//             die;
//             die('Upload thành công file: ' . $_FILES['file']['name']); //in ra thông báo + tên file
//         } else { // nếu không thành công
//             die('Có lỗi!'); // in ra thông báo
//         }
//     } else { // nếu không phải file ảnh
//         die('Chỉ được upload ảnh'); // in ra thông báo
//     }
// } else {
//     die('Lock'); // nếu không phải post method
// }

header('Access-Control-Allow-Origin: *');
if (isset($_FILES['file'])) {
    $duoi = explode('.', $_FILES['file']['name']); // tách chuỗi khi gặp dấu .
    $duoi = $duoi[(count($duoi) - 1)]; //lấy ra đuôi file
    if ($duoi === 'jpg' || $duoi === 'png' || $duoi === 'gif') {
        $dau = current(explode('.', $_FILES['file']['name']));
        $fullName = $dau . rand(0, 999) . '.' . $duoi;
        $name = str_replace(' ', '-', $fullName);
        $bannerPath = "../images/uploads/" . $name;
        $flag = move_uploaded_file($_FILES["file"]["tmp_name"], $bannerPath);
        if ($flag) {
            $resultImg = "images/uploads/" . $name;
            echo json_encode([
                'urlImage' => $resultImg,
                'code' => 200
            ]);
            exit;
        } else {
            echo json_encode([
                'message' => 'Upload hình ảnh thất bại!',
                'code' => 400
            ]);
            exit;
        }
    } else {

        echo json_encode([
            'message' => 'Chỉ có thể upload file hình ảnh!',
            'code' => 401
        ]);
        exit;
    }
}
