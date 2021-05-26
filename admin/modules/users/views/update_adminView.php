<?php
get_header();
if(isset($_GET['admin_id'])){
   $admin_id = $_GET['admin_id'];
   $role = get_info_admin('role', $admin_id);
   $avatar = get_info_admin('avatar', $admin_id);
}
?>
<div id="main-content-wp" class="add-cat-page">
    <div class="wrap clearfix">
        <?php get_sidebar('user'); ?>
        <div id="content" class="fl-right">      
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Cập nhật Admin</h3>
                </div>
            </div>
            <div class="section" id="detail-update-admin">
                <div class="section-detail">
                    <form action="" method="POST" enctype="multipart/form-data"> 
                        <?php echo form_error('admin')?>
                        <label for="fullname">Họ và tên</label>
                        <input type="text" name="fullname" id="fullname" value="<?php echo get_info_admin('fullname', $admin_id) ?>">
                        <?php echo form_error('fullname')?>
                        <label for="username">Tên đăng nhập</label>
                        <input type="text" name="username" id="username" readonly="readonly" value="<?php echo get_info_admin('username', $admin_id) ?>">
                        <?php echo form_error('username')?>
                        <label for="password">Mật khẩu</label>
                        <input type="password" name="password" id="password" readonly="readonly">
                        <?php echo form_error('password')?>
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="<?php echo get_info_admin('email', $admin_id) ?>">
                        <?php echo form_error('email')?>
                        <label for="tel">Số điện thoại</label>
                        <input type="tel" name="tel" id="tel" value="<?php echo get_info_admin('tel', $admin_id) ?>">

                        <label for="address">Địa chỉ</label>
                        <input type="text" name="address" id="address" value="<?php echo get_info_admin('address', $admin_id) ?>">
                        <label for="role">Ảnh đại diện</label>
                        <div id="uploadFile">
                            <input type="file" name="file" id="upload-thumb" onchange="show_upload_image()">
                            <img id="upload-image" src="<?php if(!empty($avatar)){ echo $avatar;} else{ echo 'public/images/upload/img-thumb.png';} ?>">
                        </div>
                        <?php echo form_error('upload_image')?>
                        <label for="role">Phân quyền</label>
                        <select name = 'role'>
                            <option value="">--Chọn--</option>
                            <option <?php if(isset($role) && $role == '1') echo "selected='selected'"; ?> value="1">1</option>
                            <option <?php if(isset($role) && $role == '2') echo "selected='selected'"; ?> value="2">2</option>
                            <option <?php if(isset($role) && $role == '3') echo "selected='selected'"; ?> value="3">3</option>
                        </select>
                        <?php echo form_error('role')?>
                        <br>
                        <button type="submit" name="btn-update-admin" id="btn-submit">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
?>
