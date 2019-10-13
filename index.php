<?php
include 'setup.php';
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="common/css/design.css">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP:400,900" rel="stylesheet">
    <script defer="" src="https://use.fontawesome.com/releases/v5.5.0/js/all.js" integrity="sha384-GqVMZRt5Gn7tB9D9q7ONtcp4gtHIUEW/yG7h98J7IpE3kpi+srfFyyB/04OV6pG0" crossorigin="anonymous"></script>

    <title><?= $page['title'] ?> - <?= $page['site_name'] ?></title>
    <link rel="dns-prefetch" href="//s.w.org">
    <meta property="og:title" content="<?= $page['title'] ?> - <?= $page['site_name'] ?>">
    <meta property="og:description" content="<?= $page['og_description'] ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= 'https://' . $page['domain'] ?>">
    <meta property="og:image" content="<?= $page['og_image'] ?>">
    <meta property="og:site_name" content="<?= $page['site_name'] ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="<?= $page['twitter'] ?>">
    <meta property="og:locale" content="ja_JP">


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</head>
<body>

<div class="background_color"></div>

<header class="top">
    <div class="g_logo">
        <a href=""><img id="logo" src="<?= $page['logo'] ?>"><h1><?= $page['site_name'] ?></h1></a>
    </div>
    <div class="container title">
        <h1><i class="fas fa-utensils"></i><?= $page['title'] ?></h1>
        <p><?= $page['main_description'] ?></p>
    </div>
    <img class="user" src="<?= $page['main_image'] ?>" alt="">
</header>

<section id="content">
    <div class="container-fluid">


<?php
$mysqli = new mysqli( $db['host'], $db['username'], $db['password'], $db['dbname']);

if( $mysqli->connect_errno ) {
    echo $mysqli->connect_errno . ' : ' . $mysqli->connect_error;
}

$mysqli->set_charset('utf8mb4');

$sql = 'SELECT * FROM '. $db['table'] .' ORDER BY id DESC';
$res = $mysqli->query($sql);


if( $res ) {
    foreach ($res as $key) {
        echo '<article><div class="tanzaku"><h2>' . $key["body"] . '</h2><h2 class="sub">' . $key["body2"] . '</h2><p>';
        echo '<img src="https://crafatar.com/renders/head/' . $key["uuid"] . '?size=64&overlay" alt="">' . $key["name"] . '</p>';
        echo '</div><div class="good"><div class="d-flex justify-content-end align-items-center"><a href="vote.php?id=' . $key["id"] . '" class="vote" value="' . $key["id"] . '">';
        echo '<i class="fas fa-thumbs-up"></i></a>';
        echo '<p id="post_1">' . $key["vote"] . '</p></div></div></article>';
    }
}
$mysqli->close();

?>
    </div>
</section>
<script src="https://unpkg.com/magic-grid/dist/magic-grid.min.js"></script>
<script>
    let magicGrid = new MagicGrid({
        container: ".container-fluid", // 必須。各カード型要素を囲むボックスを指定する
        static: true, // 静的コンテンツの場合は必須。デフォルトは「false」
        gutter: 30, // 各要素間のマージンを指定。デフォルトは「25（単位は『px』）」
        useMin: true, // グリッドにアイテムを揃えるときに短い列を優先させる。デフォルトは「false」
        animate: true, // 各要素を配置する際にアニメーション処理させる。デフォルトは「false」
    });
    magicGrid.listen();
</script>



</body></html>