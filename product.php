<?php
require "./assets/Helper/dataBase.php"; //"./Helper/dataBase.php";
require "./assets/Helper/helpers.php";
global $db;
if (!(isset($_SESSION['username']))) {
  header("location:./login.php");
}


$sql = "SELECT * FROM units ";
$stmt = $db->prepare($sql);
$stmt->execute();
$units = $stmt->fetchAll();

$sql = "SELECT * FROM categories ";
$stmt = $db->prepare($sql);
$stmt->execute();
$categories = $stmt->fetchAll();


if (isset($_POST['submit'])) {
  $errors = [];
  date_default_timezone_set('Iran');

  $sql = "SELECT * FROM products where product_name=?";
  $stmt = $db->prepare($sql);
  $stmt->execute([$_POST['product_name']]);
  $products = $stmt->fetch();


  if ($products == null) {
    $token = 1;
    $sql = "INSERT INTO products SET product_name=?,product_serial=?,category_id=?,unit_id=? ";
    $stmt = $db->prepare($sql);
    $stmt->execute([$_POST['product_name'], $_POST['product_serial'], $_POST['category_id'], $_POST['unit_id']]);
  } else {
    $token = 0;
    $errors[] = "این کالا در سیستم موجود می باشد";
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

    <div class="flex wrapper">
      <div class="title">
        فرم تعریف کالا
      </div>

      <div class="form form-group was-validated ">
        <form method="POST" action="">
          <div class="input-field">
            <div class="mb-3">
              <label class="form-label"> نام کالا</label>
              <input type="text" placeholder="نام کالا" name="product_name" required>
              <div class="invalid-feedback">
                <span> نام کالا را وارد کنید </span>
              </div>

            </div>
          </div>

          <div class="input-field">
            <div class="mb-3">
              <label class="form-label"> سریال کالا </label>
              <input type="text" placeholder="سریال کالا" name="product_serial" required>
              <div class="invalid-feedback">
                <span> سریال کالا را وارد کنید </span>
              </div>
            </div>
          </div>

          <div class="input-field">
            <div class="mb-3">
              <label class="form-label"> واحد شمارش</label>
              <div class="custom_select">
                <select name="unit_id" required>
                  <option>لطفا یکی از واحدهای زیر را انتخاب فرمایید</option>
                  <?php foreach ($units as $unit) : ?>
                    <option value="<?= $unit->unit_id ?>" class="inputBox"><?= $unit->unit_name ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>

          <div class="input-field">
            <div class="mb-3">
              <label> دسته بندی کالا</label>
              <div class="custom_select">
                <select name="category_id" required>
                  <option>لطفا یکی از دسته بندی های زیر را انتخاب فرمایید</option>
                  <?php foreach ($categories as $categori) : ?>
                    <option value="<?= $categori->category_id ?>" class="inputBox">
                      <?= $categori->category_name ?>
                    </option>
                  <?php endforeach; ?>
                </select>

              </div>
            </div>
          </div>

          <div class="input-field">
            <input type="submit" value="ثبت واحد کالا" class="btn btn-success" name="submit" id="submit">
          </div>
          <?php
          if (isset($_POST['submit'])  && $token == 1) {
            echo "
        <script>
        setTimeout(function() {
            swal('کالای {$_POST['product_name']} اضافه شد','تا لحظاتی دیگر به لیست کالاها منتقل می شوید', 'success')
        }, 1);
        window.setTimeout(function() {
            window.location.replace('./productlist.php');
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