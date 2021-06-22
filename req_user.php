<?php
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
    // print_r($jsonString);
    // print_r($_POST);
 
    // if(!empty($_POST["email"])){
    //     $email = $_POST["email"];
    // }else{
    //     $email="";
    // }

    // if(!empty($_POST["profile_url"])){
    //     $profile_url = $_POST["profile_url"];
    // }else{
    //     $profile_url = "";
    // }

    if(!empty($_POST["rec_sale_id"])){
        $rec_sale_id = $_POST["rec_sale_id"];
    }else{
        $rec_sale_id = "";
    }
    //필수값들
    // $channel = $_POST["channel"];
    $token_id = $_POST["token_id"];
    

    $insertSQL = "insert ignore into user (token_id) values ('$token_id')";
    $result = mysqli_query($con, $insertSQL);

    if ($rec_sale_id != ""){
        $updateSQL = "UPDATE user SET rec_sale_id='$rec_sale_id' WHERE token_id = '$token_id'";
        $result = mysqli_query($con, $updateSQL);
    }



    $userReqSQL = "SELECT * FROM user WHERE token_id = '$token_id'";
    $user_data = mysqli_query($con, $userReqSQL);
    
    $data = array(); //결괏값이 저장될 공간

    if ($user_data) {
        while ($row=mysqli_fetch_array($user_data)) {
            array_push($data,array('id'=>$row[0],'token_id'=>$row[1],'registed_dt'=>$row[2],'rec_sale_id'=>$row[3],'alarm'=>$row[4]));
        }
        header('Content-Type: application/json; charset=utf8');
        $json = json_encode(array("datas"=>$data), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);

		echo $json; // => 출력되는 값이 이 코드로 하여금 android로 전송된다..

	} else {
        echo "SQL문 처리중 에러 발생 : ";
        echo mysqli_error($con);
    }


    // if ($result) {
    //     header('Content-Type: application/json; charset=utf8');
    //     $json = json_encode(array("result"=>"success"), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
	// 	echo $json; // => 출력되는 값이 이 코드로 하여금 android로 전송된다..
	// } else {
    //     echo "SQL문 처리중 에러 발생 : ";
    //     echo mysqli_error($con);
    // }

    // DB 연동을 종료 합니다
    mysqli_close($con);
