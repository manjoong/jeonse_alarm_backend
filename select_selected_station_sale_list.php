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


//    $SelectStationList = "SELECT * FROM  selected_station WHERE user_id = '$_GET[id]'";
//    $selected_station_list = mysqli_query($con, $SelectStationList);
//
//    $data_selected_station = array();
//
//    if ($selected_station_list) {
//        while ($row=mysqli_fetch_array($selected_station_list)) {
//            array_push($data_selected_station,array('user_id'=>$row[0],'station_id'=>$row[1],'kor_stn_name'=>$row[2],'type'=>$row[3],'created_dt'=>$row[4]));
//        }
//        header('Content-Type: application/json; charset=utf8');
//        $selected_station_json = json_encode($data_selected_station, JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
//
//		// echo $selected_station_json; // => 출력되는 값이 이 코드로 하여금 front로 전송
//
//	} else {
//        echo "SQL문 처리중 에러 발생 : ";
//        echo mysqli_error($con);
//    }
//////////////////////////////////////////////////////////////

//    $selected_station_json_decode = json_decode($selected_station_json, true);  //selecte_Station 테이블의 해당 유저가 선택한 db

    // echo count($selected_station_json_decode);

    // foreach ($selected_station_json_decode as $row) {
    //     echo $row['user_id'];
    //     echo ' , ';
    //     echo $row['created_dt'];
    //     echo '<br />';
    // }

    



    /* select data */
    // 1. 실행할 쿼리문을 작성합니다.
    $SaleListSQL = "SELECT a.*, b.kor_stn_name
                    FROM
                        (SELECT * FROM sale WHERE (station, type) IN (SELECT station_id, type FROM selected_station WHERE user_id = '$_GET[id]')) a JOIN selected_station b
                    ON a.station = b.station_id AND a.type = b.type AND user_id = '$_GET[id]' AND a.create_dt > b.created_dt
                    ORDER BY a.create_dt DESC";
    $result_sale_list = mysqli_query($con, $SaleListSQL);


    // 출력할 데이터를 저장할 배열변수 선언
    // 데이터는 json-array 형식으로 출력할 것임 (일반적으로 이렇게 함)
    $data = array();
    $count = 0;

    if ($result_sale_list) {
            // echo $row_selecte_station['type'], $row_selecte_station['station_id'], $row_selecte_station['created_dt'] ;
        while ($row=mysqli_fetch_array($result_sale_list)) {
//            foreach ($selected_station_json_decode as $row_selecte_station){
//                if ($row_selecte_station['type'] == $row[6] && $row_selecte_station['station_id'] == $row[7] && strtotime($row_selecte_station['created_dt']) <= strtotime($row[8])){
                    $count = $count + 1;
                    array_push($data,array('id'=>$row[0],'name'=>$row[1],'naver_id'=>$row[2],'price'=>$row[3],'img_link'=>$row[4],'naver_link'=>$row[5],'type'=>$row[6],'station'=>$row[7],'create_dt'=>$row[8],'flrInfo'=>$row[9], 'direction'=>$row[10], 'lat'=>$row[11], 'lng'=>$row[12], 'bildNm'=>$row[13], 'rltrNm'=>$row[14],'kor_stn_name'=>$row[15], 'count'=>$count));
//                }
//            }
        }
        header('Content-Type: application/json; charset=utf8');
        $sale_list_json = json_encode($data, JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);

		echo $sale_list_json; // => 출력되는 값이 이 코드로 하여금 front로 전송

	} else {
        echo "SQL문 처리중 에러 발생 : ";
        echo mysqli_error($con);
    }



    // echo count(json_decode($sale_list_json, true));




    


    // DB 연동을 종료 합니다
    mysqli_close($con);
?>