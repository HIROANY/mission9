<?php

session_start();

//1. soccer_login.phpからPOSTでID/PSを受け取る
$lid = $_POST["lid"];
$lpw = $_POST["lpw"];

//2. DB接続
include "soccer_funcs.php";
$pdo = db_con();

//３．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_user_table WHERE lid=:lid AND lpw=:lpw");
$stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
$stmt->bindValue(':lpw', $lpw, PDO::PARAM_STR);

$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
    //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
    $error = $stmt->errorInfo();
    exit("SQLエラーです。".$error[2]);
}else{
    //５．soccer_login.phpへリダイレクト　この処理がないと画面が切り替わらない
    header("Location: soccer_login.php");
}

//5. 抽出データ数を取得
$val = $stmt->fetch();//1レコードだけ取得する

//6. が移動レコードがあればSESSIONに値を代入
if($val["id"] != ""){
    $_SESSION["chk_ssid"] = session_id();
    $_SESSION["kanri_flg"] = $val["kanri_flg"];
    $_SESSION["name"] = $val["name"];
    //login可の場合、soccer_select.phpに画面遷移
    header("Location: soccer_select.php");
}else{
    //login不可の場合、soccer_login.phpに画面遷移
    header("Location: soccer_login.php");
}

//7. 処理終了
exit();

?>