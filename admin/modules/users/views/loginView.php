
<html>
    <head>
        <title>Đăng nhập</title>
        <link href="public/reset.css" rel="stylesheet" type="text/css"/>
        <link href="public/login.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="wrapper">
            <div id="wp-form-login">
                <h1 id="head-form">ĐĂNG NHẬP</h1>
                <form id="form-login" action="" method="POST">
                    <label for='username'>Tên đăng nhập</label>
                    <input type="text" name='username' id="username" placeholder="Username" value="<?php  echo set_value('username') ?>">
                    <?php echo form_error('username') ?>
                    <label for='password'>Mật khẩu</label>
                    <input type="password" name='password' id="password" placeholder="Password">
                    <?php echo form_error('password') ?>
                    <?php echo form_error('acount') ?>
                   
                    <input type="submit" id="btn-login" name='btn-login' value="Đăng nhập">
                    <input type="checkbox" name='remember-me'><span id="remember-me">Ghi nhớ đăng nhập</span><br>

                </form>
            </div>    
        </div>
    </body>
</html>
