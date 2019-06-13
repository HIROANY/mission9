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

//1. id受け取り
$id = $_GET["id"];

//2. DB接続
include "soccer_funcs.php";
$pdo = db_con();

//3．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_user_table WHERE id=:id");//$idではなく、バインド変数:idを使う
$stmt->bindValue(":id", $id, PDO::PARAM_INT);//DBにとって危ない文字をbindValueで排除
$status = $stmt->execute();

//4．データ表示
$view = "";
if ($status == false) {
    sqlError($stmt);
}else{
  $row = $stmt->fetch();//一番上のレコードを取得する

  //管理者以外更新不可
  if($_SESSION["kanri_flg"]=="0"){
    $readonly = "";
  }else{
    $readonly = " readonly";
  }
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>管理者情報更新</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="user_select.php">管理者情報一覧はこちら</a></div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="post" action="user_update.php">
  <div class="jumbotron">
   <fieldset>
    <legend>【管理者情報更新】</legend>
     <label>🔸名前：<input type="text" name="name" value="<?=$row["name"]?>"<?=$readonly?>></label><br>
     <label>🔸ID　：<input type="text" name="lid" value="<?=$row["lid"]?>"<?=$readonly?>></label><br>
     <label>🔸PS　：<input type="text" name="lpw" value="<?=$row["lpw"]?>"<?=$readonly?>></label><br>
     <label>🔸管理権限フラグ　：<input type="text" name="kanri_flg" value="<?=$row["kanri_flg"]?>"<?=$readonly?>>※0:admin 1:player 2:viewer</label><br>
     <label>🔸アクティブフラグ：<input type="text" name="life_flg" value="<?=$row["life_flg"]?>"<?=$readonly?>>※0:inactive 1:active</label><br>

     <!-- 管理者以外更新ボタン非表示 -->
     <?php if($_SESSION["kanri_flg"]=="1"){ ?>
     <input type="submit" value="更新">
     <?php } ?>
     <input type="hidden" name="id" value="<?=$row["id"]?>">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->

</body>
</html>
