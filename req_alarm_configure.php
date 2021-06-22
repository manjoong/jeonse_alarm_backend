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


    /* insert data */
    // 1. 안드로이드에서 post로 날린 값을 받아 변수에 저장합니다
    $user_id = $_GET["user_id"];
    $select = $_GET["select"];


 
    // 2. 실행할 쿼리문을 작성합니다. => mysqli_query(실행할 Db, 실행할 query)
    $updateSQL = "UPDATE user SET alarm='$select' WHERE id = '$user_id'";
    $result = mysqli_query($con, $updateSQL);



    if ($result) {
        header('Content-Type: application/json; charset=utf8');
        $json = json_encode(array("result"=>"success"), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
		echo $json; // => 출력되는 값이 이 코드로 하여금 android로 전송된다..
	} else {
        echo "SQL문 처리중 에러 발생 : ";
        echo mysqli_error($con);
    }

    // DB 연동을 종료 합니다
    mysqli_close($con);
?>