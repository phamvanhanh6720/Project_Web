<?php
function delete_image($url) {
    if (@unlink($url)) {
        return true;
    }
    return false;
}
function upload_image($dir, $file_type) {
    $upload_dir = $dir;
    $upload_file = $upload_dir . $_FILES['file']['name'];
    if (file_exists($upload_file)) {                                                   // Kiểm tra file đã tồn tại hay chưa
        $file_name = pathinfo($_FILES['file']['name'], PATHINFO_FILENAME);                  // Tạo tên file mới
        $new_file_name = $file_name . "-copy.";                                              // Đường dẫn file mới
        $new_upload_file = $upload_dir . $new_file_name . $file_type;
        $k = 1;                                                                              // Gán chỉ số copy     
        while (file_exists($new_upload_file)) {                                              // Khi đã tồn tại file đã copy thì
            $new_file_name = $file_name . "-copy({$k}).";                                    // Gán file copy
            $k ++;
            $new_upload_file = $upload_dir . $new_file_name . $file_type;
        }
        $upload_file = $new_upload_file;
    }
    if (move_uploaded_file($_FILES['file']['tmp_name'], $upload_file)) {
        return $upload_file;
    }
    return false;
}