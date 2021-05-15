<?php
if (isset($_POST['btn-reg-email'])) {
    $error = array();
    // check email
    if (empty($_POST['email'])) {
        $error['reg-email'] = 'Bạn cần nhập email';
    } else {
        if(is_exists('tbl_email_news', 'email', $_POST['email'])){
            $error['reg-email'] = '(*) Email đã tồn tại';
        } else{
            $email = $_POST['email'];
        }
    }
    // check not error
    if (empty($error)) {
        $data = array(
            'email' => $email,
            'reg_date' => date('d/m/Y H:i:s'),
        );
        insert_email($data);
        $error['reg-email'] = "Đăng ký thành công!";
    }
}
?>
<div id="footer-wp">
    <div id="foot-body">
        <div class="wp-inner clearfix">
            <div class="block" id="info-company">
                <h3 class="title">ISMART</h3>
                <p class="desc">ISMART luôn cung cấp luôn là sản phẩm chính hãng có thông tin rõ ràng, chính sách ưu đãi cực lớn cho khách hàng có thẻ thành viên.</p>
                <div id="payment">
                    <div class="thumb">
                        <img src="public/images/img-foot.png" alt="">
                    </div>
                </div>
            </div>
            <div class="block menu-ft" id="info-shop">
                <h3 class="title">Thông tin cửa hàng</h3>
                <ul class="list-item">
                    <li>
                        <p>Số 1 - Đại Cồ Việt - Hai Bà Trưng - Hà Nội</p>
                    </li>
                    <li>
                        <p>0981.932.985 - 0983.586.790</p>
                    </li>
                    <li>
                        <p>ismart_teamcnw@gmail.com</p>
                    </li>
                </ul>
            </div>
            <div class="block menu-ft policy" id="info-shop">
                <h3 class="title">Chính sách mua hàng</h3>
                <ul class="list-item">
                    <li>
                        <a href="" title="">Quy định - chính sách</a>
                    </li>
                    <li>
                        <a href="" title="">Chính sách bảo hành - đổi trả</a>
                    </li>
                    <li>
                        <a href="" title="">Chính sách hội viện</a>
                    </li>
                    <li>
                        <a href="" title="">Giao hàng - lắp đặt</a>
                    </li>
                </ul>
            </div>
            <div class="block" id="newfeed">
                <h3 class="title">Bảng tin</h3>
                <p class="desc">Đăng ký với chung tôi để nhận được thông tin ưu đãi sớm nhất</p>

            </div>
        </div>
    </div>
    <div id="foot-bot">
        <div class="wp-inner">
            <p id="copyright">© Bản quyền thuộc về team CNWeb | HUST_K63</p>
        </div>
    </div>
</div>
</div>
<div id="menu-respon">
    <a href="?page=home" title="" class="logo">VSHOP</a>
    <div id="menu-respon-wp">
        <ul class="" id="main-menu-respon">
            <li>
                <a href="home-1.html" title>Trang chủ</a>
            </li>
            <li>
                <a href="product-2.html" title>Sản phẩm</a>
            </li>
            <li>
                <a href="Blog-3.html" title>Blog</a>
            </li>
            <li>
                <a href="page-4.html" title>Giới thiệu</a>
            </li>
            <li>
                <a href="page-5.html" title>Liên hệ</a>
            </li>
        </ul>
    </div>
</div>
<div id="btn-top"><img src="public/images/icon-to-top.png" alt=""/></div>
<div id="fb-root"></div>
<script>(function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id))
            return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.8&appId=849340975164592";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
</body>
</html>