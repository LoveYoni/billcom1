<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);  //에러 발생시 표시하기 위한 부분

include("firstcon.php");

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start();

$g_name = $g_pw = "";
$g_startTime = "";

$g_name = $_POST['uname'];
$g_pw = $_POST['psw'];
$start_date_time = mktime(date("H")+9, date("i"), date("s"), date("m"), date("d"), date("Y"));
$now_date = date("Y-m-d", $start_date_time);
$now_time = date("H:i:s", $start_date_time);

$sql_logout = "SELECT * FROM bill_student WHERE bill_name = '$g_name' and bill_pw = '$g_pw'";
$result_logout = mysqli_query($conn, $sql_logout);
$result_logout = mysqli_num_rows($result_logout);

if($result_logout) {
        $_SESSION['login_user']=$g_name;
        $sql_select = "SELECT * FROM student_study WHERE s_name = '$g_name' AND s_pw = '$g_pw' AND today_date = '$now_date'";
        $result_select = mysqli_query($conn, $sql_select);

        if($result_select) {
          $sql_update = "UPDATE student_study SET end_time = '$now_time' WHERE s_name = '$user'";
          $result_update = mysqli_query($conn, $sql_update);

          if($result_update) { //업데이트 성공 시 study_time 반환
            while($row = mysqli_fetch_assoc($result_select)) {
              $study_time = (strtotime($row['end_time']) - strtotime($row['start_time']));
              $study_Hour = $study_time / 3600;
              $study_Minute = $study_time / 60;
              $study_Second = $study_time % 60;

              $time = mktime($study_Hour, $study_Minute, $study_Second, date("m"), date("d"), date("Y"));
              $timestamp = date("Y-m-d H:i:s", $time);
            }

            $sqltime = "UPDATE student_study SET study_time = '$timestamp' WHERE s_name = '$user'";
            $resulttime = mysqli_query($conn, $sqltime);

            if($resulttime) {
              echo "<script> alert('".(int)$study_Hour."시 ".(int)$study_Minute."분 ".(int)$study_Second."초 경과하였습니다.');</script>";
            }
          }
        }

        unset($_SESSION['login_user']);
        session_destroy();

        echo "<meta http-equiv='refresh' content='0; url=http://192.168.0.233/gayeon_index.html'>";

        exit();
}




else {
    echo "<script> alert('아이디 혹은 비밀번호를 확인하세요!');</script>";
    echo "<meta http-equiv='refresh' content='0; url=login.html'>";
}

mysqli_close($conn);


?>
