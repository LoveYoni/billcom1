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

$$sql_login = "SELECT * FROM bill_student WHERE bill_name = '$g_name' and bill_pw = '$g_pw'";
$result_login = mysqli_query($conn, $sql_login);
$result_login = mysqli_num_rows($result_login);

if($result_login) {
        $_SESSION['login_user']=$g_name;
        $sql_select = "SELECT * FROM student_study WHERE s_name = '$g_name' AND s_pw = '$g_pw' AND today_date = '$now_date'";
        $result_select = mysqli_query($conn, $sql_select);
        $result_row = mysqli_num_rows($result_select);

        if($result_row) { //해당 날짜에 중복 로그아웃의 경우
            echo "<script> alert('Logout same Date!!');</script>";
            echo "<meta http-equiv='refresh' content='0; url=http://192.168.0.233/gayeon_index2.html'>";
          }


        else {

          $sql_insert = "INSERT INTO student_study (s_name, s_pw, today_date, start_time, end_time, study_time) VALUES ('$g_name', '$g_pw', '$now_date', '$now_time', NULL, NULL)";
          $result_insert = mysqli_query($conn, $sql_insert);

          if($result_insert) {
            //echo "<script> alert('insert Success!!');</script>";
            echo "<meta http-equiv='refresh' content = '0; url=index2.html'>";
          }

          else {
            echo "<script> alert('Fail!!');</script>";
          }
        //  if(mysqli_query($conn, $sql_insert))  {
        //    echo "<meta http-equiv='refresh' content='0; url=index.html'>";
        //  }
        }
      }




else {
    echo "<script> alert('아이디 혹은 비밀번호를 확인하세요!');</script>";
    echo "<meta http-equiv='refresh' content='0; url=login.html'>";
}

//echo "<meta http-equiv='refresh' content='0; url=http://192.168.0.233/gayeon_index.html'>";
mysqli_close($conn);


?>
