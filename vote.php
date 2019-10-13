<?php
include 'setup.php';

try {
    $pdo = new PDO('mysql:host='. $db['host'] .';dbname='. $db['dbname'] .';charset=utf8mb4',$db['username'],$db['password'],
        array(PDO::ATTR_EMULATE_PREPARES => false));
} catch (PDOException $e) {
    exit('データベース接続失敗。'.$e->getMessage());
}

if($_GET['id']) {
    if(empty($_COOKIE['vote'])) {
        $sql = "SELECT * FROM ". $db['table'] ." where `". $db['table'] ."`.`id` = ".$_GET['id'];

        $res = $pdo->query($sql);
        foreach( $res as $key ) {
            if ($key['vote'] === '0') {
                $votes = 1;
            }
            else {
                $votes = $key['vote'] + 1;
            }
        }

        $stmt = $pdo -> prepare("UPDATE `". $db['table'] ."` SET `vote` = (:vote) WHERE `gohan`.`id` = (:id)");
        $stmt->bindParam(':vote', $votes, PDO::PARAM_STR);
        $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_STR);

        $stmt->execute();

        $h1 = '投票が完了しました';
        $p = '1日1回投票できます。また投票してね!';

        setcookie('vote','yes',time()+60*60*24*1);

    }
    else {
        $h1 = 'すでに投票済みです';
        $p = '1日(24時間)に1回投票できます。また投票してね!';
    }
}
else {
    $h1 = 'エラー';
    $p = 'IDが指定されていません。';
    if($_GET['admin'] === 'clear') {
        setcookie('vote','',time()-1);
        $h1 = '管理者向け';
        $p = 'Cookieを削除しました。';
    }
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="Refresh" content="5;URL=https://morino.party/event/gohan/">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP:400,900" rel="stylesheet">
    <script defer="" src="https://use.fontawesome.com/releases/v5.5.0/js/all.js" integrity="sha384-GqVMZRt5Gn7tB9D9q7ONtcp4gtHIUEW/yG7h98J7IpE3kpi+srfFyyB/04OV6pG0" crossorigin="anonymous"></script>
    <title>Vote</title>
</head>
<body>

<style>
    body {
        font-family: 'Noto Sans JP',-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
        height: 100vh;
        background-color: #10c3b3;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    div {
        font-size: 100px;
        color: white;
        text-align: center;
        max-width: 500px;
    }
    h1 {
        font-size: 2rem;
        font-weight: bold;
    }
    p {
        font-size: 1rem;
    }
    p.notice {
        margin-top: 30px;
        margin-bottom: 30px;
        padding: 5px;
        background-color: white;
        color: #10c3b3;
    }
</style>

<div>
    <i class="fas fa-thumbs-up"></i>
    <h1><?= $h1 ?></h1>
    <p><?= $p ?></p>
    <p class="notice">5秒後イベントページへ推移します</p>
    <p>もりのパーティ</p>
</div>


</body>