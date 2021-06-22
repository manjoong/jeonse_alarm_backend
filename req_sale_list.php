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
    // 1. 실행할 쿼리문을 작성합니다.
    $selectSQL = "select * from sale";
    $result = mysqli_query($con, $selectSQL);

    // 출력할 데이터를 저장할 배열변수 선언
    // 데이터는 json-array 형식으로 출력할 것임 (일반적으로 이렇게 함)
    $data = array();
    
    if ($result) {
        while ($row=mysqli_fetch_array($result)) {
            array_push($data,array('id'=>$row[0],'name'=>$row[1],'naver_id'=>$row[2],'price'=>$row[3],'img_link'=>$row[4],'naver_link'=>$row[5],'type'=>$row[6],'station'=>$row[7], 'create_dt'=>$row[8]));
        }
        header('Content-Type: application/json; charset=utf8');
        $json = json_encode(array("datas"=>$data), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);

		echo $json; // => 출력되는 값이 이 코드로 하여금 android로 전송된다..

	} else {
        echo "SQL문 처리중 에러 발생 : ";
        echo mysqli_error($con);
    }

    // DB 연동을 종료 합니다
    mysqli_close($con);
?>