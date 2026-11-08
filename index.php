<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $file = $_FILES["avatar"];

    if ($file["error"] != 0) {
        die("آپلود ناموفق");
    }

    if ($file["size"] > 2 * 1024 * 1024) {
        die("حجم فایل بیشتر از ۲ مگابایت است");
    }

    $ext = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
    $allowed = ["jpg", "jpeg", "png"];

    if (!in_array($ext, $allowed)) {
        die("فقط عکس مجاز است");
    }

    if (getimagesize($file["tmp_name"]) === false) {
        die("فایل واقعاً عکس نیست");
    }

    $fileName = uniqid() . "." . $ext;
    move_uploaded_file($file["tmp_name"], "uploads/" . $fileName);

    $avatarPath = "uploads/" . $fileName;
    
    $name = $_POST['name'];
    $job  = $_POST['job'];
    $bio  = $_POST['bio'];
}

?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>رزومه ساز</title>
<link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;600;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="wrap">

<h1> رزومه ساز</h1>
<p class="sub">اطلاعاتت رو وارد کن، رزومه‌ات ساخته می‌شه</p>

<div class="form-box">
<form method="post" enctype="multipart/form-data">

<label>عکس پروفایل</label>
<input type="file" name="avatar" accept="image/*" required>

<label>نام و نام خانوادگی</label>
<input type="text" name="name" placeholder="مثلاً علی رضایی" required>

<label>عنوان شغلی</label>
<input type="text" name="job" placeholder="مثلاً برنامه‌نویس وب" required>

<label>توضیحات</label>
<textarea name="bio" placeholder="درباره خودت بنویس..." required></textarea>

<button name="submit" type="submit">ساخت رزومه</button>
</form>
</div>
    <div class="resume">
        <div class="resume-cover"></div>
        <div class="resume-body">
            <?php if($_SERVER['REQUEST_METHOD'] === "POST"): ?>
            <img class="resume-avatar" src="<?php echo $avatarPath; ?>" alt="عکس">

            <h2 class="resume-name"><?php echo htmlspecialchars($name);?></h2>
            <p class="resume-job"><?php echo htmlspecialchars($job) ;?></p>

            <p class="resume-bio">
                <?php echo htmlspecialchars($bio);?>
            </p>

            <?php endif;?>
    </div>
    </div>
</div>

</body>
</html>