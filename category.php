<?php
require "./assets/Helper/dataBase.php"; //"./Helper/dataBase.php";
require "./assets/Helper/helpers.php";
global $db;
if (!(isset($_SESSION['username']))) {
    header("location:./login.php");
}

if (isset($_POST['submit'])) {
    $errors = [];
    date_default_timezone_set('Iran');
    $category=$_POST['category_product'];
    $sql = "SELECT * FROM categories WHERE category_name =? ";
    $stmt = $db->prepare($sql);
    $stmt->execute([$category]);
    $categories = $stmt->fetch();
    if($categories == null) {
        $token = 1;
        $sql = "INSERT INTO categories SET category_name=? ";
        $stmt = $db->prepare($sql);
        $stmt->execute([$category]);
    } else {
        $token = 0;
        $errors[] = "این دسته بندی در سیستم موجود می باشد";
    }

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

        <div class="flex wrappercount">
            <div class="title">
                فرم تعریف دسته بندی جدید کالا
            </div>

            <div class="form form-group was-validated ">
                <form method="POST" action="">
                    <div class="input-field">
                        <div class="mb-3">
                            <label class="form-label"> نام دسته بندی جدید </label>
                            <input type="text" placeholder="واحد کالا" name="category_product" required>
                            <div class="invalid-feedback">
                                <span> نام دسته بندی کالا را وارد کنید </span>
                            </div>

                        </div>
                    </div>



                    <div class="input-field">
                        <input type="submit" value="ثبت دسته بندی" class="btn btn-success" name="submit" id="submit">
                    </div>
                    <?php
            if (isset($_POST['submit']) && $token == 1) {
                echo "
        <script>
        setTimeout(function() {
            swal('دسته بندی {$_POST['category_product']} اضافه شد','تا لحظاتی دیگر به داشبورد منتقل می شوید', 'success')
        }, 1);
        window.setTimeout(function() {
            window.location.replace('./menu.php');
        }, 5000);
        </script>
        ";
            }
?>
                </form>


            </div>
        </div>
    </div>
    <script src="./assets/JS/jquery-3.3.1.slim.min.js"></script>
    <script src="./assets/JS/bootstrap5.bundle.min.js"></script>
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