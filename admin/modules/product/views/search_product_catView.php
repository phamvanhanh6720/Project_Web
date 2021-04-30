<?php
get_header();
#Số bản ghi/trang
$num_per_page = 5;
# search product and get list products
if(!empty($_GET['value'])){
    $value = $_GET['value'];
}
#Tổng số bản ghi tìm được
$list_product_cat_all = db_search_all_product_cats($value);
$total_row = count($list_product_cat_all);
#Số trang
$num_page = ceil($total_row / $num_per_page);

#chỉ số bắt đầu của trang
$page_num = (int) !empty($_GET['page_id']) ? $_GET['page_id'] : 1;
$start = ($page_num - 1) * $num_per_page;
$order_num = $start;
$list_product_cats = db_search_product_cats_by_page($value, $start, $num_per_page);

# danh mục đã đăng
$total_approved = db_num_rows("SELECT* FROM  `tbl_product_cat` Where `cat_status`= 'Approved' AND CONVERT(`title` USING utf8) LIKE '%$value%'");
# Danh mục chờ xét duyệt
$total_waitting = db_num_rows("SELECT* FROM  `tbl_product_cat` Where `cat_status`= 'Waitting...' AND CONVERT(`title` USING utf8) LIKE '%$value%'");
# Danh mục đã bị xóa
$total_trash = db_num_rows("SELECT* FROM  `tbl_product_cat` Where `cat_status`= 'Trash' AND CONVERT(`title` USING utf8) LIKE '%$value%'");
?>
<div id="main-content-wp" class="list-cat-page">
    <div class="wrap clearfix">
        <?php
        get_sidebar();
        ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Danh sách danh mục</h3>
                    <a href="?mod=product&controller=product_cat&action=add_cat" title="" id="add-new" class="fl-left">Thêm mới</a>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <div class="filter-wp clearfix">
                        <ul class="post-status fl-left">
                            <li class="all"><a href="">Tất cả <span class="count">(<?php echo $total_row ?>)</span></a> |</li>
                            <li class="publish"><a href="">Đã đăng <span class="count">(<?php echo $total_approved ?>)</span></a> |</li>
                            <li class="pending"><a href="">Chờ xét duyệt <span class="count">(<?php echo $total_waitting ?>)</span></a></li>
                            <li class="trash"><a href="">Thùng rác <span class="count">(<?php echo $total_trash ?>)</span></a></li>
                        </ul>
                        <form method="GET" class="form-s fl-right" action="">
                            <input type="hidden" name="mod" value="product">
                            <input type="hidden" name="controller" value="product_cat">
                            <input type="hidden" name="action" value ="search_product_cat">
                            <input type="text" name="value" id="s"  value="<?php echo set_value('value') ?>">
                            <input type="submit" name="sm_s" value ="Tìm kiếm">
                            <?php echo form_error('error')?>
                        </form>
                    </div>
                    <form method="POST" action="?mod=product&controller=product_cat&action=apply_product_cats&page_id=<?php echo $page_num;?>&value=<?php if(!empty($value)){ echo $value;}?>">
                        <div class="actions">
                            <div class="form-actions">
                                <select name="actions">
                                <option value="0">Tác vụ</option>
                                    <option <?php if (isset($_POST['actions']) && $_POST['actions'] == 1) echo "selected='selected'"; ?> value="1">Công khai</option>
                                    <option <?php if (isset($_POST['actions']) && $_POST['actions'] == 2) echo "selected='selected'"; ?> value="2">Chờ duyệt</option>
                                    <option <?php if (isset($_POST['actions']) && $_POST['actions'] == 3) echo "selected='selected'"; ?> value="3">Bỏ vào thủng rác</option>
                                </select>
                                <input type="submit" name="sm_action" value="Áp dụng">
                                <?php echo form_error('select')?>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table list-table-wp">
                                <thead>
                                    <tr>
                                        <td><input type="checkbox" name="checkAll" id="checkAll"></td>
                                        <td><span class="thead-text">STT</span></td>
                                        <td><span class="thead-text">Tiêu đề</span></td>
                                        <!-- <td><span class="thead-text">Thứ tự</span></td> -->
                                        <td><span class="thead-text">Trạng thái</span></td>
                                        <td><span class="thead-text">Người tạo</span></td>
                                        <td><span class="thead-text">Ngày tạo</span></td>
                                        <td><span class="thead-text">Người sửa</span></td>
                                        <td><span class="thead-text">Ngày sửa</span></td>
                                    </tr>
                                </thead>
                                <?php if (!empty($list_product_cats)) {
                                        $error = array();
                                        $order = 0;
                                    ?>
                                <tbody>
                                    <?php foreach ($list_product_cats as $product_cat) {
                                        $order++;
                                        ?>
                                    <tr>
                                        <td><input type="checkbox" name="checkItem[]" class="checkItem" value="<?php echo $product_cat['cat_id']?>"></td>
                                        <td><span class="tbody-text"><?php echo $order?></h3></span>
                                        <td class="clearfix">
                                            <div class="tb-title fl-left">
                                                <a href="" title=""><?php echo $product_cat['title']?></a>
                                            </div>
                                            <ul class="list-operation fl-right">
                                                <li><a href="?mod=product&controller=product_cat&action=update_cat&cat_id=<?php echo $product_cat['cat_id']?>" title="Sửa" class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
                                                <li><a href="?mod=product&controller=product_cat&action=delete_cat&cat_id=<?php echo $product_cat['cat_id']?>" title="Xóa" class="delete"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                                            </ul>
                                        </td>
                                        <!-- <td><span class="tbody-text"><?php if($product_cat['parent_id'] == 0){echo 0;} else{ echo get_num_order($product_cat['parent_id'], $list_product_cat_all);}?></span></td> -->
                                        <td><span class="tbody-text <?php echo text_color_status($product_cat['cat_status']) ?>"><?php echo $product_cat['cat_status']?></span></td>
                                        <td><span class="tbody-text"><?php echo $product_cat['creator']?></span></td>
                                        <td><span class="tbody-text"><?php echo $product_cat['created_date']?></span></td>
                                        <td><span class="tbody-text"><?php echo $product_cat['editor']?></span></td>
                                        <td><span class="tbody-text"><?php echo $product_cat['edit_date']?></span></td>
                                    </tr>
                                    <?php
                                        }
                                    ?>
                                </tbody>
                                <?php
                                    } else {
                                        $error['product_cat'] = "Không tồn tại danh mục sản phẩm nào!";
                                    ?>
                                        <p class="error"><?php echo  $error['product_cat'] ?> </p>
                                    <?php
                                    }
                                    ?>
                                <tfoot>
                                    <tr>
                                        <td><input type="checkbox" name="checkAll" id="checkAll"></td>
                                        <td><span class="tfoot-text">STT</span></td>
                                        <td><span class="tfoot-text-text">Tiêu đề</span></td>
                                        <!-- <td><span class="tfoot-text">Thứ tự</span></td> -->
                                        <td><span class="tfoot-text">Trạng thái</span></td>
                                        <td><span class="thead-text">Người tạo</span></td>
                                        <td><span class="thead-text">Ngày tạo</span></td>
                                        <td><span class="thead-text">Người sửa</span></td>
                                        <td><span class="thead-text">Ngày sửa</span></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
            <div class="section" id="paging-wp">
                <div class="section-detail clearfix">
                    <p id="desc" class="fl-left">Chọn vào checkbox để lựa chọn tất cả</p>
                    <ul id="list-paging" class="fl-right">
                        <?php
                            echo get_pagging($num_page, $page_num, "?mod=product&controller=product_cat&action=result_search&value=".$value);
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
?>