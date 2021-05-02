<?php
get_header();
$avatar = info_user('avatar');
?>
<div id="main-content-wp" class="info-account-page">
    <div class="section" id="title-page">
        <div class="clearfix">
            <a href="?mod=admins&action=add_cat" title="" id="add-new" class="fl-left">Thêm mới</a>
            <h3 id="index" class="fl-left">Cập nhật tài khoản</h3>
        </div>
    </div>
    <div class="wrap clearfix">
        <?php
        get_sidebar('user');
        ?>
        <div id="content" class="fl-right">
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <form method="POST" enctype="multipart/form-data">
                        <label for="full-name">Tên hiển thị</label>
                        <input type="text" name="fullname" id="fullname" value="<?php echo info_user('fullname') ?>">
                        <?php echo form_error('fullname') ?>
                        <label for="username">Tên đăng nhập</label>
                        <input type="text" name="username" id="username" placeholder="<?php echo info_user('username') ?>" readonly="readonly">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="<?php echo info_user('email') ?>">
                        <label for="tel">Số điện thoại</label>
                        <input type="tel" name="tel" id="tel" value="<?php echo info_user('tel') ?>">
                        <label for="address">Địa chỉ</label>
                        <textarea name="address" id="address"><?php echo info_user('address') ?></textarea>
                        <label for="role">Ảnh đại diện</label>
                        <div id="uploadFile">
                            <input type="file" name="file" id="upload-thumb" onchange="show_upload_image()">
                            <img id="upload-image" src="<?php if(!empty($avatar)){ echo $avatar;} else{ echo 'public/images/upload/img-thumb.png';} ?>">
                        </div>
                        <?php echo form_error('account') ?>
                        <button type="submit" name="btn-submit" id="btn-submit">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
?>