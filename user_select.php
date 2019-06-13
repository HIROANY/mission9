<?php

//0. ログイン認証
session_start();

if(!isset($_SESSION["chk_ssid"]) || 
$_SESSION["chk_ssid"] != session_id()){
    echo "LOGIN Error!";
    exit();
}else{
    session_regenerate_id(true);
    $_SESSION["chk_ssid"] = session_id();
}

//1. DB接続
include "soccer_funcs.php";
$pdo = db_con();

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_user_table");
$status = $stmt->execute();

//３．データ表示
$view = "";
if ($status == false) {
    sqlError($stmt);
} else {
    //Selectデータの数だけ自動でループしてくれる
    //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {

        $view .= '<p>----------------------------------------</p>';
        $view .= '<table>';
        $view .= '<tr><td>id</td><td>'.$result["id"].'</td></tr>';
        $view .= '<tr><td>名前</td><td>'.$result["name"].'</td></tr>';
        $view .= '<tr><td>ID</td><td>'.$result["lid"].'</td></tr>';
        $view .= '<tr><td>PS</td><td>'.$result["lpw"].'</td></tr>';
        $view .= '<tr><td>管理権限フラグ　：</td><td>'.$result["kanri_flg"].'</td></tr>';
        $view .= '<tr><td>アクティブフラグ：</td><td>'.$result["life_flg"].'</td></tr>';
        $view .= '</table>';

      if($_SESSION["kanri_flg"]=="0"){ 
        $view .= ' ';
        $view .= '<a href="user_detail.php?id='.$result["id"].'">';
        $view .= "[更新]";
        $view .= '</a>';
        
        $view .= ' ';
        $view .= '<a href="user_delete.php?id='.$result["id"].'">';
        $view .= "[削除]";
        $view .= '</a>';
      }
    }

}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ユーザー一覧表示</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <a class="navbar-brand" href="user_index.php">管理者登録画面</a>
      <a class="navbar-brand" href="soccer_select.php">選手情報一覧</a>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div>
    <div class="container jumbotron"><?=$view?></div>
</div>
<!-- Main[End] -->

</body>
</html>
