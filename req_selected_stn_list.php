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


    $SelectStationList = "SELECT * FROM  selected_station WHERE user_id = '$_GET[id]' ORDER BY created_dt DESC";
    $selected_station_list = mysqli_query($con, $SelectStationList);

    $data_selected_station = array();

    if ($selected_station_list) {
        while ($row=mysqli_fetch_array($selected_station_list)) {
            array_push($data_selected_station,array('user_id'=>$row[0],'station_id'=>$row[1],'kor_stn_name'=>$row[2],'type'=>$row[3],'created_dt'=>$row[4]));
        }
        header('Content-Type: application/json; charset=utf8');
        $selected_station_json = json_encode($data_selected_station, JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);

		echo $selected_station_json; // => 출력되는 값이 이 코드로 하여금 front로 전송

	} else {
        echo "SQL문 처리중 에러 발생 : ";
        echo mysqli_error($con);
    }
    // DB 연동을 종료 합니다
    mysqli_close($con);
?>