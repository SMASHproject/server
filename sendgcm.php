<?php

    $regid = "APA91bGa0wcGL6Bd5nv6Et35jCrTYibDjEMdD7Qxqdyfx1qLgwyGzAhmhheHEwhsWnRNVrxc_ZSSK8nfkEWyQECfJ8GOOzBmEQ9Nr3YP9sYjV62GpySvGBKEUjsTxXKppDmUMhHVXVrK";

    // 헤더 부분
    $headers = array(
            'Content-Type:application/json',
            'Authorization:key=AIzaSyAbuhbDpRnafKSfveiCvcoij5oB7-_ZKuE'
            );

    // 푸시 내용, data 부분을 자유롭게 사용해 클라이언트에서 분기할 수 있음.
    $arr = array();
    $arr['data'] = array();
    $arr['data']['title'] = 'Alarm test';
    $arr['data']['message'] = 'Check this alarm';
    $arr['registration_ids'] = array();
    $arr['registration_ids'][0] = $regid;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send');
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($arr));
     $response = curl_exec($ch);
     curl_close($ch);

     // 푸시 전송 결과 반환.
     $obj = json_decode($response);

     var_dump($obj);
     // 푸시 전송시 성공 수량 반환.
     $cnt = $obj->{"success"};

     echo $cnt;
?>
