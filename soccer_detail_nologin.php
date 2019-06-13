<?php

// //0. ログイン認証
// session_start();

// if(!isset($_SESSION["chk_ssid"]) || 
// $_SESSION["chk_ssid"] != session_id()){
//     echo "LOGIN Error!";
//     exit();
// }else{
//     session_regenerate_id(true);
//     $_SESSION["chk_ssid"] = session_id();
// }

//1. id受け取り
$id = $_GET["id"];

//2. DB接続
include "soccer_funcs.php";
$pdo = db_con();

//3．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_soccer_table WHERE id=:id");//$idではなく、バインド変数:idを使う
$stmt->bindValue(":id", $id, PDO::PARAM_INT);//DBにとって危ない文字をbindValueで排除
$status = $stmt->execute();

//4．データ表示
$view = "";
if ($status == false) {
    sqlError($stmt);
}
$row = $stmt->fetch();//一番上のレコードを取得する

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ユーザー情報更新</title>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <style>main{padding-top: 100px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
<!-- navbar-inverse で黒系ナビゲーションの指定をしています。-->
<!-- navbar-fixed-top でヘッダー固定の指定をしています。-->
<div class="container">
<div class="navbar-header">
<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
<span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span>
<span class="icon-bar"></span> </button>
<!--button~はウインドウのサイズが780px以下になった時に表示されます。-->
<a class="navbar-brand" href="#">GIANT KILLING(仮)</a>
<!--こちらにサイト名を入れます。-->
</div>
<div class="collapse navbar-collapse">
<ul class="nav navbar-nav">
<li><a href="soccer_index.php">登録画面</a></li>
<li><a href="soccer_select.php">一覧画面</a></li>
<li class="active"><a href="#">更新画面</a></li>
<li><a href="tachometer.php">コンディションメーター</a></li>
</ul>
</div>
<!--/.nav-collapse -->
</div>
</div>
</header>
<!-- Head[End] -->

<main>
<form class="form-horizontal" method="post" action="soccer_update.php">

    <!-- 練習日時 -->
    <div class="form-group">
        <label for="inputDate"class="col-sm-2 control-label">練習日時</label>
        <div class="col-sm-2">
        <input type="date" class="form-control" id="inputDate" name="sdate"  value="<?=$row["sdate"]?>">
        </div>
    </div>

    <!-- 選手名 -->
    <div class="form-group">
        <label for="inputPlayerName" class="col-sm-2 control-label">選手名</label>
        <div class="col-sm-2">
        <input type="text" class="form-control" id="inputPlayerName" name="name"  value="<?=$row["name"]?>">
        </div>
    </div>

    <!-- 背番号 -->
    <div class="form-group">
        <label for="inputPlayerNumber" class="col-sm-2 control-label">背番号</label>
        <div class="col-sm-2">
        <input type="text" class="form-control" id="inputPlayerNumber" name="number" value="<?=$row["number"]?>">
        </div>
    </div>

    <!-- ポジション -->
    <div class="form-group">
        <label for="inputPlayerPosition" class="col-sm-2 control-label">ポジション</label>
        <div class="col-sm-10">
            <label class="radio-inline"><input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="FW">FW</label>
            <label class="radio-inline"><input type="radio" name="inlineRadioOptions" id="inlineRadio2" value="MF">MF</label>
            <label class="radio-inline"><input type="radio" name="inlineRadioOptions" id="inlineRadio3" value="DF">DF</label>
            <label class="radio-inline"><input type="radio" name="inlineRadioOptions" id="inlineRadio4" value="GK">GK</label>
        </div>
    </div>

    <!-- VAS -->
    <div class="form-group">
        <label for="inputPlayerVas" class="col-sm-2 control-label">VAS</label>
        <div class="col-sm-5">
            <input type="range" class="form-control" id="inputPlayerVas" name="vas" min="0" max="100" step="1" value="<?=$row["vas"]?>">
        </div>
    </div>

    <!-- 跳躍力 -->
    <div class="form-group">
        <label for="inputPlayerJump" class="col-sm-2 control-label">跳躍力</label>
        <div class="col-sm-2">
        <input type="text" class="form-control" id="inputPlayerJump" name="jump" min="1" max="100" value="<?=$row["jump"]?>">
        </div>
    </div>


    <!-- 練習強度（選手） -->
    <div class="form-group">
        <label for="inputPlayerTraining" class="col-sm-2 control-label">練習強度（選手）</label>
        <div class="col-sm-2">
        <input type="text" class="form-control" id="inputPlayerTraining" name="training" min="1" max="10" value="<?=$row["training"]?>">
        </div>
    </div>

    <!-- 練習強度（監督） -->
    <div class="form-group">
        <label for="inputPlayerTraining2" class="col-sm-2 control-label">練習強度（監督）</label>
        <div class="col-sm-2">
        <input type="text" class="form-control" id="inputPlayerTraining2" name="training2" min="1" max="10" value="<?=$row["training2"]?>">
        </div>
    </div>

    <!-- 送信 -->
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-default">更新</button>
        <input type="hidden" name="id" value="<?=$row["id"]?>">
        </div>
    </div>

</form>

</main>
<!-- Main[End] -->

</body>
</html>
