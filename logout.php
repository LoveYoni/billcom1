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

$sql_login = "SELECT * FROM bill_student WHERE bill_name = '$g_name' and bill_pw = '$g_pw'";
$result_login = mysqli_query($conn, $sql_login);
$result_login = mysqli_num_rows($result_login);

if($result_login) {
        $_SESSION['login_user']=$g_name;
        $sql_select = "SELECT * FROM student_study WHERE s_name = '$g_name' AND s_pw = '$g_pw' AND today_date = '$now_date'";
        $result_select = mysqli_query($conn, $sql_select);
        $result_row = mysqli_num_rows($result_select);

        if($result_row) { //해당 날짜 로그아웃의 경우
          $sql_update = "UPDATE student_study SET end_time = '$now_time' WHERE s_name = '$user'";
          $result_update = mysqli_query($conn, $sql_update);

          if($result_update) {
            //업데이트 성공 시 수강시간 스크립트
            echo "<script> alert('Logout Success!!');</script>";

            unset($_SESSION['login_user']);
            session_destroy();

             echo "<meta http-equiv='refresh' content='0; url=http://192.168.0.233/gayeon_index.html'>";

            exit();
          }
        }


      }


else {
    echo "<script> alert('아이디 혹은 비밀번호를 확인하세요!');</script>";
    echo "<meta http-equiv='refresh' content='0; url=http://192.168.0.66/logout.html'>";
}

//echo "<meta http-equiv='refresh' content='0; url=http://192.168.0.233/gayeon_index.html'>";
mysqli_close($conn);


?>
