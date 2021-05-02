<?php
get_header();
?>
<div id="content">
    <h1>danh sách thành viên</h1>
    <table id="tbl_users">
            <thead>
               <tr>
                    <td>STT</td>
                    <td>Họ tên</td>
                    <td>Email</td>
                    <td>Tuổi</td>
                    <td>Thu nhập</td>
                </tr>
            </thead>
            <?php if(!empty($list_users)){
                $order = 0;
            ?>
            <tbody>
                <?php foreach($list_users as $user){
                    $order++
            ?>
                <tr>
                    <td><?php echo $order?></td>
                    <td><?php echo $user['fullname']?></td>
                    <td><?php echo $user['email']?></td>
                    <td><?php echo $user['age']?></td>
                    <td><?php echo currency_format($user['earn'], '$')?></td>
                </tr>
                <?php
                }
                ?>
            </tbody>
            <?php
            }
            ?>
            
        </table>
</div>

<!--<html>
    <head>
        <title>title</title>
    </head>
    <body>
        <h1>Danh sách thành viên</h1>
    </body>
</html>-->
<?php
get_footer();
?>




