<?php
function construct()
{
    load_model('index');
}
function info_accountAction()
{
    load('helper', 'image');
    global $fullname, $email, $tel, $address, $error, $avatar, $user;
    //Chuẩn hóa dữ liệu Login
    if (isset($_POST['btn-submit'])) {
        $error = array();
        $data = array();
        if (!empty($_POST['fullname'])) {
            if (!(strlen($_POST['fullname']) >= 6 && strlen($_POST['fullname']) <= 32)) {
                $error['fullname'] = 'Tên hiển thị yêu cầu từ 6 đến 32 ký tự';
            } else {
                $fullname = $_POST['fullname'];
                is_username($fullname);
                $data['fullname'] = $fullname;
            }
        }
        if (!empty($_POST['email'])) {
            $email = $_POST['email'];
            is_email($email);
            $data['email'] = $email;
        }
        if (!empty($_POST['tel'])) {
            $tel = $_POST['tel'];
            $data['tel'] = $tel;
        }

        if (!empty($_POST['address'])) {
            $address = $_POST['address'];
            $data['address'] = $address;
        }
        // check upload file
        if (isset($_FILES['file']) && !empty($_FILES['file']['name'])) {
            $type = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $size = $_FILES['file']['size'];
            if (!is_image($type, $size)) {
                $error['upload_image'] = "Kích thước hoặc kiểu ảnh không đúng";
            } else {
                $old_thumb = info_user('avatar');
                if (!empty($old_thumb)) {
                    delete_image($old_thumb);
                    $avatar = upload_image('public/images/upload/admins/', $type);
                    $data['avatar'] = $avatar;
                } else {
                    $avatar = upload_image('public/images/upload/admins/', $type);
                    $data['avatar'] = $avatar;
                }
            }
        } else {
            $avatar = info_user('avatar');
            $data['avatar'] = $avatar;
        }
        if (empty($error)) {
            if (!empty($data)) {
                $user = $_SESSION['user_login'];
                update_info_account($data, $user);
                $error['account'] = 'Cập nhật tài khoản thành công';
            } else {
                $error['account'] = 'Bạn cần nhập thông tin để cập nhật';
            }
        } else {
            print_r($error);
        }
    }
    load_view('info_account');
}


// Đổi mật khẩu
function resetAction()
{
    global $password, $error;
    //Chuẩn hóa dữ liệu Login
    if (isset($_POST['btn-submit'])) {
        $error = array();
        $password = info_user('password');

        if (empty($_POST['pass-old'])) {
            $error['pass-old'] = 'Bạn chưa nhập mật khẩu cũ';
        } else {
            $pass_old = $_POST['pass-old'];
            is_password($pass_old);
        }

        if (empty($_POST['pass-new'])) {
            $error['pass-new'] = 'Bạn chưa nhập mật khẩu mới';
        } else {
            if (!(strlen($_POST['pass-new']) >= 6 && strlen($_POST['pass-new']) <= 32)) {
                $error['pass-new'] = 'Mật khẩu yêu cầu từ 6 đến 32 ký tự';
            } else {
                $pass_new = $_POST['pass-new'];
                is_password($pass_new);
            }
        }

        if (empty($_POST['confirm-pass'])) {
            $error['confirm-pass'] = 'Bạn chưa xác nhận mật khẩu mới';
        } else {
            $confirm_pass = $_POST['confirm-pass'];
        }

        if (empty($error)) {
            if (md5($pass_old) != $password) {
                $error['pass-old'] = "Mật khẩu cũ chưa đúng";
            } else {
                if ($confirm_pass == $pass_new) {
                    $data = array(
                        'password' => md5($pass_new)
                    );
                    update_pass_new($data);
                    $error['change-pass'] = 'Bạn đã đổi mật khẩu thành công';
                } else {
                    $error['confirm-pass'] = 'Xác nhận mật khẩu mới chưa đúng';
                }
            }
        } else {
            print_r($error);
        }
    }
    load_view('reset');
}
// Thêm mới
function add_catAction()
{
    load_view('add_cat');
}
//Đăng nhập
function loginAction()
{
    global $username, $password, $error;
    //Chuẩn hóa dữ liệu Login
    if (isset($_POST['btn-login'])) {
        $error = array();
        if (empty($_POST['username'])) {
            $error['username'] = 'Bạn chưa nhập tên đăng nhập';
        } else {
            if (!(strlen($_POST['username']) >= 6 && strlen($_POST['username']) <= 32)) {
                $error['username'] = 'Username yêu cầu từ 6 đến 32 ký tự';
            } else {
                $username = $_POST['username'];
                is_username($username);
            }
        }
        if (empty($_POST['password'])) {
            $error['password'] = 'Bạn chưa nhập mật khẩu';
        } else {
            if (!(strlen($_POST['password']) >= 6 && strlen($_POST['password']) <= 32)) {
                $error['password'] = 'Mật khẩu yêu cầu từ 6 đến 32 ký tự';
            } else {
                $password = $_POST['password'];
                is_password($password);
            }
        }
        if (empty($error)) {
            if (check_login($username, $password)) {
                $_SESSION['is_login'] = true;
                $_SESSION['user_login'] = $username;
                //Chuyển hướng vào trong hệ thống
                if (isset($_POST['remember-me'])) {
                    setcookie('is_login', true, time() + 3600);
                    setcookie('user_login', $username, time() + 3600);
                }
                //Luư trữ phiên đăng nhập
                // update_active_user();
                update_active_admin();
                redirect_to("?mod=users&controller=team&action=index");
            } else {
                $error['acount'] = 'Tên đăng nhập hoặc mật khẩu không đúng';
            }
        } else {
            // print_r($error);
        }
    }
    load_view('login');
}

function logoutAction()
{
    global $username;
    // update_not_active_user();
    update_not_active_admin();
    setcookie('is_login', true, time() - 3600);
    setcookie('user_login', $username, time() - 3600);
    unset($_SESSION['is_login']);
    unset($_SESSION['user_login']);
    redirect_to("?mod=users&action=login");
    // load_view('login');
}
