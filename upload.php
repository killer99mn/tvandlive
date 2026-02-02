<?php
if (!isset($_FILES["video"])) {
    die("فایلی انتخاب نشده.");
}

$target = "uploads/" . basename($_FILES["video"]["name"]);

if (move_uploaded_file($_FILES["video"]["tmp_name"], $target)) {

    $data = json_decode(file_get_contents("playlist.json"), true);
    $data["playlist"][] = basename($_FILES["video"]["name"]);
    file_put_contents("playlist.json", json_encode($data));

    echo "ویدیو با موفقیت آپلود شد.";
    echo "<br><a href='admin.php'>بازگشت</a>";
} else {
    echo "خطا در آپلود.";
}
?>
