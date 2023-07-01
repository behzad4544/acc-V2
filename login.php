<?php
require "./assets/Helper/dataBase.php";
require "./assets/Helper/helpers.php";
global $db;
$token = false;
if (isset($_SESSION['username'])) {
    header("location:menu.php");
}
$errors = [];
if (isset($_POST['submit'])) {
    if (isset($_POST['username']) && !(empty($_POST['username']))) {
        $username = $_POST['username'];
    } else {
        $errors[] = 'لطفا نام کاربری خود را وارد کنید';
    }
    if (isset($_POST['password']) && !(empty($_POST['password']))) {
        $password = $_POST['password'];
        $sql = "select * from users where user_name=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        if ($user === false) {
            $errors[] = 'نام کاربری یا پسورد شما در سامانه وجود ندارد';
        } else {
            if (password_verify($password, $user->user_password)) {
                $token = true;
                $_SESSION['user_id'] = $user->user_id;
                $_SESSION['username'] = $user->user_name;
                $_SESSION['permition'] = $user->permition_id;
                if (isset($_POST['check']) && $_POST['check'] == 1) {
                    setcookie('username', $user->user_name, time() + 7200);
                    setcookie('password', $password, time() + 7200);
                } else {
                    setcookie('username', $user->user_name, time() - 7200);
                    setcookie('password', $password, time() - 7200);
                }
            } else {
                $errors[] = 'نام کاربری یا پسورد شما در سامانه وجود ندارد';
            }
        }
    } else {
        $errors[] = 'لطفا رمز خود را وارد کنید';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>loginpage</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel='stylesheet' href='./assets/css/sweet-alert.css'>
    <link rel="stylesheet" href="./assets/css/bootstrap5.min.css">
    <script src="./assets/JS/bootstrap5.bundle.min.js"></script>





</head>

<body class="login">
    <div class="form-area">
        <div class="cont">
            <div class="row single-form g-0">
                <div class="col-sm-12 col-lg-6">
                    <div class="left">
                        <h2><span> سامانه جامع حسابداری </span></h2>
                    </div>
                </div>


                <!-- <section class="bg-light my-0 px-2">
                    <?php if (isset($errors)) : ?>
                    <?php foreach ($errors as $error) : ?>
                    <small class="text-danger"><?= $error . '<br>' ?></small>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </section> -->


                <div class="col-sm-12 col-lg-6">
                    <div class="right">
                        <i class="fa fa-cart-left"></i>
                        <form method="POST" action="">
                            <div class="form-group was-validated">
                                <div class="mb-3">
                                    <label for="username" class="form-label"> نام کاربری </label>
                                    <input type="text" class="form-control" id="username" name="username" required
                                        <?php
                                                                                                                    if (isset($_COOKIE['username']) && !(empty($_COOKIE['username']))) : ?>
                                        value="<?= $_COOKIE['username'] ?>" <?php endif; ?>>
                                    <div class="invalid-feedback">
                                        <span> نام کاربری خود را وارد کنید </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group was-validated">
                                <div class="mb-3">
                                    <label for="password" class="form-label"> کلمه عبور </label>
                                    <input type="password" class="form-control" id="password" name="password" required
                                        <?php
                                                                                                                        if (isset($_COOKIE['password']) && !(empty($_COOKIE['password']))) : ?>
                                        value="<?= $_COOKIE['password'] ?>" <?php endif; ?>>
                                    <div class="invalid-feedback">
                                        لطفا پسوورد خود را وارد کنید
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="check" name="check" value="1">
                                <label for="check" class="form-check-label"> مرا بخاطر بسپار </label>
                            </div>
                            <input class="btn btn-success w-100" name="submit" type="submit" value="ورود">
                            <?php
                            if ($token) {
                                echo "
                <script>
            setTimeout(function() {
                swal('عزیز خوش آمدید {$user->user_name}','تا لحظاتی دیگر به داشبورد منتقل می شوید','success')
            }, 1);
            window.setTimeout(function() {
                window.location.replace('./menu.php');
            }, 3000);
            </script>
            ";
                            }
?>
                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>
    <script src="./assets/JS/jquery-3.3.1.slim.min.js"></script>
    <script src='./assets/JS/sweet-alert.min.js'></script>
</body>

</html>