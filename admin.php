<?php
$password = "1234"; // رمز ورود

session_start();

if (isset($_POST["pass"])) {
    if ($_POST["pass"] == $password) {
        $_SESSION["admin"] = true;
    }
}

if (!isset($_SESSION["admin"])) {
?>
<form method="post">
    <input type="password" name="pass" placeholder="رمز ورود">
    <button>ورود</button>
</form>
<?php
exit;
}
?>

<h2>پنل مدیریت شبکه</h2>

<form action="upload.php" method="post" enctype="multipart/form-data">
    <input type="file" name="video">
    <button>آپلود ویدیو</button>
</form>

<hr>

<h3>لیست ویدیوها</h3>
<ul>
<?php
$playlist = json_decode(file_get_contents("playlist.json"), true)["playlist"];
foreach ($playlist as $v) {
    echo "<li>$v</li>";
}
?>
</ul>
