<?php
get_header();
$mod = $_GET['mod'];
$action = $_GET['action'];
// echo($mod);
// echo("<br>");
// echo($action);
#Số bản ghi/trang
$num_per_page = 5;
$list_num_page = db_num_page('tbl_posts', $num_per_page);
#Tổng số bản ghi
$total_row = db_num_rows("SELECT* FROM  `tbl_posts`");

#Số trang
$num_page = ceil($total_row / $num_per_page);

#chỉ số bắt đầu của trang
$page_num = (int) 1;
$start = ($page_num - 1) * $num_per_page;
$order_num = $start;
$list_posts = get_posts($start, $num_per_page);
?>
<div id="main-content-wp" class="clearfix blog-page">
    <div class="wp-inner">
        <div class="secion" id="breadcrumb-wp">
            <div class="secion-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="" title=""><?php echo get_title($mod, $action) ?></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-content fl-right">
            <div class="section" id="list-blog-wp">
                <div class="section-head clearfix">
                    <h3 class="section-title">Blog</h3>
                </div>
                <div id="result_post">
                    <div class="section-detail">
                    <?php if (!empty($list_posts)) {
                        $error = array();
                        ?>
                        <ul class="list-item">
                            <?php foreach ($list_posts as $post) {
                            ?> 
                            <li class="clearfix">
                                <a href="<?php echo $post['slug']?>-<?php echo $post['post_id']?>-blog.html" title="" class="thumb fl-left">
                                    <img src="admin/<?php echo $post['post_thumbnail'] ?>" alt="">
                                </a>
                                <div class="info fl-right">
                                    <a href="<?php echo $post['slug']?>-<?php echo $post['post_id']?>-blog.html" title="" class="title"><?php echo $post['title'] ?></a>
                                    <span class="create-date"><?php echo $post['created_date'] ?></span>
                                    <p class="desc"><?php echo $post['post_desc'] ?></p>
                                </div>
                            </li>
                            <?php
                            }
                            ?>
                        </ul>
                        <?php
                        } else {
                            $error['post'] = "Hiện tại không có bài viết nào!";
                        ?>
                            <p class="error"><?php echo  $error['post'] ?> </p>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="section" id="paging-wp">
                        <div class="section-detail">
                            <ul class="list-item clearfix" id='paging-post'>
                                <?php
                                    echo get_pagging_post($num_page, $page_num);
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php get_sidebar();?>
    </div>
</div>
<?php
get_footer();
?>




