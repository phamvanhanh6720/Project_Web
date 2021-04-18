<?php

use Aws\Common\Facade\Glacier;
use Aws\GlobalAccelerator\GlobalAcceleratorClient;

function construct()
{
    load_model('index');
}
function indexAction()
{
    load_view('index');
}
function buy_nowAction()
{
    load_view('buy_now');
}
function orderAction()
{
    global $product_id, $error, $email, $fullname, $phone, $address, $province, $district, $commune, $note, $payment;
    $product_id = $_GET['product_id'];
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
            if (!is_email($_POST['email'])) {
                $error['email'] = 'Bạn cần nhập Email đúng định dạng';
            } else {
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
            if (!is_phone($_POST['phone'])) {
                $error['phone'] = 'Bạn cần nhập Số điện thoại đúng định dạng';
            } else {
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
                'order_code' => 'DT' . time(),
                'num_total' => 1,
                'total_price' => get_info_product('product_price_new', $product_id),
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
            if ($num_customer > 0) {
                update_customer($data_customer, $phone);
                update_order_by_phone($data_order_update, $phone);
            } else {
                insert_customer($data_customer);
            }
            // get product
            $data_products_order = array(
                'order_code' => 'DT' . time(),
                'product_qty' => 1,
                'sub_total' => get_info_product('product_price_new', $product_id),
                'product_id' => $product_id,
            );
            insert_product_order($data_products_order);
            $error['success'] = "Đặt hàng thành công!";
        }
        load_view('buy_now');
    }
}

//==================
// SEARCH PRODUCTS
//==================
function search_productsAction()
{
    global $value;
    if (isset($_POST['sm_s'])) {
        if (!empty($_POST['value'])) {
            $value = $_POST['value'];
            load_view('search_products', $value);
        } else {
            load_view('index');
        }
    } else {
        load_view('index');
    }
}

//==================
// SEARCH FILTER
//==================
function search_filterAction()
{
    load_view('search_products');
}

//======================
// PAGINATION SEARCH
//======================
function pagination_searchAction()
{
    $result_search = '';
    if (isset($_POST['cat_id'])) {
        $cat_id = $_POST['cat_id'];
        $cat = db_fetch_assoc("SELECT `title` FROM `tbl_product_cat` WHERE `cat_id` = '{$cat_id}'");
    }
    if (isset($_POST['value'])) {
        $value = $_POST['value'];
    }
    $query = "SELECT * FROM `tbl_products` WHERE `parent_cat` = '{$cat['title']}' AND (CONVERT(`product_title` USING utf8) LIKE '%$value %' OR  CONVERT(`product_code` USING utf8) LIKE '%$value %') ";
    # filter by arrange
    if (isset($_POST['arrange']) && !empty($_POST['arrange'])) {
        $arrange = $_POST['arrange'];
        if ($arrange == 1) {
            $query .= 'ORDER BY `product_title` ASC ';
        }
        if ($arrange == 2) {
            $query .= 'ORDER BY `product_title` DESC ';
        }
        if ($arrange == 3) {
            $query .= 'ORDER BY `product_price_new` DESC ';
        }
        if ($arrange == 4) {
            $query .= 'ORDER BY `product_price_new` ASC ';
        }
    }
    $list_searchs = db_fetch_array($query);
    # Pagination
    #Số bản ghi/trang
    $num_per_page = 8;
    #Tổng số bản ghi
    $total_row = count($list_searchs);
    #Số trang
    $num_page = ceil($total_row / $num_per_page);
    if (isset($_POST['page_num'])) {
        $page_num = (int) $_POST['page_num'];
        if ($_POST['page_num'] == '<<') {
            if ($page_num < 1) {
                $page_num = 1;
            } else {
                $page_num -= 1;
            }
        }
        if ($_POST['page_num'] == '>>') {
            if ($page_num = $num_page) {
                $page_num = $num_page;
            } else {
                $page_num += 1;
            }
        }
    } else {
        $page_num = 1;
    }
    $start = ($page_num - 1) * $num_per_page;
    $list_searchs_by_page = array_slice($list_searchs, $start, $num_per_page);
    $result_search .= '
        <div class="section-detail">
            <ul class="list-item clearfix">
    ';
    if (!empty($list_searchs_by_page)) {
        foreach ($list_searchs_by_page as $product) {
            $result_search .= '
            <li>
                <a href="?mod=product&action=detail_product&product_id=' . $product['product_id'] . '" title="" class="thumb">
                    <img src="admin/' . $product['product_thumb'] . '">
                </a>
                <a href="?mod=product&action=detail_product&product_id=' . $product['product_id'] . '" title="" class="product-name">' . $product['product_title'] . '</a>
                <div class="price">
                    <span class="new">' . currency_format($product['product_price_new']) . '</span>
                    <span class="old">' . currency_format($product['product_price_old']) . '</span>
                </div>
                <div class="action clearfix">
                    <a href="?mod=cart&action=add_cart&product_id=' . $product['product_id'] . '" title="Thêm giỏ hàng" class="add-cart fl-left">Thêm giỏ hàng</a>
                    <a href="?mod=home&action=buy_now&product_id=' . $product['product_id'] . '" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                </div>
            </li>
        ';
        }
    }
    $result_search .= '
                </ul>
            </div>';
    if (!empty($list_searchs_by_page)) {
        $result_search .= '
        <div class="section" id="paging-wp">
            <div class="section-detail">
                <ul class="list-item clearfix">
                  ' . get_pagging_search($num_page, $page_num, $cat_id, $value) . '
            </div>
        </div>
        ';
    }

    $data = array(
        'result_search' => $result_search,
    );
    echo json_encode($data);
}
