<?php
require "./assets/Helper/dataBase.php"; //"./Helper/dataBase.php";
require "./assets/Helper/helpers.php";
global $db;
if (!(isset($_SESSION['username']))) {
    header("location:./login.php");
}
if($_SESSION['permition'] == '1' || $_SESSION['permition'] =='2') {
    if (isset($_POST['submit'])) {
        $errors = [];
        date_default_timezone_set('Iran');

        $sql = "SELECT * FROM personaccount where cust_name=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$_POST['cust_name']]);
        $person = $stmt->fetch();

        if ($person == null) {
            $token = 1;
            $sql = "INSERT INTO personaccount SET account_type=?,cust_name=?,cust_codemeli=?,cust_address=?,cust_mobile=?,total_credit=? ";
            $stmt = $db->prepare($sql);
            $stmt->execute([$_POST['account_type'], $_POST['cust_name'], $_POST['cust_codemeli'], $_POST['cust_address'], $_POST['cust_mobile'], $_POST['total_credit']]);
        } else {
            $token = 0;
            $errors[] = "این شخص / طرف حساب در سیستم موجود می باشد";
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
    <script src="./assets/JS/bootstrap5.bundle.min.js"></script>
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

        <div class="flex wrapper">
            <div class="title">
                فرم تعریف طرف حساب
            </div>

            <div class="form form-group was-validated ">
                <form method="POST" action="">
                    <div class="content">
                        <div class="radiobox" dir="rtl">
                            <label class="accounttype"> نوع حساب:</label>
                            <input type="radio" class="" name="account_type" value="1" required> اشخاص
                            <input type="radio" class="" name="account_type" value="3" required> حساب ها
                            <div class="invalid-feedback">
                                <span> نوع طرف حساب را انتخاب کنید </span>
                            </div>

                        </div>
                    </div>

                    <div class="content">
                        <div class="input-box">
                            <label for="cust_name" class="accountname"> نام شخص/حساب</label>
                            <input type="text" name="cust_name" required>
                            <div class="invalid-feedback">
                                <span> نام شخص/حساب را وارد کنید </span>
                            </div>
                        </div>

                        <div class="input-box">
                            <label for="cust_codemeli" class="identify"> کدملی/شناسه ملی </label>
                            <input type="text" name="cust_codemeli" required>
                            <div class="invalid-feedback">
                                <span> کدملی/شناسه ملی را وارد کنید </span>
                            </div>
                        </div>



                        <div class="input-box">
                            <label for="cust_address" class="accountaddress"> آدرس </label>
                            <input type="text" name="cust_address">
                            <div class="invalid-feedback">
                                <span> آدرس را وارد کنید</span>
                            </div>
                        </div>

                        <div class="input-box">
                            <label for="cust_mobile" class="phone"> شماره همراه </label>
                            <input type="text" name="cust_mobile" required>

                        </div>

                        <div class="input-box">
                            <label for="discount" class="accountaccount"> مانده حساب</label>
                            <input type="text" placeholder="در صورتی که شخص به شما بدهکار است مانده را منفی وارد کنید"
                                name="total_credit" required>
                            <div class="invalid-feedback">
                                <span> مانده حساب را وارد کنید </span>
                            </div>
                        </div>



                        <div class="input-box">
                            <input class="btn btn-success" type="submit" value="ثبت طرف حساب / صندوق" class="btn"
                                name="submit" id="submit">
                        </div>



                    </div>
                    <?php
            if (isset($_POST['submit']) && $token == 1 && $_POST['account_type'] == 1) {
                echo "
        <script>
        setTimeout(function() {
            swal('طرف حساب {$_POST['cust_name']} اضافه شد','تا لحظاتی دیگر به کاردکس اشخاص منتقل می شوید', 'success')
        }, 1);
        window.setTimeout(function() {
            window.location.replace('./personlist.php');
        }, 5000);
        </script>
        ";
            }
?>

                    <?php
if (isset($_POST['submit'])  && $token == 1 && $_POST['account_type'] == 3) {
    echo "
        <script>
        setTimeout(function() {
            swal('صندوق / بانک {$_POST['cust_name']} اضافه شد','تا لحظاتی دیگر به کاردکس صندوق/بانک منتقل می شوید', 'success')
        }, 1);
        window.setTimeout(function() {
            window.location.replace('./sandogh.php');
        }, 5000);
        </script>
        ";
}
?>
                </form>
            </div>
        </div>
        <script src="./assets/JS/jquery-3.3.1.slim.min.js"></script>
        <script src='./assets/JS/sweet-alert.min.js'></script>

        <script>
        var el = document.getElementById("wrapper")
        var toggleButton = document.getElementById("menu-toggle")

        toggleButton.onclick = function() {
            el.classList.toggle("toggled")
        }
        </script>
    </div>
</body>