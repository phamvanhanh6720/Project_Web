<?php
function construct(){
    load_model('index');
}
function indexAction(){
    load_view('show');
}
function add_cartAction(){
    add_cart();
    redirect_to('gio-hang.html');
}
function delete_cartAction(){
    $product_id = (int) $_GET['product_id'];
    delete_cart($product_id);
    load_view('show');
}
function update_cartAction(){
    $product_id = $_POST['product_id'];
    $qty = $_POST['qty'];
    $item = get_info_product($product_id);
    if(isset($_SESSION['cart']) && array_key_exists($product_id, $_SESSION['cart']['buy'])){
        #cập nhật số lượng
        $_SESSION['cart']['buy'][$product_id]['qty'] = $qty;
        #Cập nhật số tiền thanh toán
        $sub_total = $qty * $item['product_price_new'];
        $_SESSION['cart']['buy'][$product_id]['sub_total'] = $sub_total;
        #Cập nhật thông tin giỏ hàng
        update_info_cart();
        $infor_cart = get_info_cart();
        $total = $infor_cart['total'];
        $data = array(
            'sub_total'=> currency_format($sub_total),
            'total' => currency_format($total),
        );
        echo json_encode($data);
    }
}
function checkoutAction(){
    if(isset($_SESSION['cart']) && $_SESSION['cart']['info']['num_order'] > 0){
        load_view('checkout');
    } else{
        load_view('show');
    }
}
function orderAction(){
    global $error, $email, $fullname, $phone, $address, $province, $district, $commune, $note, $payment, $list_buy;
    if (isset($_POST['btn-order'])) {
        $error = array();
        // check fullname
        if (empty($_POST['fullname'])) {
            $error['info'] = 'Bạn cần nhập đầy đủ thông tin khách hàng';
        } else {
            if (!(strlen($_POST['fullname']) >= 2 && strlen($_POST['fullname']) <= 32)) {
                $error['fullname'] = 'Họ và tên từ 2 đến 32 ký tự';
            } else {
                $fullname = $_POST['fullname'];
            }
        }
        // check email
        if (empty($_POST['email'])) {
            $error['info'] = 'Bạn cần nhập đầy đủ thông tin khách hàng';
        } else {
            if (!is_email($_POST['email'])){
                $error['email'] = 'Bạn cần nhập Email đúng định dạng';
            } else{
                $email = $_POST['email'];
            }
        }
        // check address
        # check province
        if (empty($_POST['province'])) {
            $error['info'] = 'Bạn cần nhập đầy đủ thông tin khách hàng';
        } else {
            $province = $_POST['province'];
        }
        # check district
        if (empty($_POST['district'])) {
            $error['info'] = 'Bạn cần nhập đầy đủ thông tin khách hàng';
        } else {
            $district = $_POST['district'];
        }
        # check commune
        if (empty($_POST['commune'])) {
            $error['info'] = 'Bạn cần nhập đầy đủ thông tin khách hàng';
        } else {
            $commune = $_POST['commune'];
        }
        // check phone
        if (empty($_POST['phone'])) {
            $error['info'] = 'Bạn cần nhập đầy đủ thông tin khách hàng';
        } else {
            if (!is_phone($_POST['phone'])){
                $error['phone'] = 'Bạn cần nhập Số điện thoại đúng định dạng';
            } else{
                $phone = $_POST['phone'];
            }
        }
        // check note
        if (!empty($_POST['note'])) {
            $note = $_POST['note'];
        }
        // check payment-method
        if (empty($_POST['payment-method'])) {
            $error['payment'] = 'Bạn cần chọn hình thức thanh toán';
        } else {
            $payment = $_POST['payment-method'];
        }
        // check not error
        if (empty($error)) {
            $address = $commune.', '.$district.', '.$province;
            $data_order = array(
            'order_code' => 'DT'.time(),
            'num_total' => $_SESSION['cart']['info']['num_order'],
            'total_price' => $_SESSION['cart']['info']['total'],
            'order_status' => 'Chờ duyệt',
            'customer_name' => $fullname,
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
            'payment' => $payment,
            'note' => $note,
            'created_date' => date('d/m/Y H:i:s'),
            );
            insert_order($data_order);
            $data_customer = array(
                'customer_name' => $fullname,
                'email' => $email,
                'phone' => $phone,
                'address' => $address,
                'created_date' => date('d/m/Y H:i:s'),
            );
            $data_order_update = array(
                'customer_name' => $fullname,
                'email' => $email,
                'phone' => $phone,
                'address' => $address,
            );
            $num_customer = get_num_customer($phone);
            if($num_customer > 0){
                update_customer($data_customer, $phone);
                update_order_by_phone($data_order_update, $phone);
            } else{
                insert_customer($data_customer);
            }
            // get product
            $list_buy = get_list_by_cart();
            foreach($list_buy as $product){
                $data_products_order = array(
                    'order_code' => 'DT'.time(),
                    'product_qty' => $product['qty'],
                    'sub_total' => $product['sub_total'],
                    'product_id' => $product['product_id'],
                );
                insert_product_order($data_products_order);
            }
            $error['success'] = "Đặt hàng thành công!";
            unset($_SESSION['cart']);
        }
    load_view('checkout');
    }
}
//===================
// SELECT ADDRESS
//===================
# select district
function select_districtAction(){
    $select_district = '<option value="">-- Chọn Quận/Huyện --</option>';
    if(!empty($_POST['province'])){
        $province = $_POST['province'];
        $matp = get_matp_by_province($province);
        $list_district = db_fetch_array("SELECT* FROM `tbl_district` WHERE `matp` = '{$matp}'");
        foreach($list_district as $district){
            $select_district .= '
                <option value="'.$district['name'].'">'.$district['name'].'</option>
        ';
        }
    }
    echo $select_district;
}
# select commune
function select_communeAction(){
    $select_commune = '<option value="">-- Chọn Xã/Phường --</option>';
    if(!empty($_POST['district'])){
        $district = $_POST['district'];
        $maqh = get_matp_by_district($district);
        $select_commune = db_fetch_array("SELECT* FROM `tbl_commune` WHERE `maqh` = '{$maqh}'");
        foreach($select_commune as $commune){
            $select_commune .= '
                <option value="'.$commune['name'].'">'.$commune['name'].'</option>
        ';
        }
    }
    echo $select_commune;
}