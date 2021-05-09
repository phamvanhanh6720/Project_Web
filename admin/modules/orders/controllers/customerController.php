<?php
function construct(){
    load('helper', 'format');
    load_model('index');
}
function customerAction(){
    load_view('customerIndex');
}
//=================
// DELETE CUSTOMERS
//=================
function delete_customersAction(){
    $phone = $_GET['phone'];
    $list_order_by_phone = get_list_order_by_phone($phone);
    delete_orders_by_phone($phone);
    delete_customers($phone);
    foreach($list_order_by_phone as $order){
        delete_product_order($order['order_code']);
    }
    load_view('customerIndex');
}
//=================
// APPLY CUSTOMERS
//=================
function apply_customersAction(){
    if(isset($_POST['sm_action'])){
        global $error;
        $error = array();
        if(!empty($_POST['checkItem'])){
            $list_customer_phone = $_POST['checkItem'];
        }
        if(!empty($_POST['actions'])){
            if($_POST['actions'] == 1){
                if(isset($_POST['checkItem'])){
                    foreach($list_customer_phone as $customer_phone){
                        $list_order_by_phone = get_list_order_by_phone($customer_phone);
                        delete_orders_by_phone($customer_phone);
                        delete_customers($customer_phone);
                        foreach($list_order_by_phone as $order){
                            delete_product_order($order['order_code']);
                        }
                    }
                    if(isset($_GET['value'])){
                        load_view('search_customers');
                    } else{
                        load_view('customerIndex');
                    }
                } else{
                    $error['select'] = "Bạn chưa lựa chọn khách hàng cần xóa";
                    if(isset($_GET['value'])){
                        load_view('search_customers');
                    } else{
                        load_view('customerIndex');
                    }
                }
            }
        } else{
            $error['select'] = "Bạn chưa lựa chọn tác vụ";
            if(isset($_GET['value'])){
                load_view('search_customers');
            } else{
                load_view('customerIndex');
            }
        }
    }
}
//================
//UPDATE CUSTOMER
//================
function update_customerAction(){
    global $error, $old_customer_name, $old_phone, $old_email, $old_address, $email, $customer_name, $phone_id, $address;
    if(isset($_GET['phone'])){
        $phone_id = $_GET['phone'];
    }
    if (isset($_POST['btn-update-customer'])) {
        $error = array();
        // Check customer_name
        if (empty($_POST['customer_name'])) {
            $error['customer_name'] = 'Không được để trống Họ và tên khách hàng';
        } else {
            if (!(strlen($_POST['customer_name']) >= 6 && strlen($_POST['customer_name']) <= 32)) {
                $error['customer_name'] = 'Họ và tên từ 6 đến 32 ký tự';
            } else {
                $old_customer_name = get_info_order_by_phone('customer_name', $phone_id);
                $customer_name = $_POST['customer_name'];
            }
        }
        // Check address
        if (empty($_POST['address'])) {
            $error['address'] = 'Không được để trống địa chỉ khách hàng';
        } else{
            $old_address = get_info_order_by_phone('address', $phone_id);
            $address = $_POST['address'];
        }
        // Check email
        if (empty($_POST['email'])) {
            $error['email'] = 'Không được để trống email';
        } else{
            $old_email = get_info_order_by_phone('email', $phone_id);
            $email = $_POST['email'];
        }
        // Check phone
        if (empty($_POST['phone'])) {
            $error['phone'] = 'Không được để trống số điện thoại';
        } else{
            $old_phone = get_info_order_by_phone('phone', $phone_id);
            $phone = $_POST['phone'];
        }
       
        // check not change
        if(($customer_name == $old_customer_name)&& ($address == $old_address) && ($phone == $old_phone) && ($email == $old_email)){
            $error['customer'] = "Đơn hàng chưa có thay đổi gì!";
        } 
        // check not error
        if (empty($error)) {
        $data = array(
            'customer_name' => $customer_name,
            'address' => $address,
            'email' => $email,
            'phone' => $phone,
            );
        // $list_customers = get_customer_update();
        // foreach($list_customers as $customer){
            update_customer_by_phone($data, $old_phone);
            update_order_by_phone($data, $old_phone);
        // }
        $error['customer'] = "Cập nhật khách hàng thành công"."<br>"."<a href='?mod=orders&controller=customer&action=customer'>Trở về danh sách KHÁCH HÀNG</a>"; 
        }
    }
load_view('update_customer');
}
//================
// SEARCH CUSTOMER
//================
function search_customersAction(){
    global $error, $value, $num_page;
    if (isset($_GET['sm_s'])) {
        if(!empty($_GET['value'])){
            $value = $_GET['value'];
            $num_per_page = 3;
            #Tổng số bản ghi
            $list_customers_all = db_search_all_customers($value);
            $total_row = count($list_customers_all);
            #Số trang
            $num_page = ceil($total_row / $num_per_page);
            load_view('search_customers');
        } else{
            $error['error'] = 'Bạn cần nhập thông tin KHÁCH HÀNG cần tìm kiếm!';
            load_view('customerIndex');
        }
    }
}
function result_searchAction(){
    global $value;
    if(!empty($_GET['value'])){
        $value = $_GET['value'];
    }
    load_view('search_customers');
}
?>