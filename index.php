<?php
$playlist = json_decode(file_get_contents("playlist.json"), true)["playlist"];

if (count($playlist) == 0) {
    echo "هیچ ویدیویی در شبکه وجود ندارد.";
    exit;
}

// محاسبه مجموع زمان ویدیوها
$totalDuration = 0;
$durations = [];

foreach ($playlist as $video) {
    $info = shell_exec("ffprobe -v error -show_entries format=duration -of csv=p=0 uploads/$video");
    $dur = intval($info);
    $durations[] = $dur;
    $totalDuration += $dur;
}

// زمان فعلی
$now = time();
$mod = $now % $totalDuration;

// پیدا کردن ویدیو فعلی
$currentIndex = 0;
$acc = 0;

for ($i = 0; $i < count($durations); $i++) {
    if ($mod < $acc + $durations[$i]) {
        $currentIndex = $i;
        $startAt = $mod - $acc;
        break;
    }
    $acc += $durations[$i];
}

$currentVideo = $playlist[$currentIndex];
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>شبکه Mani TV</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>

<video id="player" controls autoplay>
    <source src="uploads/<?php echo $currentVideo; ?>" type="video/mp4">
</video>

<script>
let player = document.getElementById("player");
player.currentTime = <?php echo $startAt; ?>;
</script>

</body>
</html>
