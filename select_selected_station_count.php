<?php
    error_reporting(E_ALL);
    ini_set('display_errors',1);

    // include('dbcon.php');
    $con=mysqli_connect("localhost:3306", "dev_user", "1q2w3e!@#", "app_db");

    // mysqli_connect()에 대한 마지막 호출에 대한 오류 코드 값을 반환한다.
    // echo mysqli_connect() 에서 0은 오류가 발생하지 않았음을 의미한다
    if (mysqli_connect_errno($con)) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    /* select data */
    // 1. 실행할 쿼리문을 작성합니다.";
    $selectSQL = "SELECT * FROM selected_station WHERE user_id = '$_GET[id]'";
    $result = mysqli_query($con, $selectSQL);
    echo mysqli_num_rows($result);

    // DB 연동을 종료 합니다
    mysqli_close($con);
?>