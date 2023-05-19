<?php
  define('DB_SERVER', 'localhost');           //define('常數名稱','常數值'); refence:P6-2
  define('DB_USERNAME', 'detailed_agency');
  define('DB_PASSWORD', 'detailed_agency');                  //default NULL
  define('DB_NAME', 'detailed_agency');

  //connect to MySQL database
  $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);       //i => improvement PDO => PHP Data Objects
  // Check connection
  if ($link->connect_error) {
    die("連接失敗： " . $conn->connect_error);
  }
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 獲取提交的表單數據
    $comment = $_POST["comment"];
    $num_of_start = $_POST["num_of_start"];
    $user_id = 5;
    // to write
    //INSERT INTO your_table_name (user_id, num_of_start, date, comment)VALUES (4, 2, NOW(), '惠惠');
    // 構建 SQL 插入語句
    $sql = "INSERT INTO user_comment (user_id, num_of_start, date, comment) VALUES ('', '$num_of_start', NOW(), '$comment')";

  // 執行 SQL 插入語句
  if ($link->query($sql) === TRUE) {
  echo "數據插入成功";
  } else {
  echo "插入數據時出錯: " . $link->error;
  }

  // 關閉資料庫連接
  $link->close();
  // 輸出結果或進行其他操作
  echo "收到的評論：".$comment;
  echo "收到的 radio 值：".$num_of_star;

  // 重新導向到原始畫面
  header("Location: http://127.0.0.1/ggit/agency/detailed.php");
  exit; // 確保在重定向後立即終止腳本執行
}

?>