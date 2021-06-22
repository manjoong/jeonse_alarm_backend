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


   

    /* insert data */
    // 1. 안드로이드에서 post로 날린 값을 받아 변수에 저장합니다
    // $station_id = $_GET["station_id"];
    // $type = $_GET["type"];
   


 





    // $url =  "http://3.34.189.107:30080/api/v2/job_templates/9/launch/";
    $url =  "http://localhost:30080/api/v2/job_templates/9/launch/";
    $data = array(
        "extra_vars" => array (
            "station_id" => $_GET["station_id"],
            "prd_type" => $_GET["prd_type"]
        )
    );
    $data_string = json_encode($data);
    $res = post_request($url, $data_string);
    // echo($res)

?>