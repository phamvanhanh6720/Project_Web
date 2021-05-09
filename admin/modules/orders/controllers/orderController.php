<?php
function construct(){
    load('helper', 'format');
    load_model('index');
}
//===============
//  INDEX  ORDER
//===============
function indexAction(){
    load_view('orderIndex');
}
//===============
//  APPLY  ORDER
//===============
function apply_ordersAction(){
        if(isset($_POST['sm_action'])){
            Global $error;
            if(is_login() && check_role($_SESSION['user_login']) == 1){
                $error = array();
                if(!empty($_POST['checkItem'])){
                    $list_order_code = $_POST['checkItem'];
                }
                if(!empty($_POST['actions'])){
                    if($_POST['actions'] == 1){
                        if(isset($_POST['checkItem'])){
                            foreach($list_order_code as $order_code){
                            delete_order($order_code); 
                            delete_product_order($order_code); 
                            }
                            if(isset($_GET['value'])){
                                load_view('search_orders');
                            } else{
                                load_view('orderIndex');
                            };
                        } else{
                            $error['select'] = "Bạn chưa lựa chọn đơn hàng cần bỏ vào thùng rác";
                            if(isset($_GET['value'])){
                                load_view('search_orders');
                            } else{
                                load_view('orderIndex');
                            };
                        }
                    }
                } else{
                    $error['select'] = 'Bạn chưa lựa chọn tác vụ';
                    if(isset($_GET['value'])){
                        load_view('search_orders');
                    } else{
                        load_view('orderIndex');
                    };
                }
            } else{
                $error['select'] = "Bạn không có quyền thực hiện thao tác này!";
                if(isset($_GET['value'])){
                    load_view('search_orders');
                } else{
                    load_view('orderIndex');
                };
            }
        }
    if(isset($_GET['value'])){
        load_view('search_orders');
    } else{
        load_view('orderIndex');
    };
} 
//=============
//DETAIL ORDER
//=============
function detail_orderAction(){
    load_view('detail_order');
}
# situation order
function situationAction(){
    $order_id = $_GET['order_id'];
    $order_status = get_info_order('order_status', $order_id);
    // echo $order_status;
    if(isset($_POST['sm_status'])){
        Global $error, $data;
        $error = array();
        if(!empty($_POST['status'])){
            if($_POST['status'] == 1){
                if($order_status == 'Chờ duyệt'){
                    $error['transport'] = 'Bạn cần thay đổi trạng thái đơn hàng trước';
                } else{
                    $data = array(
                        'order_status'=> 'Chờ duyệt',
                    );     
                    update_order($data, $order_id);  
                    $error['transport'] = 'Cập nhật trạng thái đơn hàng thành công';
                }
            } else if($_POST['status'] == 2){
                if($order_status == 'Đang vận chuyển'){
                    $error['transport'] = 'Bạn cần thay đổi trạng thái đơn hàng trước';
                } else{
                    $data = array(
                        'order_status'=> 'Đang vận chuyển',
                    );
                    update_order($data, $order_id);  
                    $error['transport'] = 'Cập nhật trạng thái đơn hàng thành công';
                }
            } else {
                if($order_status == 'Thành công'){
                    $error['transport'] = 'Bạn cần thay đổi trạng thái đơn hàng trước';
                } else{
                    $data = array(
                        'order_status'=> 'Thành công',
                    );
                    update_order($data, $order_id);
                    $error['transport'] = 'Cập nhật trạng thái đơn hàng thành công';
                }
            }        
        }
    }
    load_view('detail_order');
}
//=============
//UPDATE ORDER
//=============
function update_orderAction(){
        global $error, $old_customer_name, $old_num_total, $old_phone, $old_email, $old_payment, $old_status, $old_address, $old_total_price, $code, $total_price, $email, $customer_name, $phone, $address, $num_total, $payment, $status;
        if(isset($_GET['order_id'])){
            $order_id = $_GET['order_id'];
        }
        if (isset($_POST['btn-update-order'])) {
            $error = array();
            // Check customer_name
            if (empty($_POST['customer_name'])) {
                $error['customer_name'] = 'Không được để trống Họ và tên khách hàng';
            } else {
                if (!(strlen($_POST['customer_name']) >= 6 && strlen($_POST['customer_name']) <= 32)) {
                    $error['customer_name'] = 'Họ và tên từ 6 đến 32 ký tự';
                } else {
                    $old_customer_name = get_info_order('customer_name', $order_id);
                    $customer_name = $_POST['customer_name'];
                }
            }
            // Check num order
            if (empty($_POST['num_total'])) {
                $error['num_total'] = 'Không được để trống số sản phẩm';
            } else if(is_number($_POST['num_total'])) {
                $old_num_total = get_info_order('num_total', $order_id);
                $num_total = $_POST['num_total'];
            } else{
                $error['num_total'] = 'Bạn cần nhập đúng định dạng số sản phẩm';
            }
            // Check total_price
            if (empty($_POST['total_price'])) {
                $error['total_price'] = 'Không được để trống tổng đơn hàng';
            } else if(is_number($_POST['total_price'])) {
                $old_total_price = get_info_order('total_price', $order_id);
                $total_price = $_POST['total_price'];
            } else{
                $error['total_price'] = 'Bạn cần nhập đúng định dạng';
            }
            // Check address
            if (empty($_POST['address'])) {
                $error['address'] = 'Không được để trống địa chỉ khách hàng';
            } else{
                $old_address = get_info_order('address', $order_id);
                $address = $_POST['address'];
            }
            // Check email
            if (empty($_POST['email'])) {
                $error['email'] = 'Không được để trống email';
            } else{
                $old_email = get_info_order('email', $order_id);
                $email = $_POST['email'];
            }
            // Check phone
            if (empty($_POST['phone'])) {
                $error['phone'] = 'Không được để trống số điện thoại';
            } else{
                $old_phone = get_info_order('phone', $order_id);
                $phone = $_POST['phone'];
            }
            //check payment
            if (!empty($_POST['payment'])) {
                $old_payment = get_info_order('payment', $order_id);
                $payment = show_payment($_POST['payment']);
                // echo $payment;
            }
             //check status
             if (!empty($_POST['status'])) {
                $old_status = get_info_order('order_status', $order_id);
                $status = show_status($_POST['status']);
            }
            // check not change
            if(($customer_name == $old_customer_name) && ($num_total == $old_num_total) && ($total_price == $old_total_price) && ($address == $old_address) && ($phone == $old_phone) && ($email == $old_email) && ($payment == $old_payment) && ($status == $old_status)){
                $error['order'] = "Đơn hàng chưa có thay đổi gì!";
           } 
            // check not error
            if (empty($error)) {
                $data = array(
                    'total_price' => $total_price,
                    'order_status' => $status,
                    'payment' => $payment,
                    'edit_date' => date('d/m/y h:m'),
                    'customer_name' => $customer_name,
                    'address' => $address,
                    'email' => $email,
                    'phone' => $phone,
                    'num_total' => $num_total,
                    );
                update_order($data, $order_id);
                $error['order'] = "Cập nhật đơn hàng thành công"."<br>"."<a href='?mod=orders&controller=order&action=index'>Trở về danh sách ĐƠN HÀNG</a>"; 
            }
        }
    load_view('update_order');
}
//===============
// DELETE ORDER
//===============
function delete_orderAction(){
    global $num_order;
    $order_code = $_GET['order_code'];
    $phone = get_info_order_by_order_code('phone', $order_code);
    delete_order($order_code);
    // delete_product_order($order_code);
    $num_order = get_num_order_by_phone($phone);
    if($num_order == 0){
        delete_customers($phone);
    }
    load_view('orderIndex');
}
//================
// SEARCH ORDER
//================

function search_ordersAction(){
    global $error, $value, $num_page;
    if (isset($_GET['sm_s'])) {
        if(!empty($_GET['value'])){
            $value = $_GET['value'];
            $num_per_page = 3;
            #Tổng số bản ghi
            $list_orders_all = db_search_all_orders($value);
            $total_row = count($list_orders_all);
            #Số trangs
            $num_page = ceil($total_row / $num_per_page);
            load_view('search_orders');
        } else{
            $error['error'] = 'Bạn cần nhập thông tin ĐƠN HÀNG cần tìm kiếm!';
            load_view('orderIndex');
        }
    }
}
function result_searchAction(){
    global $value;
    if(!empty($_GET['value'])){
        $value = $_GET['value'];
    }
    load_view('search_orders');
}