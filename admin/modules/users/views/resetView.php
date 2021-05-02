<?php
get_header();
?>
<div id="main-content-wp" class="change-pass-page">
    <div class="section" id="title-page">
        <div class="clearfix">
            <a href="?page=add_cat" title="" id="add-new" class="fl-left">Thêm mới</a>
            <h3 id="index" class="fl-left">ĐỔI MẬT KHẨU</h3>
        </div>
    </div>
    <div class="wrap clearfix">
        <?php
        get_sidebar('user');
        ?>
        <div id="content" class="fl-right">
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <form method="POST">
                        <?php echo form_error('change-pass') ?>

                        <label for="old-pass">Mật khẩu cũ</label>
                        <input type="password" name="pass-old" id="pass-old">
                        <?php echo form_error('pass-old') ?>
                        <label for="new-pass">Mật khẩu mới</label>
                        <input type="password" name="pass-new" id="pass-new">
                        <?php echo form_error('pass-new') ?>
                        <label for="confirm-pass">Xác nhận mật khẩu</label>
                        <input type="password" name="confirm-pass" id="confirm-pass">
                        <?php echo form_error('confirm-pass') ?>

                        <button type="submit" name="btn-submit" id="btn-submit">Đổi mật khẩu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
?>