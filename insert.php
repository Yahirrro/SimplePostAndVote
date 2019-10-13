<?php
include 'setup.php';

FormEncode($_POST); //←これでPOSTデータ内が全てUTF-8化されます
function FormEncode(&$post){
    if ( isset($post['enc']) ){
        return;
    }
    //どのエンコーディングか判定
    $enc = mb_detect_encoding($post['enc']);
    $default_enc = "UTF-8";
    foreach ($post as &$value) {
        EncodeCore($value,$default_enc,$enc);
    }
    unset($value);
}
function EncodeCore( &$value , $default_enc , $enc){
    if( is_array($value)){
        //配列の場合は再帰処理
        foreach ($value as &$value2) {
            EncodeCore($value2 , $default_enc , $enc);
        }
    }else if( $enc != $default_enc){
        //文字コード変換
        $value = mb_convert_encoding( $value , $default_enc , $enc ) ;
    }
}
mb_internal_encoding("UTF-8");
try {
    $pdo = new PDO('mysql:host='. $db['host'] .';dbname='. $db['dbname'] .';charset=utf8mb4',$db['username'],$db['password'],
        array(PDO::ATTR_EMULATE_PREPARES => false));
} catch (PDOException $e) {
    exit('データベース接続失敗。'.$e->getMessage());
}
if($_POST['body']) {
    if($_POST['body2']) {
        $stmt = $pdo->prepare("INSERT INTO ". $db['table'] ." (name, uuid, body, body2) VALUES (:name, :uuid, :body, :body2)");
        $stmt->bindParam(':name', $_POST['name'], PDO::PARAM_STR);
        $stmt->bindParam(':uuid', $_POST['uuid'], PDO::PARAM_STR);
        $stmt->bindParam(':body', $_POST['body'], PDO::PARAM_STR);
        $stmt->bindParam(':body2', $_POST['body2'], PDO::PARAM_STR);
        $stmt->execute();
        echo '投稿しました!こちらから確認してください: https://morino.party/event/gohan';
    }
    else {
        echo 'こんな感じで入力してください : /gohan (欲しいごはん名) (欲しいエンチャント)';
    }
}
else {
    echo 'こんな感じで入力してください : /gohan (欲しいごはん名) (欲しいエンチャント)';
}