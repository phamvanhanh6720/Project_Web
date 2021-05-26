# Project_Web - Website bán đồ công nghệ
- Chức năng chính:<br/>
+ Khách hàng tìm kiếm, xem, đặt hàng như các website thương mại điện tử khác<br/>
+ Người quản trị website quản lý sản phẩm, quản lý đơn hàng, quản lý khách hàng<br/>

# Download và install các công cụ dưới đây:
 - [Netbean 8.2](https://mirror.downloadvn.com/apache/netbeans/netbeans/12.0/Apache-NetBeans-12.0-bin-windows-x64.exe)<br/>
 - Hoặc sử dụng [Visual Studio Code](https://code.visualstudio.com/)<br/>
 - Phần mềm web server, mysql [XAMPP](https://www.apachefriends.org/download.html)<br/>
 - Phần mềm quản lý mã nguồn mở [Github](https://git-scm.com/downloads)<br/>

# Add Libraries
(I) Trong project sử dụng 1 plugin là "ckeditor" giúp soạn thảo nội dung cho sản phẩm, bài viết (vì nội dung bài viết là khác nhau cho từng đối tượng, nên không thể style css cho từng bài). Còn lại đều được xây dựng bằng html, css, javascript, php core. Không sử dụng framework hay thư viện hỗ trợ code khác.<br/>
    1 - Download thư viện: https://drive.google.com/file/d/1uqEJeCjIlJpp7uJXV4hSZHaquDsdxgjv/view?usp=sharing<br/>
    2 - Giải nén file tại admin/public/js<br/>

# Các bước chạy project
1. Khởi động phần mềm XAMPP (nếu bị lỗi port có thể xem tại [đây](https://hoangluyen.com/huong-dan-xu-ly-loi-port-xampp-nhanh-gon/))<br/>
Start Apache và MySQL trong xampp<br/>
2. Vào thư mục ../xampp/htdocs. Clone hoặc download project về đây.
3. Import database
- Vào link [localhost:8080/phpMyAdmin/](http://localhost:8080/phpmyadmin/) (có thể thay 8080 thành port khác tuỳ theo máy)
- Chọn new database, điền tên project là "cnweb_ismart"
- Sau đó Import file database trong project "cnweb_ismart.sql"<br/>
3. Truy cập localhost:8080/ismart.com để xem trang khách hàng, localhost:8080/ismart.com/admin để xem trang quản trị.
