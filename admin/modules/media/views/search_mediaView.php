<?php
get_header();
# search post and get list medias
if(!empty($_GET['value'])){
    $value = $_GET['value'];
}
#Tổng số bản ghi tìm được
$list_search_all_medias = db_search_all_medias($value);
$total_row = count($list_search_all_medias);
?>
<div id="main-content-wp" class="list-product-page list-media">
    <div class="wrap clearfix">
        <?php
        get_sidebar();
        ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Danh sách media</h3>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <div class="filter-wp clearfix">
                        <ul class="post-status fl-left">
                            <li class="all"><a href="">Tất cả <span class="count">(<?php echo $total_row ?>)</span></a></li>
                        </ul>
                        <form method="GET" class="form-s fl-right" action="">
                            <input type="hidden" name="mod" value="media">
                            <input type="hidden" name="action" value ="search_medias">
                            <input type="text" name="value" id="s"  value="<?php echo set_value('value') ?>">
                            <input type="submit" name="sm_s" value ="Tìm kiếm">
                            <?php echo form_error('error')?>
                        </form>
                    </div>
                    <div class="actions">
                        <form method="GET" action="" class="form-actions">
                            <select name="actions">
                                <option value="0">Tác vụ</option>
                                <option <?php if (isset($_POST['actions']) && $_POST['actions'] == 1) echo "selected='selected'"; ?> value="1">Xóa</option>
                            </select>
                            <input type="submit" name="sm_action" value="Áp dụng">
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table class="table list-table-wp">
                            <thead>
                                <tr>
                                    <td><input type="checkbox" name="checkAll" id="checkAll"></td>
                                    <td><span class="thead-text">STT</span></td>
                                    <td><span class="thead-text">Hình ảnh</span></td>
                                    <td><span class="thead-text">Tên file</span></td>
                                    <td><span class="thead-text">Người tạo</span></td>
                                    <td><span class="thead-text">Ngày tạo</span></td>
                                    <td><span class="thead-text">Người sửa</span></td>
                                    <td><span class="thead-text">Ngày sửa</span></td>
                                </tr>
                            </thead>
                            <?php if(!empty($list_all_medias)){
                                $error = array();
                                ?>
                                <tbody>
                                                        <!-- ADMINS -->
                                    <td><span class="tbody-text text-success"><h3>ADMINS</h3></span><td>                                 
                                    <?php if(!empty($list_all_medias['admins'])){
                                        ?>
                                        <?php foreach ($list_all_medias['admins'] as $list_admins) {
                                        ?>
                                        <?php if(!empty($list_admins['avatar'])){
                                            $order++;
                                            ?>
                                            <tr>
                                            <td><input type="checkbox" name="checkItem[]" class="checkItem"></td>
                                            <td><span class="tbody-text"><?php echo $order ?></h3></span>
                                            <td>
                                                <div class="tbody-thumb">
                                                    <a href='<?php echo $list_admins['avatar'];?>'><img src="<?php echo $list_admins['avatar']?>" alt=""></a>
                                                </div>
                                            </td>
                                            <td class="clearfix">
                                                <div class="tb-title fl-left">
                                                    <a href="" title=""><?php echo basename($list_admins['avatar']) ?></a>
                                                </div>
                                                <ul class="list-operation fl-right">
                                                    <li><a href="" title="Sửa" class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
                                                    <li><a href="" title="Xóa" class="delete"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                                                </ul>
                                            </td>
                                            <td><span class="tbody-text"><?php echo $list_admins['creator']?></span></td>
                                            <td><span class="tbody-text"><?php echo $list_admins['reg_date']?></span></td>
                                            <td><span class="tbody-text"><?php echo $list_admins['editor']?></span></td>
                                            <td><span class="tbody-text"><?php echo $list_admins['edit_date']?></span></td>
                                        </tr>
                                            <?php
                                        }
                                        ?>
                                    <?php
                                        }
                                    ?> 
                                        <?php
                                    }
                                    ?>
                                </tbody>
                                <?php
                                    } else {
                                        $error['media'] = "Không tồn tại media nào!";
                                    ?>
                                        <p class="error"><?php echo  $error['media'] ?> </p>
                                    <?php
                                    }
                                    ?>
                            <tfoot>
                                <tr>
                                    <td><input type="checkbox" name="checkAll" id="checkAll"></td>
                                    <td><span class="thead-text">STT</span></td>
                                    <td><span class="thead-text">Hình ảnh</span></td>
                                    <td><span class="thead-text">Tên file</span></td>
                                    <td><span class="thead-text">Người tạo</span></td>
                                    <td><span class="thead-text">Ngày tạo</span></td>
                                    <td><span class="thead-text">Người sửa</span></td>
                                    <td><span class="thead-text">Ngày sửa</span></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="section" id="paging-wp">
                <div class="section-detail clearfix">
                    <p id="desc" class="fl-left">Chọn vào checkbox để lựa chọn tất cả</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
?>



