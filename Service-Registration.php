<?php

require_once("include/db_connection.php");

$db_handle = new Database();

if (!empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['email']) && !empty($_POST['phone']) && !empty($_POST['service'])) {

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $description = $_POST['description'];
    $service = $_POST['service'];

    $sql = "INSERT INTO `user` (`first_name`, `last_name`, `email`, `phone`, `description`) VALUES ('$first_name', '$last_name', '$email', '$phone', '$description')";
    mysqli_query($db_handle->conn, $sql) or trigger_error(mysql_error($db_handle->conn), E_USER_ERROR);

    $query = "SELECT * FROM `service` WHERE name='$service'";
    $service = mysqli_fetch_assoc(mysqli_query($db_handle->conn, $query));
    $service_id = $service['service_id'];

    $query = "SELECT * FROM `user` WHERE email='$email'";
    $user = mysqli_fetch_assoc(mysqli_query($db_handle->conn, $query));
    $user_id = $user['user_id'];

    $sql = "INSERT INTO `order` (`user_id`, `service_id`) VALUES ('$user_id', '$service_id')";
    mysqli_query($db_handle->conn, $sql) or trigger_error(mysql_error($db_handle->conn), E_USER_ERROR);

    $success = 1;

} else {
    $success = 0;
}

mysqli_close($db_handle->conn);

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Title</title>

    <script src="https://kit.fontawesome.com/a076d05399.js"></script>

</head>

<body>

<section class="form_section">

    <div class="form-header">
        <a href="index.html" title="home">خانه</a>
    </div>

    <?php
        if ($success == 1) {
    ?>

    <div class="form-accepted">
        درخواست شما با موفقیت ثبت شد!
    </div>

    <script>
        setTimeout(function(){ window.location.href = "index.html"; }, 4000);
    </script>

    <?php
        } else {
    ?>

    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" class="form">

        <label class="form-title">ثبت سفارش</label>

        <div class="form-collapse box" style="margin-top: 10px">
            <select name="service" class="form-control form-select">
                <option>webdesign</option>
                <option>نمونه ۲</option>
                <option>نمونه ۳</option>
                <option>نمونه ۴</option>
            </select>
        </div>

        <div class="form-collapse">
            <input placeholder="نام" class="form-control form-collapse-block" type="text" name="first_name" required>
        </div>

        <div class="form-collapse">
            <input placeholder="نام خانوادگی" class="form-control form-collapse-block" type="text" name="last_name"
                   required>
        </div>

        <div class="form-collapse">
            <input placeholder="ایمیل" class="form-control form-collapse-block" type="email" name="email" required>
        </div>

        <div class="form-collapse">
            <input placeholder="شماره همراه" class="form-control form-collapse-block" type="text" name="phone" required>
        </div>

        <div class="form-collapse">
            <div class=" fas fa-pen" style="padding: 5px; "><label class="form-collapse-title">توضیحات</label></div>
            <textarea class="form-control form-textarea" type="text" name="description"></textarea>
        </div>

        <div class="form-collapse" style="align-items: center">
            <input class="form-submit" type="submit" value="ثبت">
        </div>

    </form>

    <?php
        }
    ?>

</section>

</body>

</html>
