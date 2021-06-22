<?php

    function post_request($url, $data) {
        // Convert the data array into URL Parameters like a=b&foo=bar etc.
        // $data = http_build_query($data);

        // parse the given URL
        $url = parse_url($url);

        if ($url['scheme'] != 'http') {
            return "Error:Only HTTP request are supported!";
        }

        // extract host and path:
        $host = $url['host'];
        $path = $url['path'];
        $res = '';

        // open a socket connection on port 80 - timeout: 300 sec
        if ($fp = fsockopen($host, 30080, $errno, $errstr, 300)) {
            $reqBody = $data;
            $reqHeader = "POST $path HTTP/1.1\r\n" . "Host: $host\r\n";
            $reqHeader .= "Content-type: application/json\r\n"
            ."Authorization: Basic ". base64_encode("admin:password") . "\r\n"
            . "Content-length: " . strlen($reqBody) . "\r\n"
            . "Connection: close\r\n\r\n";

            /* send request */
            fwrite($fp, $reqHeader);
            fwrite($fp, $reqBody);

            while(!feof($fp)) {
                $res .= fgets($fp, 1024);
            }

            fclose($fp);
        } else {
            return "Error:Cannot Connect!";
        }

        // split the result header from the content
        $result = explode("\r\n\r\n", $res, 2);

        $header = isset($result[0]) ? $result[0] : '';
        $content = isset($result[1]) ? $result[1] : '';

        return $content;
    }

    // header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
        

    error_reporting(E_ALL);
    ini_set('display_errors',1);

    // include('dbcon.php');
    $con=mysqli_connect("localhost:3306", "dev_user", "1q2w3e!@#", "app_db");

    // mysqli_connect()에 대한 마지막 호출에 대한 오류 코드 값을 반환한다.
    // echo mysqli_connect() 에서 0은 오류가 발생하지 않았음을 의미한다
    if (mysqli_connect_errno($con)) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    // $jsonString = file_get_contents('php://input');
    // echo $jsonString;
    // echo $sale_id;
    // echo $user_id;
    // echo $type;
    // echo $_POST["sale_id"];
    // print_r($_POST);
 

    /* insert data */
    // 1. 안드로이드에서 post로 날린 값을 받아 변수에 저장합니다
    $user_id = $_GET["user_id"];
    $station_id = $_GET["station_id"];
    $type = "OPST";
    $kor_stn_name = $_GET["kor_stn_name"];


 
    // 2. 실행할 쿼리문을 작성합니다. => mysqli_query(실행할 Db, 실행할 query)
    $insertSQL = "insert ignore into selected_station (user_id, station_id, type, kor_stn_name) values ('$user_id', '$station_id', '$type', '$kor_stn_name')";
    $result = mysqli_query($con, $insertSQL);

    // if ($result) {
    //     echo "Success!!";
    // } else {
    //     print_r($result);
    //     echo "Fail insert data to Database...";
    // }

    // mysqli_close($con);


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

    $url =  "http://localhost:30080/api/v2/job_templates/9/launch/";
    $data = array(
        "extra_vars" => array (
            "station_id" => $_GET["station_id"],
            "prd_type" => "OPST"
        )
    );
    $data_string = json_encode($data);
    $res = post_request($url, $data_string);
    // echo($res)

        

?>