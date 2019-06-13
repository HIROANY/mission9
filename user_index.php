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

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>管理者登録</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="user_select.php">管理者情報一覧</a></div>
    <div class="navbar-header"><a class="navbar-brand" href="soccer_select.php">選手情報一覧</a></div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="post" action="user_insert.php">
  <div class="jumbotron">
   <fieldset>
    <legend>【管理者情報登録】</legend>
     <label>🔸名前：<input type="text" name="name"></label><br>
     <label>🔸ID　：<input type="text" name="lid"></label><br>
     <label>🔸PS　：<input type="password" name="lpw"></label><br>
     <label>🔸管理権限フラグ　　：<input type="text" name="kanri_flg">※0:admin 1:player 2:viewer</label><br>
     <label>🔸アクティブフラグ　：<input type="text" name="life_flg">※0:inactive 1:active</label><br>
     <br>

     <?php if($_SESSION["kanri_flg"]=="0"){ ?>
     <input type="submit" value="送信">
     <?php } ?>
    </fieldset>
  </div>
</form>
<!-- Main[End] -->

</body>
</html>