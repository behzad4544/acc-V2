<?php
require "./assets/Helper/dataBase.php"; //"./Helper/dataBase.php";
require "./assets/Helper/helpers.php";
global $db;
if (!(isset($_SESSION['username']))) {
    header("location:./login.php");
}
if($_SESSION['permition'] == '1') {


    $sql = "SELECT * FROM permitions";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $permitions = $stmt->fetchAll();

    if (isset($_POST['submit'])) {
        $errors = [];
        date_default_timezone_set('Iran');
        $sql = "SELECT * FROM users where user_name=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$_POST['user_name']]);
        $person = $stmt->fetch();

        if ($person == null) {
            if ($_POST['user_password'] === $_POST['user_password_two']) {
                $pass_hash = password_hash($_POST['user_password'], PASSWORD_DEFAULT);
                $sql = "SELECT * FROM permitions WHERE permition_id=? ";
                $stmt = $db->prepare($sql);
                $stmt->execute([$_POST['permition_id']]);
                $permision = $stmt->fetch();
                $token = 1;
                $sql = "INSERT INTO users SET user_name=?,user_firstName=?,user_email =?,user_password=?,permition_id=? ";
                $stmt = $db->prepare($sql);
                $stmt->execute([$_POST['user_name'], $_POST['user_firstName'], $_POST['user_email'], $pass_hash, $_POST['permition_id']]);
            } else {
                $token = 0;
                $errors[] = "رمزها یکسان نمی باشد";
            }
        } else {
            $token = 0;
            $errors[] = "این کاربر در سیستم موجود می باشد";
        }
    }
} else {

    header("location:./menu.php");
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/bootstrap5.min.css">
    <link rel='stylesheet' href='./assets/css/sweet-alert.css'>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>

<body class="product">

    <div class="d-flex" id="wrapper">

        <!-- sidebar starts here -->

        <!-- sidebar ends here -->

        <?php
        require_once "./template/sidebar.php";
require_once "./template/header.php";
?>

        <div class="container">
            <form action="" method="POST" class="buyform form-group was-validated ">
                <h2> فرم تعریف کاربر </h2>
                <div class="content">
                    <div class="input-box">
                        <label for="name" class="userfirstname"> نام کاربر </label>
                        <input type="text" placeholder="نام کاربری را وارد کنید" name="user_name" required>
                        <div class="invalid-feedback">
                            <span> نام کاربری را وارد کنید </span>
                        </div>
                    </div>
                    <div class="input-box">
                        <label for="productname" class="userlastname">نام و نام خانوادگی کاربر </label>
                        <input type="text" placeholder="نام و نام خانوادگی را وارد کنید " name="user_firstName"
                            required>
                        <div class="invalid-feedback">
                            <span> نام و نام خانوادگی کاربر را وارد کنید</span>
                        </div>
                    </div>
                    <div class="input-box">
                        <label for="price" class="email"> ایمیل </label>
                        <input type="text" placeholder="ایمیل را وارد کنید" name="user_email" required>
                        <div class="invalid-feedback">
                            <span> ایمیل را وارد کنید </span>
                        </div>
                    </div>
                    <div class="input-box">
                        <div class="mb-3">
                            <label class="form-label access"> نقش کاربر</label>
                            <div class="custom_select">
                                <select name="permition_id" required>
                                    <option value="">لطفا یکی از دسترسی های زیر را انتخاب فرمایید</option>
                                    <?php foreach ($permitions as $permition) : ?>
                                    <option value="<?= $permition->permition_id ?>" class="inputBox">
                                        <?= $permition->permition_name ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="input-box">
                        <label for="discount" class="pass"> کلمه عبور </label>
                        <input type="password" placeholder="پسورد را وارد کنید" name="user_password" required>
                        <div class="invalid-feedback">
                            <span> کلمه عبور را وارد کنید </span>
                        </div>
                    </div>

                    <div class="input-box">
                        <label for="discount" class="confirm"> تایید کلمه عبور </label>
                        <input type="password" placeholder="پسورد را دوباره وارد کنید" name="user_password_two"
                            required>
                        <div class="invalid-feedback">
                            <span> تایید کلمه عبور </span>
                        </div>
                    </div>






                    <div class="input-box">
                        <input type="submit" value="ثبت کاربر" class="btn btn-success" name="submit" id="submit">
                    </div>



                </div>
                <?php
        if (isset($_POST['submit']) && $token == 1) {
            echo "   
        <script>
        setTimeout(function() {
            swal('یک کاربر با نام کاربری {$_POST['user_firstName']} و سطح دسترسی {$permision->permition_name} ثبت شد','تا لحظاتی دیگر به لیست کاربران منتقل می شوید', 'success')
        }, 1);
        window.setTimeout(function() {
            window.location.replace('./usertable.php');
        }, 5000);
        </script>
        ";
        }
?>
            </form>
        </div>
    </div>


    <script src="./assets/JS/bootstrap5.bundle.min.js"></script>
    <script src='./assets/JS/sweet-alert.min.js'></script>

    <script>
    var el = document.getElementById("wrapper")
    var toggleButton = document.getElementById("menu-toggle")

    toggleButton.onclick = function() {
        el.classList.toggle("toggled")
    }
    </script>

</body>