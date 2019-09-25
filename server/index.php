<?php

ob_start('ob_gzhandler');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
    header('Access-Control-Allow-Headers: token, Content-Type');
    header('Access-Control-Max-Age: 1728000');
    header('Content-Length: 0');
    header('Content-Type: text/plain');
    die();
}

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');


include_once "db.php";
include_once "awardConf.php";

sleep(3);

$data = json_decode(file_get_contents("php://input"), true);

$awardAry = array();
foreach ($arry as $k => $v) {
    for ($i = 1; $i <= $v['oddsRatio']; $i++) {
        $awardAry[] = array(
            'award' => $v['award'],
            'num' => $k,
        );
    }
}

$countaward = count($awardAry);
$Ratio = rand(0, ($countaward - 1));

$result = array();

$get = $conn->query("select * from winnersList where ip='".$_SERVER['REMOTE_ADDR']."' ");

if ($get->num_rows == 0) {
    $conn->query("INSERT INTO winnersList (ip,award,dateSave) VALUES ('" . $_SERVER['REMOTE_ADDR'] . "','" . $awardAry[$Ratio]['award'] . "','" . date('Y-m-d H:i:s') . "')");
    $result = $awardAry[$Ratio];
    $result['status'] = 1;
    $result['msg'] = "شما برنده ".$awardAry[$Ratio]['award']." شدید . لطفا شماره موبایل خود را نیز ثبت کنید";

} else {

    if (strlen($data['mobile'])>2){

        $conn->query("UPDATE winnersList SET mobile='".trim($data['mobile'])."',sex='".trim($data['sex'])."' WHERE ip='".$_SERVER['REMOTE_ADDR']."' ");
        $result['status'] = 2;
        $result['msg'] = "شماره ثبت شد";

    }else{

        $result['status'] = -1;
        $result['msg'] = "شما قبلا در قرعه کشی شرکت کرده اید";

    }



}


$conn->close();


echo json_encode($result);