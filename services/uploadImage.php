<?php
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
