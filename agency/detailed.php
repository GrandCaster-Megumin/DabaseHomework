<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
  integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<!DOCTYPE html>
<html>

<head>
  <title>機頁頁面詳細</title>
  <style>
    header {
      background-color: #0f94ed;
      color: #fff;
      padding: 10px;
    }
  </style>
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
  // getAgencyInfo(目標欄位名稱,目標機構名稱,資料表)
  function getAgencyInfo($info,$agencyName, $link) {
    $sql = "SELECT $info FROM detailed_agency WHERE agency_name = '$agencyName'";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo " " . $row[$info] . " ";
        }
    }
  }
  global $commentresult;
  function wrstart($num_of_start) {
    $stars = str_repeat("★", $num_of_start);
    echo "<div class='col d-flex align-items-baseline'><h4>{$stars}</h4>";
  }
  function swapAgencycomment($agencyName, $link) {
    global $commentresult;
    $sql = "SELECT user_comment.num_of_start,user_comment.date,user_comment.comment FROM agency_comment INNER JOIN user_comment
        ON agency_comment.user_id = user_comment.user_id 
        WHERE agency_comment.agency_name = '$agencyName'";
    $commentresult = $link->query($sql);
  }
  function getAgencycomment($info) {
    global $commentresult;
    if ($commentresult !== null && $commentresult->num_rows > 0) {
      if($row =$commentresult->fetch_assoc())
      {
        wrstart($row['num_of_start']); // 輸出：★★★★★
        echo " " . date('Y-m-d', strtotime($row['date'])) . "</div> <div class='row d-flex align-items-baseline'>
        <p class='text-break'>{$row[$info]}</p></div>";
      }
    }
  }
  $post_agency = '冒險者之家';
  getAgencycomment('comment');
  getAgencycomment('comment');
  swapAgencycomment($post_agency, $link);
  ?>
</head>

<body >
  <header>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <h1>頁首預留區</h1>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
  </header>
  <div class="container" style="padding-top:1cm;">
    <div class="row">
      <div class="col-6 text-center">
        <h3>機構圖片</h3>
        <img id="img" class="img-fluid img-thumbnail" src="./test.gif" alt="機構沒圖片">
        <div class="container">
          <div class="row">
            <div class="col-6 d-flex justify-content-end">
              <input class="btn btn-primary " type="button" value="最新評論">
            </div>
            <div class="col-6 d-flex justify-content-start">
              <input class="btn btn-primary " type="button" value="最好評論">
            </div>
          </div>
          <div class="row  align-items-center"><!-- 垂直居中對齊 -->
            <div class="col-4">
              <img id="img" class="img-fluid img-thumbnail" src="./test.png" alt="機構沒圖片">
            </div>
            <div class="col-8">
              <div class="container">
              <div class="row">
                  <div class="row d-flex align-items-baseline">
                      <?php getAgencycomment('comment');?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row  align-items-center"><!-- 垂直居中對齊 -->
            <div class="col-4">
              <img id="img" class="img-fluid img-thumbnail" src="./test2.png" alt="機構沒圖片">
            </div>
            <div class="col-8">
              <div class="container">
                <div class="row">
                  <div class="row d-flex align-items-baseline">
                      <?php getAgencycomment('comment');?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row border border-dark">
            <div class="col">
              <form method="POST" action="testin.php">
                <div class="d-flex align-items-start p-1 starts">
                  <h3 id="start1">☆</h3>
                  <h3 id="start2">☆</h3>
                  <h3 id="start3">☆</h3>
                  <h3 id="start4">☆</h3>
                  <h3 id="start5">☆</h3>
                  <input type="hidden" name="num_of_start" id="num_of_start" value="5">
                  &nbsp;&nbsp;未評論為五顆星<br>
                  <!-- ★ -->
                </div>
                <div class="form-floating" style="position: relative;">
                  <textarea class="form-control" name="comment" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px;"></textarea>
                  <label for="floatingTextarea2">寫評論?</label>
                  <button type="submit" style="position: absolute; bottom: 0; right: 0;">提交</button>
                </div>
             </form>
            </div>
          </div>
        </div>
      </div>
      <div class="col-6 ">
        <div class="row ">
          <div class="col  bg-info p-2 text-dark bg-opacity-25">
            <p class="">機構名稱:<?php getAgencyInfo("agency_name",$post_agency,$link);?></p>
          </div>
        </div>
        <div class="row">
          <div class="col  bg-info p-2 text-dark bg-opacity-10">
            <p class="">地址:<?php getAgencyInfo("agency_address",$post_agency,$link);?></p>
          </div>
        </div>
        <div class="row">
          <div class="col-7  bg-info p-2 text-dark bg-opacity-25">
            <p class="">連絡電話:<?php getAgencyInfo("agency_phone",$post_agency,$link);?></p>
          </div>
        </div>
        <div class="row">
          <div class="col-3  bg-info p-1 text-dark bg-opacity-10">
            <p class="">收治類型:</p>
          </div>
          <div class="col-1 ">
          </div>
          <div class="col-3  bg-info p-1 text-dark bg-opacity-10">
            <p class="">對象:</p>
          </div>
        </div>
        <div class="row ">
          <div class="col-3  bg-info p-1 text-dark bg-opacity-25">
            <p class="">收治年紀:<?php getAgencyInfo("age_start",$post_agency,$link);?>-<?php getAgencyInfo("age_end",$post_agency,$link);?></p>
          </div>
          <div class="col-1 ">
          </div>
          <div class="col-3  bg-info p-1 text-dark bg-opacity-25">
            <p class="">收治人數:<?php getAgencyInfo("num_people",$post_agency,$link);?></p>
          </div>
        </div>
        <div class="row">
          <div class="col-7  bg-info p-2 text-dark bg-opacity-10">
            <p class="">縣市政府合作:</p>
          </div>
        </div>
        <div class="row" style="height: 300;">
          <div class="col  text-center bg-info p-2 text-dark bg-opacity-25">
            <p class="">詳細資訊:<br><?php getAgencyInfo("agency_detailed",$post_agency,$link);?>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
<script>
  start_1 = document.getElementById("start1")
  start_2 = document.getElementById("start2")
  start_3 = document.getElementById("start3")
  start_4 = document.getElementById("start4")
  start_5 = document.getElementById("start5")
  let enableMouseEvents = true;
  let num_of_star=5
  //---分隔線滑鼠移動部分
  start_1.addEventListener("mouseover", function () {
    if (enableMouseEvents) {
      start_1.textContent = "★";
    }

  });
  start_1.addEventListener("mouseout", function () {
    if (enableMouseEvents) {
      start_1.textContent = "☆";
    }

  });
  start_2.addEventListener("mouseover", function () {
    if (enableMouseEvents) {
      start_1.textContent = "★";
      start_2.textContent = "★";
    }

  });
  start_2.addEventListener("mouseout", function () {
    if (enableMouseEvents) {
      start_1.textContent = "☆";
      start_2.textContent = "☆";
    }

  });
  start_3.addEventListener("mouseover", function () {
    if (enableMouseEvents) {
      start_1.textContent = "★";
      start_2.textContent = "★";
      start_3.textContent = "★";
    }


  });
  start_3.addEventListener("mouseout", function () {
    if (enableMouseEvents) {
      start_3.textContent = "☆";
      start_1.textContent = "☆";
      start_2.textContent = "☆";
    }

  });
  start_4.addEventListener("mouseover", function () {
    if (enableMouseEvents) {
      start_4.textContent = "★";
      start_1.textContent = "★";
      start_2.textContent = "★";
      start_3.textContent = "★";
    }

  });
  start_4.addEventListener("mouseout", function () {
    if (enableMouseEvents) {
      start_4.textContent = "☆";
      start_3.textContent = "☆";
      start_1.textContent = "☆";
      start_2.textContent = "☆";
    }

  });
  start_5.addEventListener("mouseover", function () {
    if (enableMouseEvents) {
      start_5.textContent = "★";
      start_4.textContent = "★";
      start_1.textContent = "★";
      start_2.textContent = "★";
      start_3.textContent = "★";
    }

  });
  start_5.addEventListener("mouseout", function () {
    if (enableMouseEvents) {
      start_5.textContent = "☆";
      start_4.textContent = "☆";
      start_3.textContent = "☆";
      start_1.textContent = "☆";
      start_2.textContent = "☆";
    }

  });
  //-------------分隔線點擊時
  start_1.addEventListener("click", function () {
    enableMouseEvents = false;
    start_1.textContent = "★";
    start_2.textContent = "☆";
    start_3.textContent = "☆";     
    start_4.textContent = "☆";
    start_5.textContent = "☆";
    num_of_star=1;
    document.getElementById("num_of_start").value = num_of_star;
  });
  start_2.addEventListener("click", function () {
    enableMouseEvents = false;
    start_1.textContent = "★";
    start_2.textContent = "★";
    start_3.textContent = "☆";     
    start_4.textContent = "☆";
    start_5.textContent = "☆";
    num_of_star=2
    document.getElementById("num_of_start").value = num_of_star;
  });
  start_3.addEventListener("click", function () {
    enableMouseEvents = false;
    start_1.textContent = "★";
    start_2.textContent = "★";
    start_3.textContent = "★";
    start_4.textContent = "☆";
    start_5.textContent = "☆";
    num_of_star=3
    document.getElementById("num_of_start").value = num_of_star;
  });
  start_4.addEventListener("click", function () {
    enableMouseEvents = false;
    start_4.textContent = "★";
    start_1.textContent = "★";
    start_2.textContent = "★";
    start_3.textContent = "★";
    start_5.textContent = "☆";
    num_of_star=4
    document.getElementById("num_of_start").value = num_of_star;
  });
  start_5.addEventListener("click", function () {
    enableMouseEvents = false;
    start_5.textContent = "★";
    start_4.textContent = "★";
    start_1.textContent = "★";
    start_2.textContent = "★";
    start_3.textContent = "★";
    num_of_star=5
    document.getElementById("num_of_start").value = num_of_star;
  });
</script>

<?php
$sql = "SELECT agency_address FROM detailed_agency WHERE agency_name = '冒險者之家' ";
$result = $link->query($sql);
if ($result->num_rows > 0) {
  // 輸出每個機構名稱到 <p> 標籤中
  while ($row = $result->fetch_assoc()) {
      echo "<p class='agency-name'>機構名稱: " . $row["agency_address"] . "</p>";
  }
}


// 關閉資料庫連接
$link->close();

echo "php end";
?>