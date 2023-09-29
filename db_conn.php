
<?php
// kết nối theo kiểu PDO 
//tiết kiệm thời gian và làm cho việc chuyển đổi 
//Hệ quản trị cơ sở dữ liệu trở nên dễ dàng hơn, chỉ đơn giản là thay đổi Connection String
$sName = "localhost";
$uName = "root";
$pass = "";
$db_name = "blog_db";
try {
  $conn = new PDO(
    "mysql:host=$sName;dbname=$db_name",
    $uName,
    $pass
  );
  // kết nối thành công 
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //thiết lập chế độ báo lỗi cho PDO.
  //PDO = PHP Data Objects
} catch (PDOException $e) {
  echo "Connection failed : " . $e->getMessage();
}
