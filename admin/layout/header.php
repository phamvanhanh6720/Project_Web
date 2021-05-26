<!DOCTYPE html>
<html>

<head>
    <title>Quản lý ISMART</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="public/css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="public/reset.css" rel="stylesheet" type="text/css" />
    <link href="public/style.css" rel="stylesheet" type="text/css" />
    <link href="public/main.css" rel="stylesheet" type="text/css" />
    <link href="public/responsive.css" rel="stylesheet" type="text/css" />

    <script src="public/js/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
    <script src="public/js/main.js" type="text/javascript"></script>
    <script src="public/js/app.js" type="text/javascript"></script>
    <script src="public/js/menu_login.js" type="text/javascript"></script>
</head>

<body>
    <div id="site">
        <div id="container">
            <div id="header-wp">
                <div class="wp-inner clearfix">
                    <a href="?mod=users&controller=team&action=index" title="" id="logo" class="fl-left">ADMIN</a>
                    <ul id="main-menu" class="fl-left">
                        <li>
                            <a href="?mod=pages&controller=index&action=index" title="">Trang</a>
                            <ul class="sub-menu">
                                <li>
                                    <a href="?mod=pages&controller=index&action=add_page" title="">Thêm mới</a>
                                </li>
                                <li>
                                    <a href="?mod=pages&controller=index&action=index" title="">Danh sách trang</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="?mod=post&controller=index&action=index" title="">Bài viết</a>
                            <ul class="sub-menu">
                                <li>
                                    <a href="?mod=post&controller=index&action=add_post" title="">Thêm mới</a>
                                </li>
                                <li>
                                    <a href="?mod=post&controller=index&action=index" title="">Danh sách bài viết</a>
                                </li>
                                <li>
                                    <a href="?mod=post&controller=post_cat&action=index" title="">Danh mục bài viết</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="?mod=product&action=index" title="">Sản phẩm</a>
                            <ul class="sub-menu">
                                <li>
                                    <a href="?mod=product&action=add_product" title="">Thêm mới</a>
                                </li>
                                <li>
                                    <a href="?mod=product&action=index" title="">Danh sách sản phẩm</a>
                                </li>
                                <li>
                                    <a href="?mod=product&controller=product_cat&action=index" title="">Danh mục sản phẩm</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="?mod=orders&controller=order&action=index" title="">Bán hàng</a>
                            <ul class="sub-menu">
                                <li>
                                    <a href="?mod=orders&controller=order&action=index" title="">Danh sách đơn hàng</a>
                                </li>
                                <li>
                                    <a href="?mod=orders&controller=customer&action=customer" title="">Danh sách khách hàng</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="?mod=menu&action=index" title="">Menu</a>
                        </li>
                    </ul>
                    <div id="dropdown-user" class="dropdown dropdown-extended fl-right">
                        <button class="dropdown-toggle clearfix" type="button" onclick="open_dropdown_menu()" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <div id="thumb-circle" class="fl-left">
                                <img src="<?php echo get_info_account('avatar') ?>">
                            </div>
                            <h3 id="account" class="fl-right"><?php echo get_info_account('fullname') ?></h3>
                        </button>
                        <ul class="dropdown-menu" style="display: none;">
                            <li><a href="?mod=users&action=info_account" title="Thông tin cá nhân">Thông tin tài khoản</a></li>
                            <li><a href="?mod=users&action=logout" title="Thoát">Thoát</a></li>
                        </ul>
                    </div>
                </div>
            </div>